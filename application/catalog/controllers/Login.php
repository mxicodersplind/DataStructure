<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Cookie
 *
 * @author Mxicoders
 */
class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // load facebok and twitter library
        $this->load->library('Facebook');
        $this->load->library('twitteroauth');
        // set the page title
        $this->data['title'] = $this->data['site_name'] . ': LogIn';

        if ($this->session->userdata('user_id')) {
            redirect('Dashboard', 'refresh');
        }
        // load header footer
        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    // load the login page with the social media credentials and url setup like the facebook,google,linkedin and twitter
    public function index() {
        $this->data['facebookAuthURL'] = $this->facebook->login_url();
        $provider = new League\OAuth2\Client\Provider\LinkedIn([
            'clientId' => $this->data['LinkedInClientId'],
            'clientSecret' => $this->data['LinkedInClientSecret'],
            'redirectUri' => base_url() . 'Login/linkedInlogin',
        ]);
        $state = $this->password_generate(10);
        $options = [
            'state' => $state,
            'scope' => ['r_liteprofile', 'r_emailaddress']
        ];
        $this->data['linkedinAuthURL'] = $provider->getAuthorizationUrl($options);
        $this->session->set_userdata('oauth2state', $provider->getState());

        $clientID = $this->data['GoogleClientId'];
        $clientSecret = $this->data['GoogleClientSecret'];
        $redirectUri = base_url() . 'Login/googlelogin';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        $this->data['googleAuthURL'] = $client->createAuthUrl();

        // Get existing token and token secret from session 
        $access_token = $this->data['TwitterApiKey'];
        $access_token_secret = $this->data['TwitterApiSecret'];

        $connection = new Abraham\TwitterOAuth\TwitterOAuth($this->data['TwitterApiKey'], $this->data['TwitterApiSecret'], $access_token, $access_token_secret);
        $content = $connection->get("account/verify_credentials");

        $url = $connection->url("oauth/authorize", ["oauth_token" => $this->data['TwitterApiKey']]);
        $this->data['twitterAuthURL'] = $url;

        // Fresh authentication 
        $twitteroauth = $this->twitteroauth->authenticate($sessToken, $sessTokenSecret);
        $requestToken = $twitteroauth->getRequestToken();
        // If authentication is successful (http code is 200) 
        if ($twitteroauth->http_code == '200') {
            // Get token info from Twitter and store into the session 
            $this->session->set_userdata('token', $requestToken['oauth_token']);
            $this->session->set_userdata('token_secret', $requestToken['oauth_token_secret']);
            // Twitter authentication url 
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
            $content = $connection->get("account/verify_credentials");
            $twitterUrl = $twitteroauth->getAuthorizeURL($requestToken['oauth_token']);
            $this->data['twitterAuthURL'] = $twitterUrl;
        } else {
            // Internal authentication url 
            $this->data['twitterAuthURL'] = base_url() . 'Login';
            $this->data['error_msg'] = 'Error connecting to twitter! try again later!';
        }

        $this->load->view('login/index', $this->data);
    }

    //google reCaptcha chellange check
    public function captcha_chellange() {
        if ($this->input->is_ajax_request()) {
            $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_POST, true);
            $data = array(
                'secret' => $this->data['general_setting'][5]['setting_value'],
                'response' => $this->input->post('g-recaptcha-response'),
                'remoteip' => $this->input->ip_address()
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            $resultObj = json_decode($result);
            curl_close($ch);
            //print_r($resultObj);die();
            if (isset($resultObj->success) && $resultObj->success) {
                echo 'true';
            } else {
                echo 'false';
            }
            die();
        }
    }

    // otp screen load 
    public function loadotp($userid, $email) {
        $this->data['userid'] = base64_decode($userid);
        $this->data['email'] = $email;
        $this->session->set_flashdata('error', 'OTP is not verified. Please Verify OTP and try again to Login.');
        $this->load->view('login/otp', $this->data);
    }

    //check the login credentials and authorize user for dashboard
    //php password_hash function is used for password hashing
    public function authenticate() {
        // validation check 
        $this->form_validation->set_rules('loginemail', 'email', 'required');
        $this->form_validation->set_rules('loginpassword', 'password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please follow validation rules!');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        } else {
            $userName = $this->input->post('loginemail');
            // check the enter email is find or not
            $checkEmail = $this->common->select_data_by_condition('user', array('email' => $userName, "is_deleted" => '0'), '*', '', '', '', '', array());

            if (empty($checkEmail)) {
                $this->session->set_flashdata('error', 'Invalid Email Address.');
                redirect('Login', 'refresh');
            }
            $password = sha1($this->input->post('loginpassword'));

            // check the enter password is find or not
            $checkPassword = $this->common->select_data_by_condition('user', array('password' => $password, "is_deleted" => '0'), '*', '', '', '', '', array());
            if (empty($checkPassword)) {
                $this->session->set_flashdata('error', 'Invalid Password.');
                redirect('Login', 'refresh');
            }

            $str = '';
            $str = strval(strtolower(($userName)));
            $con_arr = array('email' => $userName);
            $checkAuth = $this->db
                    ->where('LOWER(email)', $str)
                    ->where('user_type', 0)
                    ->where('is_deleted', '0')
                    ->get('user')
                    ->result_array();

            //$checkAuth = $this->common->select_data_by_condition('user', $con_arr, '*', '', '', '', '', array());
            if (!empty($checkAuth)) {

                if ($checkAuth[0]['otp'] != "") {
                    $userid = $checkAuth[0]['id'];
                    $email = $userName;
                    $this->session->set_flashdata('error', 'OTP is not verified. Please Verify OTP and try again to Login.');
                    redirect("Login/loadotp/" . base64_encode($userid) . "/" . $email, "refresh");
                    //$this->load->view('login/otp', $this->data);
                }
                // check the user disable or enable by admin
                if ($checkAuth[0]['status'] == "Disable") {
                    $this->session->set_flashdata('error', 'You are block by admin.please contact to administrator to active.');
                    redirect('Login', 'refresh');
                }
                $hash = $checkAuth[0]['password'];
                $dbusername = $checkAuth[0]['email'];

                // check the username and password
                if ($str == $dbusername && $password === $hash) {

                    // insert the log
                    $insert_data = array(
                        'user_id' => $checkAuth[0]['id'],
                        "login_datetime" => date('Y-m-d H:i:s'),
                        "login_ip" => $this->input->ip_address(),
                        "browser" => $this->getBrowser(),
                        "operating_system" => $this->getOS(),
                        "login_type" => 'regular'
                    );
                    $this->common->insert_data_getid($insert_data, "login_log");
                    $this->session->set_userdata('user_id', $checkAuth[0]['id']);
                    $this->session->set_flashdata('add_class', true);

                    // set the session
                    if ($this->session->userdata('self_session_id')) {

                        $cookie_value = time() . uniqid() . time();
                        $insert_data_cookie = array(
                            'user_id' => $checkAuth[0]['id'],
                            'token_id' => $cookie_value
                        );
                        // setting up the cookie
                        $cookie_id = $this->common->insert_data_getid($insert_data_cookie, "cookie");
                        if ($cookie_id > 0) {
                            setcookie('<pname>-token', $cookie_value, time() + (86400 * 30 * 365), "/");
                        }
                        // load the dashboard
                        redirect('Dashboard', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Invalid username or password');
                        redirect('Login', 'refresh');
                    }
                } else {

                    $this->session->set_flashdata('error', 'Invalid username or password');
                    redirect('Login', 'refresh');
                }
            }
        }
    }

    // facebook login function
    public function facebooklogin() {

        $userData = array();
        // Authenticate user with facebook 
        if ($this->facebook->is_authenticated()) {
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
            $email = !empty($fbUser['email']) ? $fbUser['email'] : '';
            $conditions = array('email' => $email, "user_type" => 0);
            $checkAuth = $this->common->select_data_by_condition('user', $conditions, '*', '', '', '', '', array());
            if (!empty($checkAuth)) {
                $custData = array(
                    "name" => ucfirst(!empty($fbUser['first_name']) ? $fbUser['first_name'] : '') . ' ' . ucfirst(!empty($fbUser['last_name']) ? $fbUser['last_name'] : ''),
                    "modified_datetime" => date('Y-m-d H:i:s'),
                    "modified_ip" => $this->input->ip_address(),
                    "oauth_provider" => 'facebook',
                    "oauth_uid" => !empty($fbUser['id']) ? $fbUser['id'] : '',
                    "image" => !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '',
                    "link" => !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/'
                );
                $this->common->update_data($custData, "user", 'id', $checkAuth[0]['id']);
                $userID = $checkAuth[0]['id'];
            } else {
                $custData = array(
                    "name" => ucfirst(!empty($fbUser['first_name']) ? $fbUser['first_name'] : '') . ' ' . ucfirst(!empty($fbUser['last_name']) ? $fbUser['last_name'] : ''),
                    "email" => !empty($fbUser['email']) ? $fbUser['email'] : '',
                    "created_datetime" => date('Y-m-d H:i:s'),
                    "modified_datetime" => date('Y-m-d H:i:s'),
                    "created_ip" => $this->input->ip_address(),
                    "modified_ip" => $this->input->ip_address(),
                    "status" => 'Enable',
                    "email_verify" => '1',
                    "oauth_provider" => 'facebook',
                    "oauth_uid" => !empty($fbUser['id']) ? $fbUser['id'] : '',
                    "image" => !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '',
                    "link" => !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/'
                );
                $userID = $this->common->insert_data_getid($custData, "user");
            }


            // Check user data insert or update status 
            if (!empty($userID)) {
                $insert_data = array(
                    'user_id' => $userID,
                    "login_datetime" => date('Y-m-d H:i:s'),
                    "login_ip" => $this->input->ip_address(),
                    "browser" => $this->getBrowser(),
                    "operating_system" => $this->getOS(),
                    "login_type" => 'facebook'
                );
                $this->common->insert_data_getid($insert_data, "login_log");
                $this->session->set_userdata('user_id', $userID);
                $this->session->set_flashdata('add_class', true);


                // Facebook logout URL 
                $this->data['logoutURL'] = $this->facebook->logout_url();
                $cookie_value = time() . uniqid() . time();
                $insert_data_cookie = array(
                    'user_id' => $userID,
                    'token_id' => $cookie_value
                );

                $cookie_id = $this->common->insert_data_getid($insert_data_cookie, "cookie");
                if ($cookie_id > 0) {
                    setcookie('<pname>-token', $cookie_value, time() + (86400 * 30 * 365), "/");
                }
                redirect('Dashboard', 'refresh');
            } else {
                // Facebook authentication url 
                $this->data['facebookAuthURL'] = $this->facebook->login_url();
                redirect('Login', 'refresh');
            }
        }
    }

    // Linked login function
    public function linkedInlogin() {
        $provider = new League\OAuth2\Client\Provider\LinkedIn([
            'clientId' => $this->data['LinkedInClientId'],
            'clientSecret' => $this->data['LinkedInClientSecret'],
            'redirectUri' => base_url() . 'Login/linkedInlogin',
        ]);
        if (!isset($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;

            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            // Optional: Now you have a token you can look up a users profile data
            try {

                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                $email = $user->getEmail();
                $firstname = $user->getFirstName();
                $lastname = $user->getLastName();
                $auth_id = $user->getId();
                $picture = $user->getImageUrl();

                $conditions = array('email' => $email, "user_type" => 0);
                $checkAuth = $this->common->select_data_by_condition('user', $conditions, '*', '', '', '', '', array());
                if (!empty($checkAuth)) {
                    $custData = array(
                        "name" => ucfirst(!empty($firstname) ? $firstname : '') . ' ' . ucfirst(!empty($lastname) ? $lastname : ''),
                        "modified_datetime" => date('Y-m-d H:i:s'),
                        "modified_ip" => $this->input->ip_address(),
                        "oauth_provider" => 'linkedin',
                        "image" => !empty($picture) ? $picture : '',
                        "oauth_uid" => !empty($auth_id) ? $auth_id : ''
                    );
                    $this->common->update_data($custData, "user", 'id', $checkAuth[0]['id']);
                    $userID = $checkAuth[0]['id'];
                } else {
                    $custData = array(
                        "name" => ucfirst(!empty($firstname) ? $firstname : '') . ' ' . ucfirst(!empty($lastname) ? $lastname : ''),
                        "email" => !empty($email) ? $email : '',
                        "created_datetime" => date('Y-m-d H:i:s'),
                        "modified_datetime" => date('Y-m-d H:i:s'),
                        "created_ip" => $this->input->ip_address(),
                        "modified_ip" => $this->input->ip_address(),
                        "status" => 'Enable',
                        "email_verify" => '1',
                        "oauth_provider" => 'linkedin',
                        "image" => !empty($picture) ? $picture : '',
                        "oauth_uid" => !empty($auth_id) ? $auth_id : ''
                    );
                    $userID = $this->common->insert_data_getid($custData, "user");
                }

                // Check user data insert or update status 
                if (!empty($userID)) {
                    $insert_data = array(
                        'user_id' => $userID,
                        "login_datetime" => date('Y-m-d H:i:s'),
                        "login_ip" => $this->input->ip_address(),
                        "browser" => $this->getBrowser(),
                        "operating_system" => $this->getOS(),
                        "login_type" => 'linkedin'
                    );
                    $this->common->insert_data_getid($insert_data, "login_log");
                    $this->session->set_userdata('user_id', $userID);
                    $this->session->set_flashdata('add_class', true);

                    $cookie_value = time() . uniqid() . time();
                    $insert_data_cookie = array(
                        'user_id' => $userID,
                        'token_id' => $cookie_value
                    );

                    $cookie_id = $this->common->insert_data_getid($insert_data_cookie, "cookie");
                    if ($cookie_id > 0) {
                        setcookie('<pname>-token', $cookie_value, time() + (86400 * 30 * 365), "/");
                    }
                    redirect('Dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Invalid Request!');
                    redirect('Login', 'refresh');
                }
            } catch (Exception $e) {

                // Failed to get user details
                exit('Oh dear...');
            }

            // Use this to interact with an API on the users behalf
            // echo $token->getToken();
        }
    }

// google login function
    public function googlelogin() {
        $clientID = $this->data['GoogleClientId'];
        $clientSecret = $this->data['GoogleClientSecret'];
        $redirectUri = base_url() . 'Login/googlelogin';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        //  Set the scopes required for the API you are going to call
        $client->addScope("email");
        $client->addScope("profile");

        // authenticate code from Google OAuth Flow
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email = $google_account_info->email;
            $firstname = $google_account_info->givenName;
            $lastname = $google_account_info->familyName;
            $auth_id = $google_account_info->id;
            $picture = $google_account_info->picture;

            $conditions = array('email' => $email, "user_type" => 0);
            $checkAuth = $this->common->select_data_by_condition('user', $conditions, '*', '', '', '', '', array());
            if (!empty($checkAuth)) {
                $custData = array(
                    "name" => ucfirst(!empty($firstname) ? $firstname : '') . ' ' . ucfirst(!empty($lastname) ? $lastname : ''),
                    "modified_datetime" => date('Y-m-d H:i:s'),
                    "modified_ip" => $this->input->ip_address(),
                    "oauth_provider" => 'google',
                    "image" => !empty($picture) ? $picture : '',
                    "oauth_uid" => !empty($auth_id) ? $auth_id : ''
                );
                $this->common->update_data($custData, "user", 'id', $checkAuth[0]['id']);
                $userID = $checkAuth[0]['id'];
            } else {
                $custData = array(
                    "name" => ucfirst(!empty($firstname) ? $firstname : '') . ' ' . ucfirst(!empty($lastname) ? $lastname : ''),
                    "email" => !empty($email) ? $email : '',
                    "created_datetime" => date('Y-m-d H:i:s'),
                    "modified_datetime" => date('Y-m-d H:i:s'),
                    "created_ip" => $this->input->ip_address(),
                    "modified_ip" => $this->input->ip_address(),
                    "status" => 'Enable',
                    "email_verify" => '1',
                    "oauth_provider" => 'google',
                    "image" => !empty($picture) ? $picture : '',
                    "oauth_uid" => !empty($auth_id) ? $auth_id : ''
                );
                $userID = $this->common->insert_data_getid($custData, "user");
            }

            // Check user data insert or update status 
            if (!empty($userID)) {
                $insert_data = array(
                    'user_id' => $userID,
                    "login_datetime" => date('Y-m-d H:i:s'),
                    "login_ip" => $this->input->ip_address(),
                    "browser" => $this->getBrowser(),
                    "operating_system" => $this->getOS(),
                    "login_type" => 'google'
                );
                $this->common->insert_data_getid($insert_data, "login_log");
                $this->session->set_userdata('user_id', $userID);
                $this->session->set_flashdata('add_class', true);

                $cookie_value = time() . uniqid() . time();
                $insert_data_cookie = array(
                    'user_id' => $userID,
                    'token_id' => $cookie_value
                );

                $cookie_id = $this->common->insert_data_getid($insert_data_cookie, "cookie");
                if ($cookie_id > 0) {
                    setcookie('<pname>-token', $cookie_value, time() + (86400 * 30 * 365), "/");
                }
                redirect('Dashboard', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Invalid Request!');
                redirect('Login', 'refresh');
            }
        } else {
            $this->data['googleAuthURL'] = $client->createAuthUrl();

            redirect('Login', 'refresh');
        }
    }

// Twitter login function
    public function twitterlogin() {
        $userData = array();

        // Get existing token and token secret from session 
        // $sessToken = $this->session->userdata('token'); 
        // $sessTokenSecret = $this->session->userdata('token_secret');

        $sessToken = $this->data['TwitterApiKey'];
        $sessTokenSecret = $this->data['TwitterApiSecret'];

        // Get status and user info from session 
        $sessStatus = $this->session->userdata('status');
        $sessUserData = $this->session->userdata('userData');

        if (!empty($sessStatus) && $sessStatus == 'verified') {
            // Connect and get latest tweets 
            $twitteroauth = $this->twitteroauth->authenticate($sessUserData['accessToken']['oauth_token'], $sessUserData['accessToken']['oauth_token_secret']);

            $data['tweets'] = $twitteroauth->get('statuses/user_timeline', array('screen_name' => $sessUserData['username'], 'count' => 5));

            // User info from session 
            $userData = $sessUserData;
        } elseif (isset($_REQUEST['oauth_token']) && $sessToken == $_REQUEST['oauth_token']) {
            // Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name 
            $twitteroauth = $this->twitteroauth->authenticate($sessToken, $sessTokenSecret);
            $accessToken = $twitteroauth->getAccessToken($_REQUEST['oauth_verifier']);

            if ($twitteroauth->http_code == '200') {
                // Get the user's twitter profile info 
                $userInfo = $twitteroauth->get('account/verify_credentials');

                // Preparing data for database insertion 
                $name = explode(" ", $userInfo->name);
                $first_name = isset($name[0]) ? $name[0] : '';
                $last_name = isset($name[1]) ? $name[1] : '';
                $link = 'https://twitter.com/' . $userInfo->screen_name;
                $email = !empty($userInfo->screen_name) ? $userInfo->screen_name : '';

                $conditions = array('email' => $email, "user_type" => 0);
                $checkAuth = $this->common->select_data_by_condition('user', $conditions, '*', '', '', '', '', array());
                if (!empty($checkAuth)) {
                    $custData = array(
                        "name" => ucfirst(!empty($first_name) ? $first_name : '') . ' ' . ucfirst(!empty($last_name) ? $last_name : ''),
                        "modified_datetime" => date('Y-m-d H:i:s'),
                        "modified_ip" => $this->input->ip_address(),
                        "oauth_provider" => 'twitter',
                        "oauth_uid" => !empty($userInfo->id) ? $userInfo->id : '',
                        "image" => !empty($userInfo->profile_image_url) ? $userInfo->profile_image_url : '',
                        "link" => !empty($link) ? $link : 'https://twitter.com/'
                    );
                    $this->common->update_data($custData, "user", 'id', $checkAuth[0]['id']);
                    $userID = $checkAuth[0]['id'];
                } else {
                    $custData = array(
                        "name" => ucfirst(!empty($first_name) ? $first_name : '') . ' ' . ucfirst(!empty($last_name) ? $last_name : ''),
                        "email" => !empty($fbUser['email']) ? $fbUser['email'] : '',
                        "created_datetime" => date('Y-m-d H:i:s'),
                        "modified_datetime" => date('Y-m-d H:i:s'),
                        "created_ip" => $this->input->ip_address(),
                        "modified_ip" => $this->input->ip_address(),
                        "status" => 'Enable',
                        "email_verify" => '1',
                        "oauth_provider" => 'twitter',
                        "oauth_uid" => !empty($userInfo->id) ? $userInfo->id : '',
                        "image" => !empty($userInfo->profile_image_url) ? $userInfo->profile_image_url : '',
                        "link" => !empty($link) ? $link : 'https://twitter.com/'
                    );
                    $userID = $this->common->insert_data_getid($custData, "user");
                }

                // Get latest tweets 
                $data['tweets'] = $twitteroauth->get('statuses/user_timeline', array('screen_name' => $userInfo->screen_name, 'count' => 5));

                // Store the status and user profile info into session 
                // $userData['accessToken'] = $accessToken;
                // Check user data insert or update status 
                if (!empty($userID)) {
                    $insert_data = array(
                        'user_id' => $userID,
                        "login_datetime" => date('Y-m-d H:i:s'),
                        "login_ip" => $this->input->ip_address(),
                        "browser" => $this->getBrowser(),
                        "operating_system" => $this->getOS(),
                        "login_type" => 'twitter'
                    );
                    $this->common->insert_data_getid($insert_data, "login_log");
                    $this->session->set_userdata('user_id', $userID);
                    $this->session->set_flashdata('add_class', true);

                    $cookie_value = time() . uniqid() . time();
                    $insert_data_cookie = array(
                        'user_id' => $userID,
                        'token_id' => $cookie_value
                    );

                    $cookie_id = $this->common->insert_data_getid($insert_data_cookie, "cookie");
                    if ($cookie_id > 0) {
                        setcookie('<pname>-token', $cookie_value, time() + (86400 * 30 * 365), "/");
                    }

                    redirect('Dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Invalid Request!');
                    redirect('Login', 'refresh');
                }
            } else {
                $this->data['error_msg'] = 'Authentication failed, please try again later!';
                // $this->session->set_flashdata('error', 'Invalid Request!');
                redirect('Login', 'refresh');
            }
        } elseif (isset($_REQUEST['denied'])) {
            $this->data['twitterAuthURL'] = base_url() . 'Login';
            $this->data['error_msg'] = 'Twitter authentication was denied!';
        } else {
            // Unset token and token secret from the session 
            $this->session->unset_userdata('token');
            $this->session->unset_userdata('token_secret');

            // Fresh authentication 
            $twitteroauth = $this->twitteroauth->authenticate($sessToken, $sessTokenSecret);
            $requestToken = $twitteroauth->getRequestToken();

            // If authentication is successful (http code is 200) 
            if ($twitteroauth->http_code == '200') {
                // Get token info from Twitter and store into the session 
                $this->session->set_userdata('token', $requestToken['oauth_token']);
                $this->session->set_userdata('token_secret', $requestToken['oauth_token_secret']);

                // Twitter authentication url 
                $twitterUrl = $twitteroauth->getAuthorizeURL($requestToken['oauth_token']);
                $this->data['twitterAuthURL'] = $twitterUrl;
            } else {
                // Internal authentication url 
                $this->data['twitterAuthURL'] = base_url() . 'Login';
                $this->data['error_msg'] = 'Error connecting to twitter! try again later!';
            }
        }

        redirect('Login', 'refresh');
    }

    // loading google auth page
    public function google_auth() {
        $this->load->view('login/google_auth', $this->data);
    }

    // verification of the google auth

    public function verify_google_auth() {
        require_once(BASEPATH . 'Authenticator/rfc6238.php');

        $checkAuth = $this->common->select_data_by_condition('user', array('id' => $this->session->userdata('auth_user')), '*', '', '', '', '', array());

        if (TokenAuth6238::verify($checkAuth[0]['google_code'], $this->input->post('code'))) {
            $this->session->set_userdata('user_id', $this->session->userdata('auth_user'));
            redirect('Dashboard', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Verification code is invalid. Try Again.');
            redirect('Login/google_auth');
        }
    }

    // reset or change password link send from here
    public function resetPassword($id = '') {
        if ($id == '') {
            $this->session->set_flashdata('error', 'Invalid reset password link.');
            redirect('Login', 'refresh');
        }
        $this->data['userdata'] = $userdata = $this->common->select_data_by_condition('user', array('activecode' => $id), '*', '', '', '', '', array());

        if (!empty($userdata)) {
            $this->load->view('login/resetpassword', $this->data);
            return;
        }
        $this->session->set_flashdata('error', 'Invalid reset password link.');
        redirect('Login', 'refresh');
    }

    
    // update the user password from here
    public function updatePassword() {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpasswd', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('matches', '%s must match with password');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<p>', '</p>'));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        } else {
            $user_id = $this->input->post('user_id', TRUE);
            $new_password = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT);
            $updatedData = array('password' => $new_password);
            $updateResult = $this->common->update_data($updatedData, 'user', 'user_id', $user_id);
            if (!$updateResult) {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            } else {
                $this->session->set_flashdata('success', 'New password successfully updated. Please login using new password.');
                redirect('Login', 'refresh');
            }
        }
    }

    // if user can not get the email then resend email from here
    public function resend_email($email) {
        die();
        $user_info = $this->common->select_data_by_id('users', 'email', $email, '*', array());

        $name = $user_info[0]['firstname'] . ' ' . $user_info[0]['lastname'];

        $site_logo = base_url() . 'assets/images/logo1.png';
        $year = date('Y');
        $activation_link = '<a href="' . site_url('Register/verifyemail/' . urlencode($user_info[0]['verification_token'])) . '" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Confirm email address</a>';
        $mailData = $this->common->select_data_by_id('email_format', 'id', '3', '*', array());
        $subject = str_replace('%site_name%', $this->data['site_name'], $mailData[0]['subject']);
        $mailformat = $mailData[0]['emailformat'];
        $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%email%", $email, str_replace("%activation_link%", $activation_link, str_replace("%site_name%", $this->data['site_name'], str_replace("%year%", $year, stripslashes($mailformat)))))));
        $this->data['mail_header'] = '<img id="headerImage campaign-icon" src="' . $site_logo . '" title="' . $this->data["site_name"] . '" width="250" /> ';
        $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data["site_name"] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
        $mail_body = $this->load->view('mail', $this->data, true);
        $this->sendEmail($this->data['site_name'], $this->data['site_email'], $email, $subject, $mail_body);
    }

   

}
