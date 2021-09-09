
<footer>
    <div class="footer-btm desktop-view">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order2">
                    <ul>
                        <li><a target="_blank" href="<?= base_url() . "/blog"; ?>">Blog</a></li>
                        <li><a href="<?= base_url('Privacypolicy'); ?>">Privacy Policy</a></li>
                        <li><a href="<?= base_url('Termsconditions'); ?>">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <p class="copyright-text">Copyright@<?= date("Y"); ?> all right reserved to www.pname.com</p>
                </div>

            </div>
        </div>
    </div>

    <?php if ($this->session->userdata('user_id')) { ?>
        <div class="after-login-footer">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $active = '';
                    if (strpos(strtolower($_SERVER['REQUEST_URI']), 'dashboard') !== false)
                        $active = 'active';
                    ?>
                    <div class="col-3">
                        <div class="footer-mobile-menu"><a href="<?= base_url("Dashboard"); ?>" class="<?= $active ?>"><i class="fas fa-id-card"></i>
                                <p>My Cards</p>
                            </a>
                        </div>
                    </div>
                    <?php
                    $active = '';
                    if (strpos(strtolower($_SERVER['REQUEST_URI']), 'cardholder') !== false)
                        $active = 'active';
                    ?>
                    <div class="col-3">
                        <div class="footer-mobile-menu"><a href="<?= base_url("Cardholder"); ?>" class="<?= $active ?>"><i class="fas fa-wallet"></i>
                                <p>Card Holder</p>
                            </a>
                        </div>
                    </div>
                    <?php
                    $active = '';
                    if (strpos(strtolower($_SERVER['REQUEST_URI']), 'events') !== false)
                        $active = 'active';
                    ?>
                    <div class="col-3">
                        <div class="footer-mobile-menu"><a href="<?= base_url("Events"); ?>" class="<?= $active ?>"><i class="fas fa-calendar-check"></i>
                                <p>Events</p>
                            </a>
                        </div>
                    </div>
                    <?php
                    $active = '';
                    if (strpos(strtolower($_SERVER['REQUEST_URI']), 'menu') !== false)
                        $active = 'active';
                    ?>
                    <div class="col-3">
                        <div class="footer-mobile-menu"><a href="<?= base_url("Menu"); ?>" class="<?= $active ?>"><i class="fas fa-bars"></i>
                                <p>Menu</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</footer>




<!-- Modal -->
<div class="modal fade" id="Cookies-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="cookies-box">
                    <p>By clicking Accept All Cookies, you agree to storing cookies on your device to enhance site navigation, analyze site usage, and assist in our marketing efforts. <a href="<?php echo base_url('Cookie'); ?>" target="_blank">Cookie Notice.</a> </p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" onclick="close_cookis_messge()">Accept All Cookies</button>
            </div>
        </div>
    </div>
</div>

<!-- Add shortcut code start -->
<script src="./upup.min.js"></script>
<script>
                    UpUp.start({
                        'content-url': 'offline.html',
                        'assets': ['./assets/css/style1.css']
                    });
</script>
<!-- Add shortcut code over -->

<script>
    
    var js_base_url = '<?php echo base_url() . ''; ?>';</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="" src="<?php echo $this->config->item('common_assets_path'); ?>js/jquery-3.2.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/popper.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/bootstrap-4.0.0.js"></script>

<!-- Font Awesome -->
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/fontawesom.js"></script>

<!-- lazyload For IMAGE  -->
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/lazysizes.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>../js/moment.min.js"></script>

<script src="<?php echo $this->config->item('common_assets_path'); ?>../js/jquery.bootstrap-growl.min.js"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('common_assets_path'); ?>../js/ajax-loading.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.cookie.min.js"></script>
<script>

    var loading = $.loading();

    function openLoading(time) {
        loading.open(time);
    }

    function closeLoading() {
        loading.close();
    }
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 10) {
            $('.header').addClass('fixed-header');
        } else {
            $('.header').removeClass('fixed-header');
        }
    });

    var btn = $('#button');
    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, '300');
    });


    function ShowUTCDate() {
        var dNow = new Date();
        var utc = new Date(dNow.getTime() + dNow.getTimezoneOffset() * 60000)
        //var utcdate= (utc.getMonth()+1) + '/' + utc.getDate() + '/' + utc.getFullYear() + ' ' + utc.getHours() + ':' + utc.getMinutes();
        var utcdate = utc.getHours() + ':' + utc.getMinutes() + ':' + utc.getSeconds();
        $('#top_time').text(utcdate + ' UTC')
    }




    function flash_alert_msg(msg, msg_type = 'success', delay = '60000') {
        if (msg_type == 'success') {
            $.bootstrapGrowl("<i class='fa fa-check-circle' aria-hidden='true'></i><strong>&nbsp;&nbsp;" + msg + "</strong> ", {
                type: 'success',
                delay: delay,
                width: 'auto',
                align: 'center',
                allow_dismiss: true
            });
        }


        if (msg_type == 'error') {
            $.bootstrapGrowl("<i class='fa fa-times-circle-o' aria-hidden='true'></i><strong>&nbsp;&nbsp;" + msg + "</strong> ", {
                type: 'danger',
                delay: delay,
                width: 'auto',
                allow_dismiss: true,
                align: 'center'
            });
        }

        if (msg_type == 'info') {
            $.bootstrapGrowl("<i class='fa fa-exclamation-circle' aria-hidden='true'></i><strong>&nbsp;&nbsp;" + msg + "</strong> ", {
                type: 'info',
                delay: delay,
                width: 'auto',
                allow_dismiss: true,
                align: 'center'
            });
        }
    }


</script>


</body>
</html>