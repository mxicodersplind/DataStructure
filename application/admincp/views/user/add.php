
<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">User</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('User'); ?>">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
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
                                        <?php echo form_open('User/addnew/', array('id' => 'addfrm', 'class' => '', 'method' => 'POST', 'enctype' => 'multipart/form-data')); ?>
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">User Name<span class="error">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="User Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Email<span class="error">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Phone<span class="error">*</span></label>
                                                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Phone">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Address Line 1</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Address Line 2</label>
                                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address Line 2">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Country</label>
                                                    <select class="form-control" name="country_id" id="country_id" onchange="getstate()">
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($country as $l) { ?>
                                                            <option value="<?php echo $l['id']; ?>"><?php echo $l['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">State</label>
                                                    <select class="form-control" name="state_id" id="state_id" >
                                                        <option value="">Select State</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Zip Code<span class="error">*</span></label>
                                                    <input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="5" placeholder="Zip Code">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Profile Image</label>
                                                    <input type="file" class="filestyle" name="image" id="image" data-buttonbefore="true">
                                                    <label for="image" class="error"></label>
                                                    <p class="error">Allowed Types: .jpg .jpeg .png .bmp</p>
                                                    <p style="color:red">Image with maximumm 600 x 600 pixels dimension allowed.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-t-10">Add User</button>
                                        <a class="btn btn-default waves-effect waves-light m-t-10" href="<?php echo base_url('User'); ?>">Cancel</a>
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
            function getstate() {
                 var state_id = $('#country_id').val();
            $.ajax({
                url: "<?php echo base_url() . 'User/getstate' ?>",
                type: "POST",
                dataType: "json",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', 'state_id': state_id},
                //     catch : false,
                success: function (data) {

                    if (data.status == 'success') {
                        $('#state_id').empty();

                        $("#state_id").append('<option value="">Choose One</option>');

                        for (i = 0; i < data.location.length; i++) {

                            $("#state_id").append('<option value="' + data.location[i]['id'] + '">' + data.location[i]['name'] + '</option>');
                        }

                    }

                }
            });
            }
            $('#image').change(function () {
                $('#image').removeData('imageWidth');
                $('#image').removeData('imageHeight');
                var file = this.files[0];
                var tmpImg = new Image();
                tmpImg.src = window.URL.createObjectURL(file);
                tmpImg.onload = function () {
                    width = tmpImg.naturalWidth,
                            height = tmpImg.naturalHeight;
                    $('#image').data('imageWidth', width);
                    $('#image').data('imageHeight', height);
                }
            });
            $.validator.addMethod('dimention', function (value, element, param) {
                if (element.files.length == 0) {
                    return true;
                }
                var width = $(element).data('imageWidth');
                var height = $(element).data('imageHeight');
                //alert(width);
                if (width <= param[0] && height <= param[1])
                {
                    return true;
                } else {
                    return false;
                }
            }, 'Please upload an image with maximumm 600 x 600 pixels dimension.');

            jQuery("#addfrm").validate({
                rules: {
                    name: "required",

                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "<?php echo site_url('User/emailExits') ?>",
                            type: "post",
                            data: {
                                email: function () {
                                    return $("#email").val();

                                },

                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            }
                        }
                    },
                    contact_no: {
                        required: true,
                    },
                    zipcode: {
                        //required: true,
                        number: true,
                        minlength: 5
                    },

                    image: {
                        dimention: [600, 600]
                    },
                },
                messages: {
                    name: "User name is required",

                    email: {
                        required: "Email is required.",
                        remote: "Email already exists."
                    },
                    contact_no: {
                        required: "Phone no. is required.",
                    },quired: "State is required.",

                    zipcode: {
                        minlength: "Please enter atleast 5 digit."
                    },

                },
            });
        </script>