
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
                    <p class="title text-center">Signup</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
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
                        
                         <?php 
                    $lasturl =$_SERVER['HTTP_REFERER'];
                    
                    if ($this->session->userdata('card_session_id') && $lasturl == base_url("Dashboard/addcard")) { ?>
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
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Signup</button>
                        </div>

                        <div class="clearfix"></div>

                        <?php echo form_close(); ?>
                    </div>
                    <p class="text-center register-link mb-3">Already have an account? <a href="<?php echo base_url("Login"); ?>"> Login</a> </p>
                </div>
            </div>
        </div>
    </section>

<?= $footer; ?>

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
                    maxlength : 16,
                    minlength : 6
                },
                cnfpassword: {
                    required: true,
                    equalTo: "#password"
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

</script>