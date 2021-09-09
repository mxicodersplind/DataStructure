<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="theme-color" content="#0A4D83" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <meta name="title" content="<?= $seo_title; ?>">
        <meta name="description" content="<?= $seo_description; ?>">
        <meta name="keywords" content="<?= $seo_keyword; ?>" >
        <link rel="shortcut icon" href="<?php echo $this->config->item('common_assets_path'); ?>../images/favicon.ico">
        <title><?= $title; ?></title>

        <!-- Bootstrap -->
        <link href="<?php echo $this->config->item('common_assets_path'); ?>css/bootstrap-4.0.0.css" rel="stylesheet">
        <!-- Custom CSS-->
        <link href="<?php echo $this->config->item('common_assets_path'); ?>css/style.css" rel="stylesheet">



        <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
        <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
        <script src="https://unpkg.com/dropzone"></script>
        <script src="<?php echo $this->config->item('common_assets_path'); ?>js/cropper.js"></script>
    </head>

    <body>
        <style>

            .image_area {
                position: relative;
            }

            img {
                display: block;
                max-width: 100%;
            }

            .preview {
                overflow: hidden;
                width: 160px; 
                height: 160px;
                margin: 10px;
                border: 1px solid red;
            }

            .modal-lg{
                max-width: 1000px !important;
            }

            .overlay {
                position: absolute;
                bottom: 10px;
                left: 0;
                right: 0;
                background-color: rgba(255, 255, 255, 0.5);
                overflow: hidden;
                height: 0;
                transition: .5s ease;
                width: 100%;
            }

            .image_area:hover .overlay {
                height: 50%;
                cursor: pointer;
            }

            .text {
                color: #333;
                font-size: 20px;
                position: absolute;
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                text-align: center;
            }

        </style>

        <style>
            label.error {
                color: red !important;
            }
            a { color: inherit; } 
            ol.list-port {
                padding: 13px;
                font-size: 14px;
                margin-bottom: 0;
                padding-left: 15px;
            }
            ol.list-port li {
                margin-bottom: 9px;
            }
            span.y-link {
                font-size: 14px;
                clear: both;
            }
            span.y-link a { color: #0A4D83}
            .uploaded-pic .col-4.float-left img { object-fit: cover; }

            .user-info .user-pic img { height: 160px !important;
                                       width: 160px;
                                       object-fit: cover;}
            .blogo .center-t-b img {  object-fit: cover; width: 100px; height: 100px }
            .banner-img .img-fluid {  object-fit: cover;  }

        </style>

        <section class="dashboard-card p-0">
            <div class="container">
                <div class="row">
                    <div class="multisteps-form">

                        <!--form panels-->
                        <div class="">
                            <?php echo form_open_multipart("Dashboard/addcardprofiledata", array("class" => "multisteps-form__form mt-1", "method" => "POST", "id" => "rgfrm", "enctype" => "multipart/form-data")); ?>
                            <div class="col-12 col-lg-8 m-auto login-box preview-box pb-5">


                                <!-- Card Previews -->
                                <div class="multisteps-form__panel shadow rounded bg-white p-0  js-active" data-animation="scaleIn">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="multisteps-form__content">
                                        <div class="business-card">
                                            <div class="banner-img">
                                                <input type="hidden" name="deletecover" id="deletecover" value="0">
                                                <input type="file" class="file1" name="coverpage" id="coverpage" onchange="fileinput(1, this.files[0], window.URL.createObjectURL(this.files[0]))"
                                                       accept="image/*" style="display: none;">
                                                <div class="" id="previewdiv1">
                                                    <?php if ($card["coverpage"] != "") { ?>
                                                        <img src="<?php echo base_url() . $this->config->item('upload_path_card_cover_thumb') . $card["coverpage"]; ?>"  class="img-fluid" id="preview1">
                                                    <?php } else {
                                                        ?>
                                                        <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-cover-pic.png" class="img-fluid img-thumbnail" alt="" id="preview1">

                                                    <?php }
                                                    ?>
                                                    <?php if ($card["coverpage"] != "") { ?>
                                                        <div class="dropdown top-cover-pic">
                                                            <button class="change-cover-pic-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-camera"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" onclick="Browse(1)" href="#" >Choose a photo</a>
                                                                <a class="dropdown-item" href="#" onclick="coverdelete()">Remove photo</a>
                                                            </div>
                                                        </div> 
                                                    <?php } else { ?>
                                                        <a class="change-cover-pic-icon" onclick="Browse(1)" ><i class="fas fa-camera"></i></a> 
                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="blogo">
                                                    <input type="hidden" name="deletelogo" id="deletelogo" value="0">
                                                    <input type="file" class="file2"  name="logo" id="logo"
                                                           onchange="fileinput(2, this.files[0], window.URL.createObjectURL(this.files[0]))"
                                                           accept="image/*" style="display: none;">
                                                    <div class="center-t-b" id="previewdiv2">
                                                        <?php if ($card["clogo"] != "") { ?>
                                                            <img  src="<?php echo base_url() . $this->config->item('upload_path_card_logo_thumb') . $card["clogo"]; ?>" id="preview2" alt="" title=""
                                                                  class="img-fluid">
                                                              <?php } else { ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-company-pic.png" class="img-fluid img-thumbnail" alt="" id="preview2">

                                                        <?php } ?>
                                                        <?php if ($card["clogo"] != "") { ?>
                                                            <div class="dropdown top-profile-pic">
                                                                <button class="upload-pic" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-camera"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" onclick="Browse(2)" href="#" >Choose a photo</a>
                                                                    <a class="dropdown-item" href="#" onclick="logodelete()">Remove photo</a>
                                                                </div>
                                                            </div> 
                                                        <?php } else { ?>
                                                            <a onclick="Browse(2)" class="upload-pic"><i class="fas fa-camera"></i></a> 
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="user-info mt-4">
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/full-name.png" class="img-fluid icon-pack">
                                                    <input type="hidden" class="form-control" id="card_id" name="card_id" value="<?php echo $card["id"]; ?>">
                                                    <input type="text" class="form-control pl55" name="fullname" id="fullname" placeholder="Full Name" value="<?php echo $card['name']; ?>">

                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="designation" id="designation" placeholder="Title / Designation" value="<?php echo $card['designation']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="slug" id="slug" placeholder="Uniq Card Name" value="<?php echo $card['slug']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/website.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="website" id="website" placeholder="Website URL" value="<?php echo $card['website']; ?>">
                                                </div>
                                                <div class="user-pic">
                                                    <div class="cetner-profile-pic-main" id="previewdiv3">
                                                        <input type="hidden" name="deleteimage" id="deleteimage" value="0">
                                                        <input type="file" class="file3" name="image" id="image"
                                                               onchange="fileinput(3, this.files[0], window.URL.createObjectURL(this.files[0]))"
                                                               accept="image/*" style="display: none;">
                                                               <?php if ($card["picture"] != "") { ?>
                                                            <img  src="<?php echo base_url() . $this->config->item('upload_path_user_thumb_rm') . $card["picture"]; ?>" id="preview3" class="img-fluid" alt=""
                                                                  title="">
                                                              <?php } else { ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-profile-pic.png" class="img-fluid img-thumbnail" alt="" id="preview3">

                                                        <?php } ?>
                                                        <?php if ($card["picture"] != "") { ?>
                                                            <div class="dropdown top-profile-pic">
                                                                <button class="upload-pic" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-camera"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" onclick="Browse(3)" href="#" >Choose a photo</a>
                                                                    <a class="dropdown-item" href="#" onclick="imagedelete()">Remove photo</a>
                                                                </div>
                                                            </div> 
                                                        <?php } else { ?>

                                                            <a class="upload-pic" onclick="Browse(3)"><i class="fas fa-camera"></i></a>
                                                        <?php } ?>
                                                        <!--                                                        <label for="upload_image">
                                                                                                                    <img src="" id="uploaded_image" class="img-responsive img-circle" />
                                                                                                                    <div class="overlay">
                                                                                                                        <div class="text">Click to Change Profile Image</div>
                                                                                                                    </div>
                                                                                                                    <input type="file" name="image" class="image" id="image"/>
                                                                                                                </label>-->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-line mb-2">
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/phone-number.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="phone" id="phone" placeholder="Phone Number" value="<?php echo $card['phone']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/email.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55"  name="email" id="email" placeholder="Email" value="<?php echo $card['email']; ?>" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/company-name.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="company" id="company" placeholder="Company Name" value="<?php echo $card['company']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/address.png" class="img-fluid icon-pack">

                                                    <textarea type="text" class="form-control pl55" name="address" id="address" placeholder="Address" rows="3"><?php echo rtrim($card['address'], ", "); ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/city.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="city" id="city" placeholder="City" value="<?php echo rtrim($card['city'], ", "); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/zip.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="zip" id="zip" placeholder="Zip" value="<?php echo rtrim($card['zip'], ", "); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/state.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="state" id="state"  placeholder="State" value="<?php echo rtrim($card['state'], ", "); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/business-type.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="businesstype" id="businesstype" placeholder="Business Type ( e.g. Restaurant, Salon, Liquor Store)" value="<?php echo $card['businesstype']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/business-type.png" class="img-fluid icon-pack">
                                                    <textarea type="text" class="form-control pl55" name="offer" id="offer" placeholder="About Services"><?php echo $card['offer']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/business-type.png" class="img-fluid icon-pack">
                                                    <textarea type="text" class="form-control pl55" name="message" id="message" placeholder="Message"><?php echo $card['message']; ?></textarea>
                                                </div>

                                                <p class="mt-4"><span>Social Media</span> </p>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/facebook.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="facebook" id="facebook" placeholder="Facebook" value="<?php echo $card['facebook']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/linkedin.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="linkedin" id="linkedin" placeholder="Linkedin" value="<?php echo $card['linkedin']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/twitter.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="twitter" id="twitter" placeholder="Twitter" value="<?php echo $card['twitter']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/youtube.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55 mb-1" name="youtubechannel" id="youtubechannel" placeholder="YouTube Embeded Link" value="<?php echo $card['youtubechannel']; ?>">
                                                    <span class="y-link">Don't know how to find your YouTube Embedded Link? <a href="#" data-toggle="modal" data-target="#youtubeinfo">Click here</a></span>
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/instagram.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" name="instagram" id="instagram" placeholder="Instagram" value="<?php echo $card['instagram']; ?>">
                                                </div>

                                                <p class="mt-4"><span>Some Links</span> </p>

                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link-title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="title1" name="title1" placeholder="Title 1"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['title1'];
                                                    }
                                                    ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="url1" name="url1" placeholder="URL 1"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['url1'];
                                                    }
                                                    ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link-title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="title2" name="title2" placeholder="Title 2"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['title2'];
                                                    }
                                                    ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="url2" name="url2" placeholder="URL 2"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['url2'];
                                                    }
                                                    ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link-title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="title3" name="title3" placeholder="Title 3"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['title3'];
                                                    }
                                                    ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="url3" name="url3" placeholder="URL 3"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['url3'];
                                                    }
                                                    ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link-title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="title4" name="title4" placeholder="Title 4"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['title4'];
                                                    }
                                                    ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="url4" name="url4" placeholder="URL 4"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['url4'];
                                                    }
                                                    ?>">
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link-title.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="title5" name="title5" placeholder="Title 5"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['title5'];
                                                    }
                                                    ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/icon/link.png" class="img-fluid icon-pack">
                                                    <input type="text" class="form-control pl55" id="url5" name="url5" placeholder="URL 5"  value="<?php
                                                    if (!empty($cardtitle)) {
                                                        echo $cardtitle[0]['url5'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>

                                            <div class="text-line">
                                                <p><span>Pictures</span> </p>
                                                <div class="uploaded-pic">

                                                    <div class="col-4 float-left" id="imagedivs">
                                                        <div class="custom-filess">
                                                            <input type="hidden" name="deletepimage" id="deletepimage" value="0">
                                                            <input type="file" name="image1" id="image1" class="file4" onchange="fileinput(4, this.files[0], window.URL.createObjectURL(this.files[0]))" accept="image/*" style="display: none;">
                                                        </div>
                                                        <?php if (!empty($profile_images)) { ?>
                                                            <?php if ($profile_images[0]["image1"] != "") { ?>
                                                                <img  src="<?php echo base_url() . $this->config->item('upload_path_cardprofilemulti_thumb') . $profile_images[0]["image1"]; ?>" class="img-fluid img-thumbnail" alt="" id="preview4">
                                                            <?php } else { ?>
                                                                <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic.png" class="img-fluid img-thumbnail" alt="" id="preview4" >

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic.png" class="img-fluid img-thumbnail" alt="" id="preview4"> 
                                                        <?php } ?>

                                                        <?php
                                                        if (!empty($profile_images)) {
                                                            if ($profile_images[0]["image1"] != "") {
                                                                ?>
                                                                <div class="dropdown top-cover-pic">
                                                                    <button class="cange-picture" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" onclick="Browse(4)" >Choose a photo</a>
                                                                        <a class="dropdown-item" onclick="pdelete()">Remove photo</a>
                                                                    </div>
                                                                </div> 
                                                            <?php } else { ?>
                                                                <a class="cange-picture" onclick="Browse(4)"><i class="fas fa-camera" aria-hidden="true"></i></a> 
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="cange-picture" onclick="Browse(4)"><i class="fas fa-camera" aria-hidden="true"></i></a> 
                                                        <?php } ?>
                                                    </div>


                                                    <div class="col-4 float-left " >
                                                        <div class="custom-filess">
                                                            <input type="hidden" name="deletepimage1" id="deletepimage1" value="0">
                                                            <input type="file" name="image2" id="image2" class="file5" onchange="fileinput(5, this.files[0], window.URL.createObjectURL(this.files[0]))" accept="image/*" style="display: none;">
                                                        </div>
                                                        <?php if (!empty($profile_images)) { ?>
                                                            <?php if ($profile_images[0]["image2"] != "") { ?>
                                                                <img  src="<?php echo base_url() . $this->config->item('upload_path_cardprofilemulti_thumb') . $profile_images[0]["image2"]; ?>" class="img-fluid img-thumbnail" alt="" id="preview5">
                                                            <?php } else {
                                                                ?>
                                                                <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic1.png" class="img-fluid img-thumbnail" alt="" id="preview5" >

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic1.png" class="img-fluid img-thumbnail" alt="" id="preview5"> 
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($profile_images)) {
                                                            if ($profile_images[0]["image2"] != "") {
                                                                ?>
                                                                <div class="dropdown top-cover-pic">
                                                                    <button class="cange-picture" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" onclick="Browse(5)" >Choose a photo</a>
                                                                        <a class="dropdown-item" onclick="p1delete()">Remove photo</a>
                                                                    </div>
                                                                </div> 


                                                            <?php } else { ?>
                                                                <a class="cange-picture" onclick="Browse(5)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="cange-picture" onclick="Browse(5)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                        <?php } ?>                
                                                    </div>

                                                    <div class="col-4 float-left">
                                                        <div class="custom-filess">
                                                            <input type="hidden" name="deletepimage2" id="deletepimage2" value="0">
                                                            <input type="file" name="image3" id="image3" class="file6" onchange="fileinput(6, this.files[0], window.URL.createObjectURL(this.files[0]))" accept="image/*" style="display: none;">
                                                        </div>
                                                        <?php if (!empty($profile_images)) { ?>
                                                            <?php if ($profile_images[0]["image3"] != "") { ?>
                                                                <img  src="<?php echo base_url() . $this->config->item('upload_path_cardprofilemulti_thumb') . $profile_images[0]["image3"]; ?>" class="img-fluid img-thumbnail" alt="" id="preview6">
                                                            <?php } else {
                                                                ?>
                                                                <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic2.png" class="img-fluid img-thumbnail" alt="" id="preview6">

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic2.png" class="img-fluid img-thumbnail" alt="" id="preview6"> 
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($profile_images)) {
                                                            if ($profile_images[0]["image3"] != "") {
                                                                ?>
                                                                <div class="dropdown top-cover-pic">
                                                                    <button class="cange-picture" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" onclick="Browse(6)" >Choose a photo</a>
                                                                        <a class="dropdown-item" onclick="p2delete()">Remove photo</a>
                                                                    </div>
                                                                </div> 
                                                            <?php } else { ?>
                                                                <a class="cange-picture" onclick="Browse(6)"><i class="fas fa-camera" aria-hidden="true"></i></a> 
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="cange-picture" onclick="Browse(6)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                        <?php } ?>      
                                                    </div>

                                                    <div class="col-4 float-left offset-2">
                                                        <div class="custom-filess">
                                                            <input type="hidden" name="deletepimage3" id="deletepimage3" value="0">
                                                            <input type="file" name="image4" id="image4" class="file7" onchange="fileinput(7, this.files[0], window.URL.createObjectURL(this.files[0]))" accept="image/*" style="display: none;">
                                                        </div>
                                                        <?php if (!empty($profile_images)) { ?>
                                                            <?php if ($profile_images[0]["image4"] != "") { ?>
                                                                <img  src="<?php echo base_url() . $this->config->item('upload_path_cardprofilemulti_thumb') . $profile_images[0]["image4"]; ?>" class="img-fluid img-thumbnail" alt="" id="preview7">
                                                            <?php } else {
                                                                ?>
                                                                <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic3.png" class="img-fluid img-thumbnail" alt="" id="preview7">

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic3.png" class="img-fluid img-thumbnail" alt="" id="preview7"> 
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($profile_images)) {
                                                            if ($profile_images[0]["image4"] != "") {
                                                                ?>
                                                                <div class="dropdown top-cover-pic">
                                                                    <button class="cange-picture" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" onclick="Browse(7)" >Choose a photo</a>
                                                                        <a class="dropdown-item" onclick="p3delete()">Remove photo</a>
                                                                    </div>
                                                                </div> 
                                                            <?php } else { ?>

                                                                <a class="cange-picture" onclick="Browse(7)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="cange-picture" onclick="Browse(7)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                        <?php } ?>  
                                                    </div>

                                                    <div class="col-4 float-left">
                                                        <div class="custom-filess">
                                                            <input type="hidden" name="deletepimage4" id="deletepimage4" value="0">
                                                            <input type="file" name="image5" id="image5" class="file8" onchange="fileinput(8, this.files[0], window.URL.createObjectURL(this.files[0]))" accept="image/*" style="display: none;">
                                                        </div>
                                                        <?php if (!empty($profile_images)) { ?>
                                                            <?php if ($profile_images[0]["image5"] != "") { ?>
                                                                <img  src="<?php echo base_url() . $this->config->item('upload_path_cardprofilemulti_thumb') . $profile_images[0]["image5"]; ?>" class="img-fluid img-thumbnail" alt="" id="preview8">
                                                            <?php } else {
                                                                ?>
                                                                <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic4.png" class="img-fluid img-thumbnail" alt="" id="preview8">

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic4.png" class="img-fluid img-thumbnail" alt="" id="preview8"> 
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($profile_images)) {
                                                            if ($profile_images[0]["image5"] != "") {
                                                                ?>
                                                                <div class="dropdown top-cover-pic">
                                                                    <button class="cange-picture" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-camera"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" onclick="Browse(8)" >Choose a photo</a>
                                                                        <a class="dropdown-item" onclick="p4delete()">Remove photo</a>
                                                                    </div>
                                                                </div> 
                                                            <?php } else { ?>

                                                                <a class="cange-picture" onclick="Browse(8)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="cange-picture" onclick="Browse(8)"><i class="fas fa-camera" aria-hidden="true"></i></a>
                                                        <?php } ?>  
                                                    </div>




                                                </div>
                                            </div>


                                            <div class="user-info text-line mb-0 pb-5">
                                                <p class="mt-0"><span>Card Status</span> </p>
                                                <div class="form-group mb-0 pb-4">
                                                    <select class="form-control " id="card_status" name="card_status">
                                                        <option <?= (!empty($card['card_status']) && $card['card_status'] == 'Public') ? 'selected' : 'selected'; ?>>Public</option>
                                                        <option <?= (!empty($card['card_status']) && $card['card_status'] == 'Private') ? 'selected' : ''; ?>>Private</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="download-contact bottom-fixed-div">
                                <a href="<?php echo base_url("p/") . $card['slug']; ?>" class="ml-0 cancel-btn"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</a>
                                <button type="submit" class="mr-0 float-right"><i class="fas fa-check"></i>&nbsp;&nbsp;Save Profile</button>
                                <p>Powered By pname (<a class="website-link" href="<?php echo base_url(); ?>">www.pname.com</a>) </p>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal" id="youtubeinfo" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h2>Embed a video</h2>
                        <ol class="list-port">
                            <li>On a computer, go to the YouTube video you want to embed.</li>
                            <li data-outlined="false" class="">Under the video, click SHARE.</li>
                            <li>Click Embed.</li>
                            <li>From the box that appears, copy the HTML code.</li>
                            <li>Paste the code into box.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="crop" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>	


        <div class="modal fade" id="modalcover" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_imagecover" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropcover" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modallogo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_imagelogo" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="croplogo" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalimage1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image1" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropimage1" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalimage2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image2" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropimage2" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalimage3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image3" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropimage3" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalimage4" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image4" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropimage4" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalimage5" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image Before Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="" id="sample_image5" />
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cropimage5" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>

<script type="" src="<?php echo $this->config->item('common_assets_path'); ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/popper.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/bootstrap-4.0.0.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/fontawesom.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/lazysizes.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script>
                                                            $(document).ready(function () {
                                                                var offsetHeight = document.getElementById('imagedivs');
                                                                var finalheight = offsetHeight.clientWidth - 10;
                                                                $(".uploaded-pic .col-4.float-left img").css("height", finalheight);
                                                                console.log(offsetHeight.clientHeight, "offsetHeight");
                                                                console.log(finalheight, "finalheight");
                                                                console.log(offsetHeight.clientWidth, "clientwidth");
                                                            });
                                                            var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
                                                            var regex = new RegExp(expression);
                                                            jQuery.validator.addMethod("checkurl", function (value, element) {
                                                                return this.optional(element) || value.match(regex);
                                                            }, 'Please Enter valid URL.');

                                                            $("#rgfrm").validate({
                                                                rules: {
                                                                    fullname: {
                                                                        required: true,
                                                                    },
                                                                    
                                                                    url1: {
                                                                        checkurl: true,
                                                                    },
                                                                    url2: {
                                                                        checkurl: true,
                                                                    },
                                                                    url3: {
                                                                        checkurl: true,
                                                                    },
                                                                    url4: {
                                                                        checkurl: true,
                                                                    },
                                                                    url5: {
                                                                        checkurl: true,
                                                                    },
                                                                    slug:{
                                                                        required:true,
                                                                         remote: {
                                                                            url: "<?php echo site_url('Dashboard/checkuniqueusernameedit') ?>",
                                                                            type: "post",
                                                                            data: {
                                                                                name: function () {
                                                                                    return $("#slug").val();

                                                                                },
                                                                                id:function(){
                                                                                    return $("#card_id").val();
                                                                                },
                                                                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                                                            }
                                                                        }
                                                                    }
                                                                },
                                                                messages: {
                                                                    fullname: {
                                                                        required: "Full Name is required.",
                                                                    },
                                                                   
                                                                    url1: {
                                                                        checkurl: "Please Enter valid URL.",
                                                                    },
                                                                    url2: {
                                                                        checkurl: "Please Enter valid URL.",
                                                                    },
                                                                    url3: {
                                                                        checkurl: "Please Enter valid URL.",
                                                                    },
                                                                    url4: {
                                                                        checkurl: "Please Enter valid URL.",
                                                                    },
                                                                    url5: {
                                                                        checkurl: "Please Enter valid URL.",
                                                                    },
                                                                    slug:{
                                                                        required: "Unique Card Name is required.",
                                                                        remote: "Card Name already exists.",
                                                                    }
                                                                },
                                                                submitHandler: function (form) {
                                                                    form.submit();
                                                                }
                                                            });



                                                            function Browse(id) {
                                                                $(".file" + id).trigger("click");
                                                            }

                                                            function fileinput(id, input, createObjectURL) {
                                                                var fileName = input.name;
                                                                $("#file" + id).val(fileName);
                                                                document.getElementById("preview" + id).src = createObjectURL;
                                                                document.getElementById("previewdiv" + id).style.display = 'block';
                                                            }


                                                            function reset(id) {
                                                                $("#file" + id).val('');
                                                                $(".file" + id).val("");
                                                                document.getElementById("previewdiv" + id).style.display = 'none';
                                                            }





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


                                                            function coverdelete() {

                                                                $("#preview1").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-cover-pic.png");
                                                                $("#deletecover").val("1");

                                                            }

                                                            function logodelete() {

                                                                $("#preview2").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-company-pic.png");
                                                                $("#deletelogo").val("1");

                                                            }

                                                            function imagedelete() {

                                                                $("#preview3").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-profile-pic.png");
                                                                $("#deleteimage").val("1");

                                                            }

                                                            function pdelete() {

                                                                $("#preview4").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic.png");
                                                                $("#deletepimage").val("1");

                                                            }
                                                            function p1delete() {

                                                                $("#preview5").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic1.png");
                                                                $("#deletepimage1").val("1");

                                                            }
                                                            function p2delete() {

                                                                $("#preview6").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic2.png");
                                                                $("#deletepimage2").val("1");

                                                            }
                                                            function p3delete() {

                                                                $("#preview7").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic3.png");
                                                                $("#deletepimage3").val("1");

                                                            }
                                                            function p4delete() {

                                                                $("#preview8").attr("src", "<?php echo $this->config->item('common_assets_path'); ?>images/card/dummy-pic4.png");
                                                                $("#deletepimage4").val("1");

                                                            }
</script>



<script>

    $(document).ready(function () {

        var $modal = $('#modal');
        var $modalcover = $('#modalcover');
        var $modallogo = $('#modallogo');
        var $modalimage1 = $('#modalimage1')
        var $modalimage2 = $('#modalimage2')
        var $modalimage3 = $('#modalimage3')
        var $modalimage4 = $('#modalimage4')
        var $modalimage5 = $('#modalimage5')

        var image = document.getElementById('sample_image');
        var imagecover = document.getElementById('sample_imagecover');
        var imagelogo = document.getElementById('sample_imagelogo');
        var image1 = document.getElementById('sample_image1');
        var image2 = document.getElementById('sample_image2');
        var image3 = document.getElementById('sample_image3');
        var image4 = document.getElementById('sample_image4');
        var image5 = document.getElementById('sample_image5');

        var cropper;

        $('#image').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });


        $('#coverpage').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                imagecover.src = url;
                $modalcover.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });


        $('#logo').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                imagelogo.src = url;
                $modallogo.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#image1').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image1.src = url;
                $modalimage1.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#image2').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image2.src = url;
                $modalimage2.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#image3').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image3.src = url;
                $modalimage3.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#image4').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image4.src = url;
                $modalimage4.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#image5').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image5.src = url;
                $modalimage5.modal('show');
            };

            if (files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function (event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'

            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });


        $modalcover.on('shown.bs.modal', function () {
            cropper = new Cropper(imagecover, {
                viewMode: 3,
                preview: '.preview',
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });


        $modallogo.on('shown.bs.modal', function () {
            cropper = new Cropper(imagelogo, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $modalimage1.on('shown.bs.modal', function () {
            cropper = new Cropper(image1, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $modalimage2.on('shown.bs.modal', function () {
            cropper = new Cropper(image2, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $modalimage3.on('shown.bs.modal', function () {
            cropper = new Cropper(image3, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $modalimage4.on('shown.bs.modal', function () {
            cropper = new Cropper(image4, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $modalimage5.on('shown.bs.modal', function () {
            cropper = new Cropper(image5, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });






        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadprofile' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modal.modal('hide');
                            $('#image').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });

        $('#cropcover').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 510,
                height: 286
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadcover' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modalcover.modal('hide');
                            $('#coverpage').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });


        $('#croplogo').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 200,
                height: 200,
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadlogo' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#logo').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });


        $('#cropimage1').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadimage1' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#image1').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });
        
         $('#cropimage2').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadimage2' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#image2').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });
        
         $('#cropimage3').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadimage3' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#image3').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });
        
         $('#cropimage4').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadimage4' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#image4').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });
        
         $('#cropimage5').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: "<?php echo base_url() . 'Dashboard/uploadimage5' ?>",
                        method: 'POST',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', image: base64data, cardid: '<?php echo $card["id"]; ?>'},
                        success: function (data)
                        {
                            $modallogo.modal('hide');
                            $('#image5').attr('src', data);
                            location.reload();
                        }
                    });
                };
            });
        });







    });
</script>



</body>

</html>



