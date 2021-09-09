
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
                    <p class="title text-center">Reset Password</p>
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
                        <?php echo form_open('Forgotpassword/reset_password/' . $this->data['reset_token'], array("class" => "form-horizontal", "method" => "POST", "id" => "rgfrm")); ?>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        </div>

                        <div class="form-group mt-3">
                            <input type="password" class="form-control" name="cnfpassword" id="cnfpassword" placeholder="Enter confirm password">
                        </div>

                        <div class="mt-4 full-btn">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset</button>
                        </div>

                        <div class="clearfix"></div>
                
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $footer; ?>

<script>
    
    $(document).ready(function () {
        $("#rgfrm").validate({
            rules: {
                password: {
                    required: true,
                    maxlength : 16,
                    minlength : 6

                },
                cnfpassword: {
                    required: true, equalTo: "#password"

                }
            },
            messages: {
                password: {
                    required: "New Password is required "

                },
                cnfpassword: {
                    required: "Confirm Password is required",
                    equalTo: "Confirm Password must mach with New Passowrd"
                }
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