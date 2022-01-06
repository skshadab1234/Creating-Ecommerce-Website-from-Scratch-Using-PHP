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
.user-box img#imagePreview{border-radius: 50%;height: 150px;}

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
        <section id="wrapper">

            <nav data-depth="3" class="breadcrumb">
                <div class="container">
                    <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                                <span itemprop="name">Home</span>
                            </a>
                            <meta itemprop="position" content="1">
                        </li>

                        <li>
                            <span>Identity</span>
                        </li>

                    </ol>
                </div>
            </nav>


            <div class="container">
                <div class="row">
                    <div id="content-wrapper" class="col-lg-12 col-xs-12">
                        <section id="main">
                            <header class="page-header">
                                <h1>
                                    Your personal information
                                </h1>
                            </header>

                            <section id="content" class="page-content">
                                <aside id="notifications">
                                    <div class="container">
                                    </div>
                                </aside>

                                <div class="container1">
                                    <div class="user-box">
                                        <div class="img-relative">
                                            <!-- Loading image -->
                                            <div class="overlay uploadProcess" style="display: none;">
                                                <div class="overlay-content"><img src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif"/></div>
                                            </div>
                                            <!-- Hidden upload form -->
                                            <form method="post" action="ajax_call.php" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                                                <input type="file" name="identity_image_front_end_site" id="fileInput"  style="display:none"/>
                                            </form>
                                            <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                            <!-- Image update link -->
                                            <a class="editLink" href="javascript:void(0);"><img src="https://p.kindpng.com/picc/s/154-1541056_edit-edit-icon-svg-hd-png-download.png"/></a>
                                            <!-- Profile image -->
                                            <img src="<?php echo $user_img; ?>" id="imagePreview">
                                        </div>
                                    </div>
                                </div>
                                

                                <form action="" id="customer-form"
                                    class="js-customer-form" method="post">
                                    <section>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label text-xs-left text-lg-right">
                                                Social title
                                            </label>
                                            <div class="col-md-8 form-control-valign">
                                            <?php
                                                $array = array('Mr','Mrs');

                                                foreach ($array as $value) {
                                                    if($value == $user['social_title']){
                                                        ?>
                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="<?= $value ?>" checked="">
                                                            <span></span>
                                                        </span>
                                                        <?= $value  ?>
                                                    </label>

                                                    <?php
                                                    }else{
                                                        ?>

                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="<?= $value ?>" >
                                                            <span></span>
                                                        </span>
                                                        <?= $value  ?>
                                                    </label>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required text-xs-left text-lg-right">
                                                First name
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="firstname" type="text" value="<?= $user['firstname'] ?>"
                                                    required="">
                                                <span class="form-control-comment">
                                                    Only letters and the dot (.) character, followed by a space, are
                                                    allowed.
                                                </span>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required text-xs-left text-lg-right">
                                                Last name
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="lastname" type="text" value="<?= $user['lastname'] ?>"
                                                    required="">
                                                <span class="form-control-comment">
                                                    Only letters and the dot (.) character, followed by a space, are
                                                    allowed.
                                                </span>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>


                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required text-xs-left text-lg-right">
                                                Email
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="email" type="email"
                                                    value="<?= $user['email'] ?>" disabled>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required text-xs-left text-lg-right">
                                                Password
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group js-parent-focus">
                                                    <input class="form-control js-child-focus js-visible-password"
                                                        name="password" title="At least 5 characters long"
                                                        type="password" value="" pattern=".{5,}" required="">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-action="show-password">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>


                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label text-xs-left text-lg-right">
                                                New password
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group js-parent-focus">
                                                    <input class="form-control js-child-focus js-visible-password"
                                                        name="new_password" title="At least 5 characters long"
                                                        type="password" value="" pattern=".{5,}">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-action="show-password">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                                Optional
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label text-xs-left text-lg-right">
                                            </label>
                                            <div class="col-md-8">
                                                <span class="custom-checkbox">
                                                    <?php
                                                        if ($user['newsletter'] == 1) {
                                                            $checked= 'checked';
                                                        }else{
                                                            $checked = '';
                                                        }
                                                    ?>
                                                    <input name="newsletter" id="ff_newsletter" type="checkbox"
                                                        value="<?= $user['newsletter'] ?>" <?= $checked ?>>
                                                    <span><i class="fa fa-check rtl-no-flip checkbox-checked"
                                                            aria-hidden="true"></i></span>
                                                    <label class="" for="ff_newsletter">Sign up for our
                                                        newsletter<br><em>Be the first to know about our new arrivals
                                                            and exclusive offers.</em></label>
                                                </span>
                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>
                                    </section>


                                    <footer class="form-footer clearfix">
                                        <input type="hidden" name="submitCreate" value="1">

                                        <button class="btn btn-primary form-control-submit float-xs-right"
                                            data-link-action="save-customer" type="submit">
                                            Save
                                        </button>

                                    </footer>


                                </form>



                            </section>



                            <footer class="page-footer">



                                <a href="javascript:void(0)" onclick="location.href = document.referrer; return false;"
                                    class="btn account-link">
                                    <i class="material-icons"></i>
                                    <span>Back to your account</span>
                                </a>
                                <a href="<?= FRONT_SITE_PATH ?>" class="btn account-link">
                                    <i class="material-icons"></i>
                                    <span>Home</span>
                                </a>



                            </footer>


                        </section>



                    </div>



                </div>

            </div>

        </section>

       <?php
       require 'includes/footer.php';

       ?>

<script type="text/javascript">
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
        $('#imagePreview, #header_preview_img, #header_preview_img_desktop, #header_bottom_mobile_image').attr("src", fileName);
        $('#fileInput').attr("value", fileName);
        $('.uploadProcess').hide();
    }else{
        $('.uploadProcess').hide();
        alert('There was an error during file upload!');
    }
    return true;
}
</script>