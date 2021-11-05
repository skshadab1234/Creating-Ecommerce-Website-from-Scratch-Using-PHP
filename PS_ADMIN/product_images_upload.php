<?php
require 'includes/session.php';
//upload.php
if (!is_dir(SERVER_IMAGE_PRODUCT.slugify($_SESSION['product_name']))) {
    mkdir(SERVER_IMAGE_PRODUCT.slugify($_SESSION['product_name']), 0777, true);
}
$ProductDetails = ProductDetails("WHERE product_name = '".$_SESSION['product_name']."'");
$folder_name = SERVER_IMAGE_PRODUCT.slugify($_SESSION['product_name']).'/';
if(!empty($_FILES))
{
    for ($i=0; $i < count($_FILES['file']['name']); $i++) { 
        $temp_file = $_FILES['file']['tmp_name'][$i];
        $location = $folder_name . $_FILES['file']['name'][$i];
        move_uploaded_file($temp_file, $location);
        $path = slugify($_SESSION['product_name']).'/'.$_FILES['file']['name'][$i];
        SqlQuery("INSERT into products_image(product_img, product_id, status) VALUES('$path', '".$ProductDetails[0]['id']."', '1')");
    }
}   

elseif (isset($_POST['list_image_files']) && isset($_POST['product_id']) && $_POST['product_id'] > 0) {
    $id = get_safe_value($_POST['product_id']);
    $ProductImageById = ProductImageById($id);
    array_unshift($ProductImageById,"");
    unset($ProductImageById[0]);
    ?>
    <div class="row" style="justify-content: center;align-items: center;">
        <?php
        if (!empty($ProductImageById)) {
            foreach ($ProductImageById as $key => $value) {
                $prod_img  = $value['product_img'];
                $ids  = $value['id'];
                ?>
        <div class="col-6 col-sm-2  mt-2" style="">
            <div class="container" style="display: flex;justify-content: center; margin-top: 10px;">
                <img class="img-reponsive img-fluid" width="100px"
                    style="object-fit: cover;object-position: top;height: 100px;border-radius: 10px;margin: 0px 10px;"
                    src="<?= FRONT_SITE_IMAGE_PRODUCT.urldecode($value['product_img']) ?>">
            </div>
            <div class="contaner" style="display: flex;justify-content: center; margin-top: 10px;">
                <a href="javascript:void(0)" onclick="delete_prd_images('<?= $prod_img ?>', '<?= $ids ?>')"
                    class="text-danger remove_image">Remove</a>
            </div>
        </div>
        <?php
                
            }    
        }else{
            ?>
        No Images Uploaded, Please Add some Images
        <?php
        }
        ?>
    </div>
    
    <script>
    function delete_prd_images(prod_img, pid) {

        $.ajax({
            url: "product_images_upload.php",
            method: "post",
            data: {
                prod_img: prod_img,
                pid: pid
            },
            success: function(data) {
                list_image();
            }
        })
    }
    </script>
    <?php
}
else if(isset($_POST["prod_img"]) && isset($_POST['pid']))
{   
    $image_id = get_safe_value($_POST['pid']);
    $prod_img = get_safe_value($_POST['prod_img']);
    $filename = SERVER_IMAGE_PRODUCT.$prod_img;
    unlink($filename);
    //  prx($filename);
    SqlQuery("delete from products_image WHERE id = '$image_id'");
}