<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">

            <div class="user-info">
                <div class="dropdown">
                    <div class="portal">Admin</div>
                </div>
            </div>
        </div>
        <div id="sidebar-menu">
            <ul>
                <?php if ($admin_role == 1) { ?>
                    <li> <a href="<?php echo base_url('Dashboard'); ?>" class="waves-effect"><i class="fa fa-home"></i><span> Dashboard</span></a></li>
                <?php } ?>
                <?php if ($admin_role == 1) { ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cog"></i> <span>Settings </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">

                            <li><a href="<?php echo site_url('Setting'); ?>">General</a> </li>
                            <li><a href="<?php echo site_url('Setting/smtp'); ?>">SMTP Setting</a> </li>
                            <li><a href="<?php echo site_url('Sem'); ?>">SEM</a></li>

                            <li><a href="<?php echo site_url('Api'); ?>">Social Media Login</a></li>

                            <li><a href="<?php echo site_url('MetaInfo'); ?>">Meta Info</a></li>
                            <li><a href="<?php echo site_url('ProfileImage'); ?>">Profile Image</a></li>
                            <li><a href="<?php echo site_url('Homepage'); ?>">Home Page Video</a></li>

                        </ul>
                    </li>

                    <li> <a href="<?php echo base_url('Pages'); ?>" class="waves-effect"><i class="fa fa-file"></i><span> Pages</span></a></li>

                        <!--                <li> <a href="<?php echo base_url('Role'); ?>" class="waves-effect"><i class="fa fa-tasks"></i><span> Role</span></a></li>-->

                    <li> <a href="<?php echo base_url('SubUsers'); ?>" class="waves-effect"><i class="fa fa-users"></i><span> Sub Admin</span></a></li>
                    <li> <a href="<?php echo base_url('Homepagesection'); ?>" class="waves-effect"><i class="fa fa-home"></i><span> Homepage Section</span></a></li>

                    <li> <a href="<?php echo base_url('Testimonials'); ?>" class="waves-effect"><i class="fa fa-quote-right"></i><span> Testimonials</span></a></li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-envelope"></i> <span>Email
                                Templates</span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo site_url('Emailformat'); ?>">Admin</a> </li>
                            <li><a href="<?php echo site_url('Emailformat/student'); ?>">User</a></li>
                            <li><a href="<?php echo site_url('Emailformat/SubAdmin'); ?>">Sub Admin</a></li>

                        </ul>
                    </li>

                    <li> <a href="<?php echo base_url('User'); ?>" class="waves-effect"><i class="fa fa-user"></i><span> Users</span></a></li>
                    <li> <a href="<?php echo base_url('User/business'); ?>" class="waves-effect"><i class="fa fa-user"></i><span> Business Users</span></a></li>







            <!--                    <li> <a href="<?php //echo base_url('UserCards');    ?>" class="waves-effect"><i class="fa fa-credit-card"></i><span> Cards</span></a></li>
                                <li> <a href="<?php //echo base_url('UserCards/unsave');    ?>" class="waves-effect"><i class="fa fa-credit-card"></i><span>Unsave Cards</span></a></li>-->
                <?php } ?>

                <?php if ($admin_role == 1 || $admin_role == 2) { ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-credit-card"></i> <span>Cards
                            </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo site_url('UserCards'); ?>">Saved</a> </li>
                            <li><a href="<?php echo site_url('UserCards/unsave'); ?>">Not Saved</a></li>


                        </ul>
                    </li>
                <?php } ?>
                <?php if ($admin_role == 1 || $admin_role == 2) { ?>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-upload"></i> <span>Uploaded Cards
                            </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo site_url('UploadedCards'); ?>">Card Holder</a> </li>
                            <li><a href="<?php echo site_url('UploadedCards/event'); ?>">Event</a></li>


                        </ul>
                    </li>
    <!--                    <li> <a href="<?php //echo base_url('UploadedCards');    ?>" class="waves-effect"><i class="fa fa-upload"></i><span> Uploaded</span></a></li>-->
                <?php } ?>
    <!--<li> <a href="<?php //echo base_url('UploadedCards/event');    ?>" class="waves-effect"><i class="fa fa-upload"></i><span> Uploaded Event Card</span></a></li>-->
                <?php if ($admin_role == 1) { ?>
                    <li> <a href="<?php echo base_url('Events'); ?>" class="waves-effect"><i class="fa fa-calendar"></i><span> Events</span></a></li>
                    <li> <a href="<?php echo base_url('Raffle'); ?>" class="waves-effect"><i class="fa fa-calendar"></i><span> Raffle</span></a></li>
                    <li> <a href="<?php echo base_url('LoginLog'); ?>" class="waves-effect"><i class="fa fa-user"></i><span> Login Log</span></a></li>

                    <li> <a href="<?php echo base_url('ViewLog'); ?>" class="waves-effect"><i class="fa fa-eye"></i><span> View Log</span></a></li>

                    <li> <a href="<?php echo base_url('ShareLog'); ?>" class="waves-effect"><i class="fa fa-share"></i><span> Share Log</span></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>