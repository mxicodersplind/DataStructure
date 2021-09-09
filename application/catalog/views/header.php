<!DOCTYPE html>
<html lang="en">
    <noscript>
    <!-- anchor linking to external file -->
    <a href="https://www.mozilla.com/">External Link</a>
    </noscript>
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

        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>addhomescreen/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>addhomescreen/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>addhomescreen/favicon-16x16.png">


        <?php echo ($googlesetting['setting_value']); ?>

        <!-- Bootstrap -->
        <link href="<?php echo $this->config->item('common_assets_path'); ?>css/bootstrap-4.0.0.css" rel="stylesheet">
        <!-- Custom CSS-->
        <link href="<?php echo $this->config->item('common_assets_path'); ?>css/style.css" rel="stylesheet">

        <!-- Add shortcut code start -->
        <link rel="stylesheet" href="./assets/css/style1.css">
        <link rel="manifest" href="./manifest.json">
        <link rel="mask-icon" href="./safari-pinned-tab.svg" color="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <!-- Add shortcut code over-->

        <style>
            .navbar.navbar-expand-lg.menu { display:block }
            @media (max-width:991px){ 
                .navbar.navbar-expand-lg.menu { right: 17px; left: auto; }
                .menu .nav-item a img { margin-top: 1px; }
                .login-menu-mobile-new { display:none; }
            }
        </style>

    </head>

    <body class="full-height cookies">
        <section class="header">
            <div class="container container-1740">
                <div class="row">
                    <div class="col-12">
                        <div class="float-left logo">
                            <a href="<?php
                            if (!$this->session->userdata('user_id')) {
                                echo base_url("Home");
                            } else {
                                echo base_url("Dashboard");
                            }
                            ?>">
                                <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/droupcard-logo.svg" alt="" class="img-fluid lazyload">
                            </a>
                        </div>
                        <?php if ($this->session->userdata('user_id')) { ?>

                            <div class="float-right menu">



                                <nav class="navbar navbar-expand-lg menu">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <img src="<?php echo $this->config->item('common_assets_path'); ?>images/menu.svg">
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item ">
                                                <a class="nav-link" href="<?= base_url("Profile"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/blog.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/blog-hover.png" alt="" class="img-fluid menu-img-hover">Profile
                                                </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a class="nav-link" href="<?= base_url("Dashboard"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/business.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/business-hover.png" alt="" class="img-fluid menu-img-hover">Dashboard
                                                </a>
                                            </li>
                                            <li class="nav-item login-menu-mobile-new">
                                                <a class="nav-link" href="<?= base_url("Dashboard/logout"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/user.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/user-hover.png" alt="" class="img-fluid menu-img-hover">Logout
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </nav>

                                <div class="user-account"><a href="<?= base_url("Dashboard"); ?>"><img data-src="<?php echo base_url() . $this->config->item('upload_path_user_thumb_rm') . $logged_use['image']; ?>" class="lazyload"></a></div>

                            </div>

                        <?php } else { ?>

                            <div class="float-right menu">



                                <nav class="navbar navbar-expand-lg menu">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <img src="<?php echo $this->config->item('common_assets_path'); ?>images/menu.svg">
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item ">
                                                <a class="nav-link" href="<?= base_url("blog"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/blog.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/blog-hover.png" alt="" class="img-fluid menu-img-hover">Blog
                                                </a>
                                            </li>
                                            <li class="nav-item ">
                                                <a class="nav-link" href="<?= base_url("Home/business"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/business.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/business-hover.png" alt="" class="img-fluid menu-img-hover">Business
                                                </a>
                                            </li>
                                            <li class="nav-item login-menu-mobile-new">
                                                <a class="nav-link" href="<?= base_url("Login"); ?>">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/user.png" alt="" class="img-fluid menu-img">
                                                    <img src="<?php echo $this->config->item('common_assets_path'); ?>images/user-hover.png" alt="" class="img-fluid menu-img-hover">Login
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </nav>
                                <div class="user-account"><a href="<?= base_url("Login"); ?>"><img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/user.svg" class="lazyload"></a></div>


                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <div class="header-height"></div>