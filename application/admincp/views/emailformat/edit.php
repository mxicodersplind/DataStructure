<?php echo $header; ?>
<?php echo $sidebar; ?>

<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Email Templates</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">

                            <a href="<?php echo site_url('Emailformat'); ?>">Admin email templates</a>

                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
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
                            <div class="alert alert-success fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('fail'); ?></strong> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <?php

                                    $url = base_url('Emailformat/index');
                                    ?>
                                    <div class="col-xs-12">
                                        <?php echo form_open('Emailformat/update', array('class' => '', 'name' => 'addform', 'id' => 'addform')); ?>
                                        <input type="hidden" id="id" name="id" value="<?php echo base64_encode($editinfo['id']); ?>" >  
                                        <input type="hidden" id="last_url_params" name="last_url_params" value="<?php echo $url; ?>" >  
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" readonly="" id="etitle" name="etitle" placeholder="Title" class="form-control" value="<?php echo $editinfo['title']; ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" id="esubject" name="esubject" placeholder="Subject" class="form-control" value="<?php echo $editinfo['subject']; ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Variable</label><br>
                                                <?php echo $editinfo['variables']; ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email Format</label>
                                                <textarea id="eemailformat" rows="10" name="eemailformat" class="form-control"><?php echo $editinfo['emailformat']; ?></textarea>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 ">
                                            <button type="submit" class="btn btn-primary pull-right ">Update</button>
                                            <a href="<?php echo $back_url; ?>" class="btn btn-default pull-right m-r-5">Cancel</a>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>

        <script type="text/javascript">
            $(document).ready(function () {

                CKEDITOR.replace('eemailformat', {
                    enterMode: CKEDITOR.ENTER_BR
                });

            });

            jQuery("#addfrm").validate({
                rules: {
                    esubject: "required",
                    eemailformat: function ()
                    {
                        CKEDITOR.instances.eemailformat.updateElement();
                    },
                    

                },
                messages: {
                    esubject: "Subject is required",
                    eemailformat: "Email Format name is required"

                },
                errorPlacement: function (error, element) {
                    error.insertAfter($(element).parent('div')).addClass('control-label');
                }
            });
        </script>


