
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
                <h5 class="text-center">OTP Verification</h5>
            </div>
        </div>
        <div class="row">
            <div class="tabs-login">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  show active" id="signup" role="tabpanel" aria-labelledby="signin-tab">
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

                           <div class="tab-pane" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                <div class="login-box">
                                    <?php echo form_open("Register/submitotp", array("class" => "form-horizontal", "method" => "POST", "id" => "otpfrm")); ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" readonly="">
                                        <input type="hidden" class="form-control" name="userid" value="<?php echo base64_encode($userid); ?>">
                                    </div>

                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" maxlength="6" name="otp" id="otp" placeholder="Enter OTP(One Time Password)">
                                        <span class="float-right"><a href="#" onclick="resendotp()">Resend OTP<a></span>
                                    </div>
                                    <div class="mt-4 full-btn">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" >Submit</button>
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

<?= $footer; ?>

<script>
    $(document).ready(function () {

        $("#otpfrm").validate({
            rules: {
                otp: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                otp: {
                    required: "Enter OTP(One Time Password).",
                    number: "Allow Only 6 Digits.",
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });
    
    
    function resendotp(){
       $.ajax({
            url: "<?php echo base_url() . 'Register/resendotp' ?>",
            type: "POST",
            dataType: "json",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', userid: '<?php echo base64_encode($userid);?>'},
            catch : false,
            success: function (data) {
                if (data.status == 'success') {
                   flash_alert_msg("OTP Resend Successfully.","success",2000);
                }else {
                   flash_alert_msg("Error Occured Please try again later.","error",2000);
                }

            }
        });  
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



</script>

