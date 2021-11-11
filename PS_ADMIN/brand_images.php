<?php
require 'includes/session.php';
//upload.php

$folder_name = SERVER_IMAGE_BRAND;
if(!empty($_FILES))
{
        $temp_file = $_FILES['file']['tmp_name'];
        $location = $folder_name . $_FILES['file']['name'];
        move_uploaded_file($temp_file, $location);
        $date = date("Y-m-d");
        $path = $_FILES['file']['name'];
        $id = $_SESSION['BRAND_ID_SESSION'];
        $res = SqlQuery("Select * from brands WHERE bid = '$id'");
        $row = mysqli_fetch_assoc($res);
        unlink($folder_name.$row['brand_img']);
        SqlQuery("Update brands set brand_img = '$path' WHERE bid = '$id'");
}   

elseif (isset($_POST['list_image_files']) && isset($_POST['brand_ids'])) {
    $id = get_safe_value($_POST['brand_ids']);
    
    ?>
    <div class="row" style="justify-content: center;align-items: center;">
        <?php
        if ($id == "") {
            ?>
            No Images Uploaded, Please Add some Images
            <?php
        }else{
            
            $res = SqlQuery("Select * from brands Where bid = '$id'");
            $row = mysqli_fetch_assoc($res);
            ?>
                <div class="col-6 col-sm-2  mt-2" style="">
                    <div class="container" style="display: flex;justify-content: center; margin-top: 10px;">
                        <img class="img-reponsive img-fluid" width="100px"
                            style="object-fit: cover;object-position: top;height: 100px;border-radius: 10px;margin: 0px 10px;"
                            src="<?= FRONT_SITE_IMAGE_BRAND.urldecode($row['brand_img']) ?>">
                    </div>
                    <div class="contaner" style="display: flex;justify-content: center; margin-top: 10px;">
                        <a href="javascript:void(0)" onclick="delete_prd_images('<?= $row['brand_img'] ?>', '<?= $row['bid'] ?>')"
                            class="text-danger remove_image">Remove</a>
                    </div>
                </div>
            <?php
        }
        ?>
                
             
    </div>
    
    <script>
    function delete_prd_images(brand_img, bid) {

        $.ajax({
            url: "brand_images.php",
            method: "post",
            data: {
                brand_img: brand_img,
                bid: bid
            },
            success: function(data) {
                list_image();
            }
        })
    }
    </script>
    <?php
}
else if(isset($_POST["brand_img"]) && isset($_POST['bid']))
{   
    $bid = get_safe_value($_POST['bid']);
    $brand_img = get_safe_value($_POST['brand_img']);
    $filename = SERVER_IMAGE_BRAND.$brand_img;
    unlink($filename);
    //  prx($filename);
    SqlQuery("update  brands set brand_img = '' WHERE bid = '$bid'");
}