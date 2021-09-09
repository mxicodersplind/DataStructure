
<?= $header; ?>
<style>
    label.error{
        color: red !important;
    }
</style>

<section class="dashboard-card">
    <div class="container">

        <div class="row">
            <div class="col-12">
                Login

            </div>
        </div>
        <div class="row">
            <div class="tabs-login">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Create New</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">



                        <div class="login-box">

                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success" style="margin-top:18px;">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                    <strong><?php echo $this->session->flashdata('success'); ?></strong> 
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger" style="margin-top:18px;">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                    <strong><?php echo $this->session->flashdata('error'); ?></strong> 
                                </div>
                            <?php } ?>

                            <div id="resetmessageshow" class="alert alert-danger" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong id="resetmessage"></strong> 
                            </div>




                            <?php echo form_open("Login/authenticate", array("class" => "form-horizontal", "method" => "POST", "id" => "loginfrm")); ?>



                            <div class="form-group">
                                <input type="text" class="form-control" id="loginemail" name="loginemail" placeholder="Enter email id">
                            </div>

                            <div class="form-group mt-3">
                                <input type="password" class="form-control" name="loginpassword" id="loginpassword" placeholder="Enter password">
                                <div class="mt-1 text-right">
                                    <a href="" class="text-muted frgt-password" data-toggle="modal" data-target="#ForgetModal">Forgot your
                                        password?</a>
                                </div>
                            </div>

                            <div class="mt-4 full-btn">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Login</button>
                            </div>

                            <div class="clearfix"></div>
                            <div class="mt-4 text-center">
                                <p class="signup-using">Signin with</p>

                                <div class="login-with-social-media">
                                    <ul>
                                        <li> <a href="<?php echo $facebookAuthURL; ?>"><i class="fab fa-facebook-f"></i></a></li>
                                        <li> <a href="<?php echo $twitterAuthURL; ?>"><i class="fab fa-twitter"></i></a></li>
                                        <li> <a href="<?php echo $googleAuthURL; ?>"><i class="fab fa-google"></i></a></li>
                                        <li> <a href="<?php echo $linkedinAuthURL; ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                        <div class="login-box">
                            <?php
                            $lasturl = $_SERVER['HTTP_REFERER'];

                            if ($this->session->userdata('card_session_id') && $lasturl == base_url("Dashboard/addcard")) {
                                ?>
                                <div class="row">
                                    <div class="col-12 col-lg-8 ml-auto mr-auto mb-1">
                                        <div class="multisteps-form__progress">
                                            <button class="multisteps-form__progress-btn" type="button" title="About you and company"></button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Contact Information"></button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Address Details"></button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Social Media Info"></button>
                                            <button class="multisteps-form__progress-btn  js-active" type="button" title="Card Preview"></button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php echo form_open("Register/user_register", array("class" => "form-horizontal", "method" => "POST", "id" => "rgfrm")); ?>


                            <div class="form-group">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email id">
                            </div>

                            <div class="form-group mt-3">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                            </div>

                            <div class="form-group mt-3">
                                <input type="password" class="form-control" name="cnfpassword" id="cnfpassword" placeholder="Enter confirm password">
                            </div>

                           

                            <div class="mt-4 full-btn">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" >Signup</button>
                            </div>

                            <div class="clearfix"></div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<!-- Forget Modal -->
<div class="modal fade" id="ForgetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Forgotpassword', array('class' => "login-form reset-modal", 'id' => "forgotfrm")); ?>
            <div class="modal-body">
                <div class="alert alert-success text-center mb-4" role="alert">
                    Enter your Email and instructions will be sent to you!
                </div>
                <div class="form-group">
                    <input type="email" class="form-control text-dark"  name="forgot_email" id="forgot_email" placeholder="Email Address" value="">
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Reset</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?= $footer; ?>

<script>

    $(document).ready(function () {
     
        $("#resetmessageshow").hide();
        $("#resetmessage").html(" ");
        $("#loginfrm").validate({
            rules: {
                loginemail: {
                    required: true,
                    email: true,
                },
                loginpassword: {
                    required: true,
                },
            },
            messages: {
                loginemail: {
                    required: "Email is required.",
                    email: "Enter Correct Email.",
                },
                loginpassword: {
                    required: "Password is required.",
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 10) {
            $('.header').addClass('fixed-header');
        }
        else {
            $('.header').removeClass('fixed-header');
        }
    });

    var btn = $('#button');
    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, '300');
    });


    $("#email").focusout(function () {
        var email = $('#email').val();
        $.ajax({
            url: "<?php echo base_url() . 'Login/checkpass' ?>",
            type: "POST",
            dataType: "json",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', email: email},
            catch : false,
            success: function (data) {
                if (data.status == 'success') {
                    $("#resetmessageshow").hide();
                    $("#resetmessage").html(" ");
                    //flash_alert_msg(data.msg, 'success', 3000);
                }
                else if (data.status == 'resetlink') {
                    $("#resetmessageshow").show();
                    $("#resetmessage").html("This account is set up using " + data.provider + " account, please <a href='" + data.msg + "'>click here</a> to set new password.");
                    //window.location.href = data.msg;
                }
                else {
                    //flash_alert_msg(data.msg, 'error', 3000);
                }

            }
        });
    });

</script>


<script>

    $(document).ready(function () {
        $("#rgfrm").validate({
            rules: {
                fullname: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    maxlength: 16,
                    minlength: 6
                },
                cnfpassword: {
                    required: true,
                    equalTo: "#password",
                },
               
            },
            messages: {
                fullname: {
                    required: "Full Name is required.",
                },
                email: {
                    required: "Email is required.",
                    email: "Enter Correct Email.",
                },
                password: {
                    required: "Password is required.",
                },
                cnfpassword: {
                    required: "Confirm Password is required.",
                    equalTo: "Do not match Password."
                },
               
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });

</script>