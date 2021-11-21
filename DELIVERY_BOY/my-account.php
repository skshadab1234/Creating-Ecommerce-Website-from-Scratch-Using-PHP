<?php
    require 'includes/header.php';

?>
<style>
    .container1{width: 100%;display: flex;justify-content: center;align-items: center;}
    .user-box {
        width: 200px;
        border-radius: 0 0 3px 3px;
        padding: 10px;
        position: relative;
    }

    .user-box form{display: inline;}
    .user-box img#imagePreview{border-radius: 50%;height: 150px;width: 150px;object-fit: contain;}

    .editLink {
        position:absolute;
        top:28px;
        right:10px;
        opacity:0;
        transition: all 0.3s ease-in-out 0s;
        -mox-transition: all 0.3s ease-in-out 0s;
        -webkit-transition: all 0.3s ease-in-out 0s;
        background:rgba(255,255,255,0.2);
    }
    .img-relative:hover .editLink{
        opacity: 1;
        width: 100px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .editLink img{
        max-width: 100px;
        height: 40px;
    }
    .overlay{
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        background: rgba(255,255,255,0.7);
    }
    .overlay-content {
        position: absolute;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        top: 50%;
        left: 0;
        right: 0;
        text-align: center;
        color: #555;
    }
    .uploadProcess img{
        max-width: 207px;
        border: none;
        box-shadow: none;
        -webkit-border-radius: 0;
        display: inline;
    }
    .img-relative{
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card_box ">
              <div class="card-header">
                <div class="container1">
                        <div class="user-box">
                            <div class="img-relative">
                                <!-- Loading image -->
                                <div class="overlay uploadProcess" style="display: none;">
                                    <div class="overlay-content"><img src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif"/></div>
                                </div>
                                <!-- Hidden upload form -->
                                <form method="post" action="delivery_ajax_call.php" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                                    <input type="file" name="identity_image_delivery_front_end_site" id="fileInput"  style="display:none"/>
                                </form>
                                <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                <!-- Image update link -->
                                <a class="editLink" href="javascript:void(0);"><img src="https://p.kindpng.com/picc/s/154-1541056_edit-edit-icon-svg-hd-png-download.png"/></a>
                                <!-- Profile image -->
                                <img src="<?php echo $adminImg; ?>" id="imagePreview">
                            </div>
                        </div>
                    </div>
                </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" value= '<?= $DELIVERYData['delivery_boy_email'] ?>' placeholder="Enter email" disabled=''>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Full Name</label>
                    <input type="text" name="boy_name" class="form-control" id="exampleInputPassword1" value= '<?= $DELIVERYData['delivery_boy_name'] ?>' placeholder="Enter Name">
                  </div>

                  <div class="form-group">
                    <label for="delivery_boy_phone">Phone Number</label>
                    <input type="text" name="delivery_boy_phone" class="form-control" value= '<?= $DELIVERYData['delivery_boy_phone'] ?>' placeholder="Phone Number">
                  </div>

                  <div class="form-group">
                    <label for="delivery_boy_address">Address</label>
                    <input type="text" name="delivery_boy_address" class="form-control" value= '<?= $DELIVERYData['delivery_boy_address'] ?>' placeholder="Address">
                  </div>

                  <div class="form-group">
                      <label for="delvery_boy_pincode">Zip/Postal Code</label>
                      <input class="form-control" name="delvery_boy_pincode" placeholder="Enter zipcode to get state and city" type="number" value="<?= $DELIVERYData['delvery_boy_pincode'] ?>" required="" id="postal_code"
                            onkeyup= "GetStateCity()">
                  </div>

                  <div class="form-group">
                      <label>
                          City
                      </label>
                      <input class="form-control"  id="city_address" type="text" value="<?= $DELIVERYData['delivery_boy_city'] ?>"
                          maxlength="64" disabled="" required=''>
                      <input type="hidden" name="city" id="city_for_db" value="<?= $DELIVERYData['delivery_boy_city'] ?>" required=''>
                  </div>

                  <div class="form-group">
                      <label>
                          State
                      </label>
                      <input class="form-control" name="state" id="state_address" type="text" value="<?= $DELIVERYData['delivery_boy_state'] ?>"
                              maxlength="64" disabled="" required=''>
                      <input type="hidden" name="state" id="state_for_db" value="<?= $DELIVERYData['delivery_boy_state'] ?>" required=''>
                  </div>

                  <div class="form-group">
                      <label>
                          Address Landmark
                      </label>
                          <div class="custom-select2">
                              <select class="form-control form-control-select "
                                  name="delivery_boy_landmark" id="delivery_boy_landmark" required="">
                                  <option value="<?= $DELIVERYData['delivery_boy_landmark'] ?>"  selected=""><?= $DELIVERYData['delivery_boy_landmark'] ?></option>
                                  
                              </select>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="">Change Password</label>
                    <input type="text" name="change_password" class="form-control" placeholder="Update Password">
                  </div>

                  <hr>
                  <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="curr_password" class="form-control" required='' value= '' placeholder="Enter Current Password">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<?php
    require 'includes/footer.php';
?>  
<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function (form) {
      $.ajax({
          type: "POST",
          url: "delivery_ajax_call.php",
          data: $(form).serialize(),
          success: function(res) {
              var data = $.parseJSON(res);
              if (data.status == 'success') {
                  swal(data.message,data.text,data.status);
                  $("#delivery_boy_name_link").html(data.Name);
              }

              if (data.status == 'error') {
                  swal(data.message,'',data.status);
            }
            

          }
      });
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      boy_name: {
        required: true,
        rangelength: [10, 255]
      },
      delvery_boy_pincode: {
        rangelength: [6, 6]
      }
     
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      boy_name: {
        required: "Please provide a name",
        rangelength: "Your password must be at least 10 characters long"
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});

$(document).ready(function () {
    //If image edit link is clicked
    $(".editLink").on('click', function(e){
        e.preventDefault();
        $("#fileInput:hidden").trigger('click');
    });

    //On select file to upload
    $("#fileInput").on('change', function(){
        var image = $('#fileInput').val();
        var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        //validate file type
        if(!img_ex.exec(image)){
            alert('Please upload only .jpg/.jpeg/.png/.gif file.');
            $('#fileInput').val('');
            return false;
        }else{
            $('.uploadProcess').show();
            $('#uploadForm').hide();
            $( "#picUploadForm" ).submit();
        }
    });
});

//After completion of image upload process
function completeUpload(success, fileName) {
    if(success == 1){
        $('#imagePreview').attr("src", "");
        $('#imagePreview, #delivery_boy_profile').attr("src", fileName);
        $('#fileInput').attr("value", fileName);
        $('.uploadProcess').hide();
    }else{
        $('.uploadProcess').hide();
        alert('There was an error during file upload!');
    }
    return true;
}
</script>
</body>
</html>
