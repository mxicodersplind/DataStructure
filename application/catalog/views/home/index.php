
<?= $header; ?>
<?php $popup = $this->common->select_data_by_condition('homepagevideo', array('videoid' => 1), '*', '', '', '', '', array()); ?>


<section class="slider">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="box-slider">
                    <div class="event-imgs">
                        <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/new-home/professional.png" class="img-fluid lazyload">
                    </div>
                    <div class="event-descv">
                        <p class="event-descv-title">For Professional Individuals</p>
                        <p class="event-descv-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas dui id tempus accumsan. Praesent porttitor urn</p>
                        <div class="create-card col-12"><a href="<?php echo base_url("Dashboard/addcard"); ?>">create a card</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-slider">
                    <div class="event-imgs">
                        <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/new-home/small.png" class="img-fluid lazyload">
                    </div>
                    <div class="event-descv">
                        <p class="event-descv-title">For Small Business</p>
                        <p class="event-descv-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas dui id tempus accumsan. Praesent porttitor urn</p>
                        <div class="create-card col-12"><a href="<?php echo base_url("business/Register"); ?>">Register business</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-slider">
                    <div class="event-imgs">
                        <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/new-home/event.png" class="img-fluid lazyload">
                    </div>
                    <div class="event-descv">
                        <p class="event-descv-title">For Event Organizers</p>
                        <p class="event-descv-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas dui id tempus accumsan. Praesent porttitor urn</p>
                        <div class="create-card col-12"><a href="<?php echo base_url("Register"); ?>">SIgn up</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="created-information">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="totla-count">
                    <p class="total-count-number"><?= count($card_created); ?></p>
                    <p class="total-count-name">Cards Created </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="totla-count">
                    <p class="total-count-number"><?= count($event_created); ?></p>
                    <p class="total-count-name">Events Created</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="totla-count border-0">
                    <p class="total-count-number"><?= count($shared_card); ?></p>
                    <p class="total-count-name">Times Cards got shared</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cards">
    <div class="container">
        <div class="row">
            <?php
            if (!empty($sectiondata)) {
                foreach ($sectiondata as $section) {
                    ?>
                   
                        <div class="col-md-6">
                             <a target="_blank" href="<?php echo $section['link']; ?>">
                            <div class="box-slider">
                                <div class="event-imgs">
                                    <img data-src="<?php echo base_url(); ?>uploads/section/thumb/<?php echo $section['image']; ?>" class="img-fluid lazyload">
                                </div>
                                <div class="event-descv">
                                    <p class="event-descv-title"><?php echo $section['title']; ?></p>
                                    <p class="event-descv-des"><?php echo nl2br($section['description']); ?></p>
                                </div>
                            </div>
                                  </a>
                        </div>
                   
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>



<section class="how-it-work">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="title text-center home-title">How it works</p>
                <p class="problem-tag-line text-center col-12 p-0"><?= strip_tags($home[9]['description']); ?></p>
            </div>
        </div>
        <div class="row">
            <?php if (!$this->session->userdata('user_id')) { ?>
                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url("Login"); ?>">
                        <div class="step-box">
                            <div class="step-box-img">
                                <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-1-logo.svg" class="img-fluid simple">
                                <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-1-logo-hover.svg" class="img-fluid hover">
                            </div>
                        </div>
                        <p>Login</p>
                    </a>
                </div>
            <?php } ?>
            <div class="<?php
            if (!$this->session->userdata('user_id')) {
                echo 'col-lg-3';
            } else {
                echo 'col-lg-4';
            }
            ?> col-md-6">
                <a href="<?= base_url('Dashboard/addcard'); ?>">
                    <div class="step-box">
                        <div class="step-box-img">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-2-card.svg" class="img-fluid simple lazyload">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-2-card-hover.svg" class="img-fluid hover">
                        </div>
                    </div>
                    <p>Create a card</p>
                </a>
            </div>

            <div class="<?php
            if (!$this->session->userdata('user_id')) {
                echo 'col-lg-3';
            } else {
                echo 'col-lg-4';
            }
            ?> col-md-6">
                <a href="<?= base_url('Events/addevent'); ?>">
                    <div class="step-box">
                        <div class="step-box-img">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-3-event.svg" class="img-fluid simple">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-3-event-hover.svg" class="img-fluid hover">
                        </div>
                    </div>
                    <p>Create an event</p>
                </a>
            </div>

            <div class="<?php
            if (!$this->session->userdata('user_id')) {
                echo 'col-lg-3';
            } else {
                echo 'col-lg-4';
            }
            ?> col-md-6">
                <a href="<?= base_url('Dashboard'); ?>">
                    <div class="step-box">
                        <div class="step-box-img">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-4-share.svg" class="img-fluid simple">
                            <img src="<?php echo $this->config->item('common_assets_path'); ?>images/step-4-share-hover.svg" class="img-fluid hover">
                        </div>
                    </div>
                    <p>Share your cards</p>
                </a>
            </div>
            <?php if (!$this->session->userdata('user_id')) { ?>
                <div class="create-card col-12"><a href="<?= base_url("Register"); ?>">register now!</a></div>
            <?php } ?>

        </div>
    </div>
</section>


<section class="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="title text-center home-title">What user says</p>
                <p class="problem-tag-line text-center col-12 p-0"><?= strip_tags($home[10]['description']); ?></p>
            </div>
        </div>
        <div class="row">
            <?php
            $two = 0;
            if (!empty($testimonials) && count($testimonials) >= 2) {
                foreach ($testimonials as $key => $testimonials_) {
                    if ($two == 2)
                        break;
                    else
                        $two++;
                    ?>
                    <div class="col-lg-6">
                        <div class="testimonial-box">
                            <div class="client-management">
                                <div class="client-img">
                                    <img data-src="<?php echo base_url() . $this->config->item('upload_path_user_thumb_rm') . $testimonials_['image']; ?>" class="img-fluid lazyload">
                                </div>
                                <div class="client-name">
                                    <p class="client-name-text"><?= $testimonials_['name']; ?></p>
                                    <p class="client-name-designation"><?= strtoupper($testimonials_['position']); ?></p>
                                </div>
                                <div class="clearfix"></div>
                                <p class="client-word"><?= $testimonials_['description']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-lg-6">
                    <div class="testimonial-box">
                        <div class="client-management">
                            <div class="client-img">
                                <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/client.png" class="img-fluid lazyload">
                            </div>
                            <div class="client-name">
                                <p class="client-name-text">Caleb Cruz</p>
                                <p class="client-name-designation">MARKETING MANAGER</p>
                            </div>
                            <div class="clearfix"></div>
                            <p class="client-word">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas dui id
                                tempus accumsan. Praesent porttitor urna vitae ante semper, eu </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial-box">
                        <div class="client-management">
                            <div class="client-img">
                                <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/client.png" class="img-fluid lazyload">
                            </div>
                            <div class="client-name">
                                <p class="client-name-text">Caleb Cruz</p>
                                <p class="client-name-designation">MARKETING MANAGER</p>
                            </div>
                            <div class="clearfix"></div>
                            <p class="client-word">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas dui id
                                tempus accumsan. Praesent porttitor urna vitae ante semper, eu </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="create-card col-12"><a href="<?= base_url('Testimonials'); ?>">View All Testimonials</a></div>
        </div>
    </div>
</section>

<section class="connecting">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="sub-title">connecting people <br>
                    around the world for you</p>
            </div>
            <div class="col-12">
                <p class="sub-title-new"><?= strip_tags($home[11]['description']); ?></p>
            </div>
            <div class="create-card col-12"><a href="#">lets start</a></div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="homepagepopup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content video-modal">
            <div class="modal-body p-0">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <div class="cookies-box embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item p-0" id="video" width="500" height="315" src="<?php echo $popup[0]['video']; ?>">
                    </iframe>
                </div>
            </div>
            <div class="modal-footer border-0 video">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Skip</button>
            </div>
        </div>
    </div>
</div>


<?= $footer; ?>

