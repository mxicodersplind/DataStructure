
<?php echo $header; ?>
<?php echo $sidebar; ?>
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business User</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('User/business'); ?>">Business User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Business User Details</li>
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

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Full Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="User Name" value="<?php echo $info[0]["name"]; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $info[0]["email"]; ?>" readonly="">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Business Name</label>
                                                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Phone" value="<?php echo $binfo[0]["businessname"]; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Tag Line</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["tagline"]; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Category</label>
                                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address Line 2" value="<?php echo $binfo[0]["category"]; ?>" readonly>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Address</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["address"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Number</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["number"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Website</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["website"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Email</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["email"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Social Media</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["socialmedia"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Youtube</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["youtube"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">IG</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["ig"]; ?>" readonly>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Offer</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["offer"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Store Hour</label>
                                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="<?php echo $binfo[0]["storehour"]; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="">Store Hour</label>
                                                    <textarea class="form-control" id="address1" name="address1" placeholder="Address Line 1" readonly=""><?php echo $binfo[0]["about"]; ?></textarea>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-4">
                                                <div class="form-group"> <label for="">Logo</label>
                                                   
                                                    <?php if($binfo[0]["logo"] != ""){?>
                                                    <img src="<?php echo base_url("../uploads/user/thumb/").$binfo[0]["logo"];?>" height="150px" width="150px">
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>



                                            <a class="btn btn-primary waves-effect waves-light m-t-10" href="<?php echo base_url('User/business'); ?>">Back</a>

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
    //                    city: {
    //                        required: true,
    //                    },
    //                    address1: {
    //                        required: true,
    //                    },
    //                    country_id: {
    //                        required: true,
    //                    },

    //                    state_id: {
    //                        required: true,
    //
    //                    },

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
                        },
    //                    address1: {
    //                        required: "Address Line1 is required.",
    //                    },
    //                    country_id: {
    //                        required: "Country is required.",
    //                    },
    //                    state_id: {
    //                        required: "State is required.",
    //                    },
                        zipcode: {
                            //required: "Zipcode is required.",
                            minlength: "Please enter atleast 5 digit."
                        },
    //                    city: {
    //                        required: "City is required.",
    //                    },

                    },
    //                errorPlacement: function (error, element) {
    //                    error.insertAfter($(element).parent('div')).addClass('control-label');
    //                }
                });
            </script>