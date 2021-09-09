
<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Edit Page</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('Pages'); ?>">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Page</li>
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
                            <div class="alert alert-danger fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong><?php echo $this->session->flashdata('error'); ?></strong> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php echo form_open('Pages/editnew/' . base64_encode($info[0]['page_id']), array('id' => 'addfrm', 'class' => '', 'method' => 'POST', 'enctype' => 'multipart/form-data')); ?>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group"> <label for="">Page Title <span class="error">*</span></label>
                                                    <input type="text" class="form-control" id="page_title" name="page_title" value="<?php echo $info[0]['pagetitle']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group"> <label for="">Description <span class="error">*</span></label>
                                                    <textarea id="description" rows="10" name="description" class="textarea_editor form-control form-control-lg form-control-solid"><?php echo trim($info[0]['description']); ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-t-10">Update</button>
                                        <a class="btn btn-default waves-effect waves-light m-t-10" href="<?php echo base_url('Pages'); ?>">Cancel</a>
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

        <script>
            CKEDITOR.replace('description');
            jQuery("#addfrm").validate({
                rules: {
                    page_title: "required",
                    description: "required"
                },
                messages: {
                    page_title: "Page Title is required.",
                    description: "Description is required."
                },
                // errorPlacement: function (error, element) {
                //     error.insertAfter($(element).parent('div')).addClass('control-label');
                // }
            });
        </script>