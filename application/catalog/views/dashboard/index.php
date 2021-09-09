
<?= $afterheader; ?>
<style>
    .bottom-qr {
        width: 75px !important;
    }
    .list-icon button {
    cursor: auto;
}
</style>
<section class="dashboard-card">
    <div class="container container-1740">
        <div class="row">
            <a href="<?= base_url("Dashboard/addcard"); ?>" class="btn btn-primary add-n-card">Add Card </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container container-1740">
        <div class="row mycards" id="mycards">

        </div>
          <button class="btn btn-primary load-more"  type="button" onclick="loadmore()">load more</button>
    </div>
</section>

<?= $footer; ?>

<div class="" id="show-div"></div>

<!-- Forget Modal -->
<div class="modal fade" id="delete-label" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Dashboard/deletecard', array('id' => 'deletefrm')); ?>
            <div class="modal-body">
                <p class="center-label">Are you sure you want to delete this card ?</p>
                <input type="hidden" value="" id="deleteid" name="deleteid" />
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="share-label" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Share Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" class="form-control" value="" id="share_card_id" readonly />
                <input type="hidden" class="form-control" value="" id="share_card_user_id" readonly />
                <input type="text" class="form-control" value="" id="share_url" readonly />
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <span class="text-center" ><h5 id="copy_conf"></h5></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="myFunction()">Copy URL</button>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="pic" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content big-pic qr-img">
            <div class="modal-body">
                <img data-toggle="modal" src="" id="modalpic" class="modalpic img-fluid radius-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="qr" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content big-pic qr-img">
            <div class="modal-body">
                <img src="" id="modalqr" class="modalqr img-fluid">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>



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
                
                <p class="center-label alertText" id="alertText">The link you followed has expired.</p>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    var myCards = '';
    var startCardPos = 0;
    var endCardPos = 10;
    var cardid = 0;
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
    
    
        function loadmore(){
              loading.open(5000);
     if (myCards.length != endCardPos) {
         
                if (myCards.length < endCardPos + 4)
                    endCardPos = myCards.length;
                if (myCards.length > endCardPos){
                    endCardPos += 10;
                    if(endCardPos > myCards.length){
                        endCardPos = myCards.length;
                    }
                }
                var myCardsHtml = '';
                var i;
                 
                for (i = startCardPos; i < endCardPos; i++) {
                    
                    myCardsHtml += `<div class="box-with-btn">
                                <div class="card-design" id="card` + myCards[i]['id'] + `">
                                  <div class="right-side">
                                    <div class="qr">`;
                     if (myCards[i]['picture'] != '' && myCards[i]['picture'] != null){
                        myCardsHtml += `<img data-toggle="modal" data-target="#pic" data-id="` + myCards[i]['id'] + `" onclick="showpic(this)" src="<?php echo base_url() . $this->config->item('upload_path_user_thumb_rm') ?>` + myCards[i]['picture'] + `" class="img-fluid radius-border pic` + myCards[i]['id'] + `">`;
                    } 
    myCardsHtml += `<div class="dropdown float-left">
                            <button class="coremenu" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img src="<?php echo  $this->config->item('common_assets_path')."images/drp.png" ?>">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-id="` + myCards[i]['id'] + `" data-toggle="modal" data-target="#delete-label" onClick="deleteModal(this)">Remove</a></li>
                            
                            </ul>
                          </div>
                          </div>
                                    <p class="ceo-name" id="`+ myCards[i]['id']+`" ><b>` + myCards[i]['name'] + `</b></p>
                                    <p class="ceo-deg"><span>` + myCards[i]['designation'] + `</span></p>
                                    <div class="fl-card-width">
                                      <div class="about-info qr-add">`;
                    if (myCards[i]['company'] != '')
                        myCardsHtml += `<p><i class="far fa-building"></i> ` + myCards[i]['company'] + `</p>`;
                    if (myCards[i]['phone'] != '' && myCards[i]['phone'] != 0)
                        myCardsHtml += `<p><i class="fas fa-mobile-alt"></i><a href="tel:` + myCards[i]['phone'] + `" target="_blank"> ` + myCards[i]['phone'] + `</a></p>`;
                    if (myCards[i]['email'] != '')
                        myCardsHtml += `<p><i class="far fa-envelope"></i><a href="mailto:` + myCards[i]['email'] + `" target="_blank"> ` + myCards[i]['email'] + ` </a></p>`;
                    if (myCards[i]['website'] != ''){
                        var site = "";
                        var n =myCards[i]['website'].includes("http");
                        var m = myCards[i]['website'].includes("https");
                        if(n || m){
                            site = myCards[i]['website'];
                        }else{
                             site = "http://"+myCards[i]['website'];
                        }
                        myCardsHtml += `<p><i class="fas fa-globe-europe"></i><a href="` + site + `" target="_blank"> ` + myCards[i]['website'] + ` </a></p>`;
                    }
                    if (myCards[i]['address'] != '' || myCards[i]['state'] != '' || myCards[i]['city'] != '' || (myCards[i]['zip'] != '' && myCards[i]['zip'] != 0))
                        myCardsHtml += `<p><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q=` + myCards[i]['address'] + `, ` + myCards[i]['city'] + `, ` + myCards[i]['state'] + ` - ` + myCards[i]['zip'] + `" target="_blank"> ` + myCards[i]['address'] + `, ` + myCards[i]['city'] + `, ` + myCards[i]['state'] + ` - ` + myCards[i]['zip'] + ` </a></p>`;
                    myCardsHtml += `</div>

                                    </div>
                                    <div class="login-with-social-media">
                                      <ul>`;
                    if (myCards[i]['facebook'] != '')
                        myCardsHtml += `<li> <a href="` + myCards[i]['facebook'] + `" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>`;
                    if (myCards[i]['twitter'] != '')
                        myCardsHtml += `<li> <a href="` + myCards[i]['twitter'] + `" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>`;
                   
                    if (myCards[i]['linkedin'] != '')
                        myCardsHtml += `<li> <a href="` + myCards[i]['linkedin'] + `" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>`;
                    if (myCards[i]['instagram'] != '')
                        myCardsHtml += `<li> <a href="` + myCards[i]['instagram'] + `" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>`;
                   
    myCardsHtml += `</ul>
                                    </div>
                             <div class="view-share-btn">
                               </button><button type="button" id="card-view">#Views : &nbsp;` + myCards[i]['cardcount'] + `
                                       </button>
                                      <button type="button" id="card-view" >#Save : &nbsp;` + myCards[i]['cardsave'] + `</button>
                                    </div>
                                  </div>
                                   <div class="bottom-qr d-flex align-items-center">
                                        <img data-toggle="modal" data-target="#qr" data-id="` + myCards[i]['id'] + `" onclick="showqr(this)" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= base_url('p/'); ?>` + myCards[i]['slug'] + `" class="img-fluid qr` + myCards[i]['id'] + `">
                                      </div>
                                </div>
                      
                      <div class="list-icon two-icon">
                               <button type="button" onclick="viewcard('` + myCards[i]['slug'] + `')" style="cursor:pointer">View</button>
                               <button type="button" onclick="share(` + myCards[i]['user_id'] + `,` + myCards[i]['id'] + `)" style="cursor:pointer">Share</button>
                              
                         </div>
                                
                              </div>`;
                }

 if (myCards.length == endCardPos) {
                    $(".load-more").css("display","none");
                }
                if (myCards.length > endCardPos)
                    startCardPos = endCardPos;
                $("#mycards").append(myCardsHtml);
            } else {
                // myCardsCount = 4;
            }
            
             setTimeout(function(){ loading.close() }, 2000);
}
    
    
    
    
    
    
    
    $(document).ready(function () {
      
        getMyCards();
        $("#show-div").click(function () {
            $('body').removeClass('card-view-body');
            $("#card" + cardid).removeClass('show-card');
            cardid = 0;
        });
    });
    function cstmchk(user_id, id) {
        cardid = id;
        $("#card" + id).addClass("show-card");
        $('body').addClass('card-view-body');
        $.ajax({
            url: "<?php echo base_url() . 'Dashboard/viewlog' ?>",
            type: "POST",
            dataType: "json",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', user_id: user_id, card_id: id},
            catch : false,
            success: function (data) {
                if (data.status == 'success') {
                } else {
                }
            }
        });
    }

    function deleteModal(elem) {
        $('#deleteid').val($(elem).data("id"));
    }

    function showpic(elem) {
        var src = $('.pic' + $(elem).data("id")).attr('src');
        $('.modalpic').attr('src', src);
    }

    function showqr(elem) {
        var src = $('.qr' + $(elem).data("id")).attr('src');
        $('.modalqr').attr('src', src);
    }

    function edit(id) {
        window.location.href = '<?= base_url('Dashboard/editcard/'); ?>' + btoa(id);
    }
    
    function addprofile(id){
        window.location.href = '<?= base_url('Dashboard/addprofile/'); ?>' + btoa(id); 
    }
    
     function letsbegin(id){
        window.location.href = '<?= base_url('Dashboard/letsbegin/'); ?>' + btoa(id); 
    }
    
     function viewcard(id){
        window.location.href = '<?= base_url('p/'); ?>' + id; 
    }


    $(window).scroll(function () {

    });
    function getMyCards() {
        $.ajax({
            url: "<?php echo base_url() . 'Dashboard/getMyCards' ?>",
            type: "POST",
            dataType: "json",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            catch : false,
            success: function (data) {
                if (data.status == 'success') {
                    myCards = data.data;
                    if (myCards.length < endCardPos)
                        endCardPos = myCards.length;
                    var myCardsHtml = '';
                    var i;
                    for (i = startCardPos; i < endCardPos; i++) {
                        var addedit = "Add";
                       
                        myCardsHtml += `<div class="box-with-btn">
                                    <div class="card-design" id="card` + myCards[i]['id'] + `">
                                      <div class="right-side">
                                        <div class="qr">`;
                        if (myCards[i]['picture'] != '' && myCards[i]['picture'] != null){
                            myCardsHtml += `<img data-toggle="modal" data-target="#pic" data-id="` + myCards[i]['id'] + `" onclick="showpic(this)" src="<?php echo base_url() . $this->config->item('upload_path_user_thumb_rm') ?>` + myCards[i]['picture'] + `" class="img-fluid radius-border pic` + myCards[i]['id'] + `">`;
                        }
    myCardsHtml += `<div class="dropdown float-left">
                            <button class="coremenu" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img src="<?php echo  $this->config->item('common_assets_path')."images/drp.png" ?>">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-id="` + myCards[i]['id'] + `" data-toggle="modal" data-target="#delete-label" onClick="deleteModal(this)">Remove</a></li>
                            </ul>
                          </div>
                          </div>
                                        <p class="ceo-name" id="`+ myCards[i]['id']+`" ><b>` + myCards[i]['name'] + `</b></p>
                                        <p class="ceo-deg"><span>` + myCards[i]['designation'] + `</span></p>
                                        <div class="fl-card-width">
                                          <div class="about-info qr-add">`;
                        if (myCards[i]['company'] != '')
                            myCardsHtml += `<p><i class="far fa-building"></i> ` + myCards[i]['company'] + `</p>`;
                        if (myCards[i]['phone'] != '' && myCards[i]['phone'] != 0)
                            myCardsHtml += `<p><i class="fas fa-mobile-alt"></i><a href="tel:` + myCards[i]['phone'] + `" target="_blank"> ` + myCards[i]['phone'] + `</a></p>`;
                        if (myCards[i]['email'] != '')
                            myCardsHtml += `<p><i class="far fa-envelope"></i><a href="mailto:` + myCards[i]['email'] + `" target="_blank"> ` + myCards[i]['email'] + ` </a></p>`;
                        if (myCards[i]['website'] != ''){
                             var site = "";
                        var n =myCards[i]['website'].includes("http");
                        var m = myCards[i]['website'].includes("https");
                        if(n || m){
                            site = myCards[i]['website'];
                        }else{
                             site = "http://"+myCards[i]['website'];
                        }
                            myCardsHtml += `<p><i class="fas fa-globe-europe"></i><a href="` + site + `" target="_blank"> ` + myCards[i]['website'] + ` </a></p>`;
                        }
                        if (myCards[i]['address'] != '') {
                            var address = myCards[i]['address'] + `<br>`;
                        } else {
                            var address = myCards[i]['address'];
                        }
                        if (myCards[i]['address'] != '' || myCards[i]['state'] != '' || myCards[i]['city'] != '' || (myCards[i]['zip'] != '' && myCards[i]['zip'] != 0))
                            myCardsHtml += `<p><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q=` + myCards[i]['address'] + ` ` + myCards[i]['city'] + ` ` + myCards[i]['state'] + `  ` + myCards[i]['zip'] + `" target="_blank"> ` + myCards[i]['address'] + ` ` + myCards[i]['city'] + ` ` + myCards[i]['state'] + ` ` + myCards[i]['zip'] + ` </a></p>`;
                        myCardsHtml += `</div>

                                        </div>
                                        <div class="login-with-social-media">
                                          <ul>`;
                        if (myCards[i]['facebook'] != '')
                            myCardsHtml += `<li> <a href="` + myCards[i]['facebook'] + `" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>`;
                        if (myCards[i]['twitter'] != '')
                            myCardsHtml += `<li> <a href="` + myCards[i]['twitter'] + `" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>`;
                       
                        if (myCards[i]['linkedin'] != '')
                            myCardsHtml += `<li> <a href="` + myCards[i]['linkedin'] + `" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>`;
    if (myCards[i]['instagram'] != '')
                        myCardsHtml += `<li> <a href="` + myCards[i]['instagram'] + `" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>`;
                                       
    myCardsHtml += `</ul>
                                        </div>
                                
                                 <div class="view-share-btn">
                               </button><button type="button" id="card-view">#Views : &nbsp;` + myCards[i]['cardcount'] + `
                                       </button>
                                      <button type="button" id="card-view" >#Save : &nbsp;` + myCards[i]['cardsave'] + `</button>
                                    </div>

                                      </div>
                                      <div class="bottom-qr d-flex align-items-center">
                                        <img data-toggle="modal" data-target="#qr" data-id="` + myCards[i]['id'] + `" onclick="showqr(this)" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= base_url('p/'); ?>` + myCards[i]['slug'] + `" class="img-fluid qr` + myCards[i]['id'] + `">
                                      </div>
                                    </div>
                               <div class="list-icon two-icon">
                               <button type="button" onclick="viewcard('` + myCards[i]['slug'] + `')" style="cursor:pointer">View</button>
                               <button type="button" onclick="share(` + myCards[i]['user_id'] + `,` + myCards[i]['id'] + `,'` + myCards[i]['slug'] + `')" style="cursor:pointer">Share</button>
                              
                         </div>
                                   
                                  </div>`;
                    }

 if (myCards.length == endCardPos) {
                    $(".load-more").css("display","none");
                }
                    if (myCards.length > endCardPos)
                        startCardPos = endCardPos;
                    $("#mycards").html("");
                    $("#mycards").html(myCardsHtml);
                } else {
                    var myCardsHtml = '';
                    myCardsHtml += `<div class="col-md-12 text-center">
                                  <a class="text-danger" href="<?= base_url("Dashboard/addcard"); ?>"><div class="no-card-img"> <img data-src="<?php echo $this->config->item('common_assets_path'); ?>images/no-img/nocard-created.jpg" class="img-fluid lazyload"></div><h4 class="smalletst">You do not have any card created, please <span class="underline">click here</span> to create your first card</h4></a>
                                  </div>`;
                           $(".load-more").css("display","none");
                    $("#mycards").html("");
                    $("#mycards").html(myCardsHtml);
                }
            }
        });
    }
    
  

    //var addthis_share = {url: ''};
    function share(user_id, id,slug) {
        $('#copy_conf').html('');
        $('#share_card_id').val(id);
        $('#share_card_user_id').val(user_id);
        $('#share_url').val("<?= base_url('p/'); ?>" + slug);
        $('#share-label').modal();

    }

    function myFunction() {
        var copyText = document.getElementById("share_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        $('#copy_conf').html('<br>URL Copied!');
        var id = $('#share_card_id').val();
        var user_id = $('#share_card_user_id').val();
        $.ajax({
            url: "<?php echo base_url() . 'Dashboard/sharelog' ?>",
            type: "POST",
            dataType: "json",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', user_id: user_id, card_id: id},
            catch : false,
            success: function (data) {
                if (data.status == 'success') {
                } else {
                }
            }
        });
    }
    
    
    
    function showdiv(id){
  
    var check = $("."+id).hasClass("none-information");
        if(check){
            $("."+id).removeClass("none-information");
        }else{
            $("."+id).addClass("none-information");
        }
    }

</script>
<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script>