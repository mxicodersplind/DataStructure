
<?= $afterheader; ?>
<style>
  label.error {
      color: red !important;
  }
</style>
<section class="dashboard-card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="title text-center">Profile</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="login-box">
                        <form action="<?= base_url("Profile/updateuserdata"); ?>" id="addfrm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <div class="form-group">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" Value="<?= !empty($logged_use['name'])?$logged_use['name']:''; ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email id" value="<?= !empty($logged_use['email'])?$logged_use['email']:''; ?>" readonly>
                        </div>
						
                        <div class="form-group">
                          <label for="">Profile Picture</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <?php
                          $imgURL = '';
                          if(!empty($logged_use['image'])) {
                            if (strpos($logged_use['image'], 'http') !== false)
                            $imgURL = $logged_use['image'];
                            else
                            $imgURL = base_url().$this->config->item('upload_path_user_thumb_rm').$logged_use['image'];
                          }
                        ?>
                        <div class="form-group">
                            <img src="<?= $imgURL; ?>" class="img-fluid" width="70px" Height="70px"/>
                        </div>

                        <div class="mt-4 full-btn">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Update Profile</button>
                        </div>

                        <div class="clearfix"></div>

                        </form>            
												
                    </div>
						
                    <p class="text-center register-link mt-4  mb-5">Want to change password? <a href="" data-toggle="modal" data-target="#change-password"> Click Here</a> </p>
                </div>
            </div>
        </div>
    </section>
	
<div class="modal fade" data-backdrop="static" data-keyboard="false"  id="change-password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open('Profile/updatepassword', array('id' => 'editfrm')); ?>
      <div class="modal-body">
        <div class="form-group mt-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
        </div>

        <div class="form-group mt-3">
          <input type="password" class="form-control" name="cnfpassword" id="cnfpassword" placeholder="Enter confirm password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="submit" class="btn btn-primary">Update Password</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
        
<?= $footer; ?>

<div class="modal fade" id="alert-label" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="center-label alertText" id="alertText"></p>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>


<script>

    $("#submit").click(function( event ) {
      event.preventDefault();
      var editfrm = $("#editfrm");
      if(editfrm.valid() == true) {
        var form = $('#editfrm')[0];
        var formData = new FormData(form);
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
        $.ajax({
            url: "<?php echo base_url() . 'Profile/updatepassword' ?>",
            type: "POST",
            dataType: "json",
            enctype: 'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.status == 'success') {
                  $('#alertText').removeClass('text-danger');
                  $('#alertText').addClass('text-success');
                  $('.alertText').text(data.msg);
                  $('#alert-label').modal('toggle');
                  $('#change-password').modal('toggle');
                }
                else {
                  $('#alertText').removeClass('text-success');
                  $('#alertText').addClass('text-danger');
                  $('.alertText').text(data.msg);
                  $('#alert-label').modal('toggle');
                }
            }
        });
      }
    });


    jQuery("#addfrm").validate({
        rules: {
            fullname: "required",
        },
        messages: {
            fullname: "Full Name is required.",
        }
    });

    jQuery("#editfrm").validate({
        rules: {
            password: {
                required: true,
            },
            cnfpassword: {
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Password is required.",
            },
            cnfpassword: {
                required: "Confirm Password is required.",
                equalTo: "Do not match Password."
            },
        }
    });
</script>