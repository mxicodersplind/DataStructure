<?php echo $header; ?>   
<?php echo $sidebar; ?>   
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title"></h4>
            </div>
        </div>

        <div class="page-content-wrapper ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="error_msg_info">
                        <?php if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('success'); ?></strong> 
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('error'); ?></strong> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
 <?php if (in_array(1, $adminrole)) { ?>
                   <a href="<?php echo base_url('User'); ?>">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Enable Users</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-user text-primary m-r-10"></i><b><?= $Enable_Users; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>
                   
                    <a href="<?php echo base_url('User'); ?>">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Disable Users</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-user text-primary m-r-10"></i><b><?= $Disable_Users; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo base_url('Events'); ?>">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Total Events</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-calendar text-primary m-r-10"></i><b><?= $Total_Events; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo base_url("UserCards");?>">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Total Cards</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-credit-card text-primary m-r-10"></i><b><?= $Total_Cards; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Today's Cards</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-credit-card text-primary m-r-10"></i><b><?= $Todays_Cards; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Total View</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-eye text-primary m-r-10"></i><b><?= $Total_View; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Today's View</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-eye text-primary m-r-10"></i><b><?= $Todays_View; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Total Shared</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-share text-primary m-r-10"></i><b><?= $Total_Shared; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Today's Shared</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-share text-primary m-r-10"></i><b><?= $Todays_Shared; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Uploaded Card</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-upload text-primary m-r-10"></i><b><?= $Uploaded_Card; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Scan Card</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-qrcode text-primary m-r-10"></i><b><?= $Scan_Card; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="<?php echo base_url("UserCards/unsave");?>">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel text-center">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted font-light highlight-new">Unsave Card</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15"><i class="fa fa-credit-card text-primary m-r-10"></i><b><?= $unsave_Card; ?></b></h2>

                                </div>
                            </div>
                        </div>
                    </a>
                     <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php echo $footer; ?>