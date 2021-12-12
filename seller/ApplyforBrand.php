<?php
    require 'includes/header.php';

    if (isset($_GET['brandid']) && $_GET['brandid'] > 0 && isset($_GET['brand']) && $_GET['brand'] != '') {
        $brand_name = get_safe_value($_GET['brand']);
        $brandid = get_safe_value($_GET['brandid']);
        $message = '';

        $brand_data = ExecutedQuery("SELECT * FROM brands WHERE brand_status = 1 && bid='$brandid' && brand_name='$brand_name'");
        if($brand_data == 0) {
            redirect(SELLER_FRONT_SITE);
        }else{
            $brand_data = $brand_data[0];
            $seller_request_approve_explode = explode(",", $brand_data['seller_request_approved']);
            $seller_request_in_process_explode = explode(",", $brand_data['seller_request_in_process']);
            $seller_request_rejected_explode = explode(",", $brand_data['seller_request_rejected']);
            $seller_id = $_SESSION['SELLER_ID'];
            if (in_array($seller_id, $seller_request_approve_explode)) {
                $status_text = '<span class="text-success">Approved</span>';
            }
            else if (in_array($seller_id, $seller_request_in_process_explode)) {
                $status_text = '<span class="text-warning">In process</span>';
            }
            else if (in_array($seller_id, $seller_request_rejected_explode)) {
                $status_text = '<span class="text-danger">Rejected</span>';
            }
            else{
                $status_text = '<span class="text-info">Applying</span>';
            }
            if (isset($_POST['apply_btn'])) {
                $check_approval = ExecutedQuery("Select * from brand_approval_doc WHERE seller_id = '$seller_id' && brand_id='$brandid'");
                if ($check_approval == 0) {
                    // not exist
                    $folder_name = SERVER_SELLER.'images/approval_forms/';
                    $temp_file = $_FILES['approval_file']['tmp_name'];
                    $location = $folder_name . time()."-".$_FILES['approval_file']['name'];
                    $filename = time()."-".$_FILES['approval_file']['name'];
                    move_uploaded_file($temp_file, $location);
                    SqlQuery("Insert into brand_approval_doc(seller_id,brand_id,document_data,document_type) VALUES('$seller_id','$brandid','$filename','Invoice')");
                    
                    array_push($seller_request_in_process_explode,$seller_id); // Pushing seller id in brands process column
                    $seller_request_in_process_string = implode(",",array_filter($seller_request_in_process_explode)); // array to string for inserting to db
                    SqlQuery("UPDATE brands SET seller_request_in_process='$seller_request_in_process_string' WHERE bid = '$brandid'");
                    $message .= '<div class="alert alert-success">
                                    Request Sended Successfully. You will get response in 2-3 working days
                                </div>';
                    
                }else{
                    // exist
                    
                    $message .= '<div class="alert alert-danger">
                                    Request Already Sended
                                </div>';
                }
            }
    
        ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Apply for Brand Approval</li>
                </ol>
            </nav>
    
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Apply for Brand Approval</h3>
                                <p><?= $message ?></p>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="approval_form_send" method="post" action="" enctype='multipart/form-data'>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Kindly upload Invoice Copy</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="file" name="approval_file" class="form-control custom-file-inputs" accept="image/*, application/pdf">
                                        </div>
                                        <div class="mt-3">
                                            <img src="" width="200" style="display:none;" />    
                                            <a href="" target="_blank" id='dis_blob_path'></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" name="apply_btn" class="btn btn-info float-right mb-2">Apply</button>
                                
                            </div>
                            <!-- /.card-footer -->
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Status: <?= $status_text ?></h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Brand Approval Details</strong></p>
                                    <p><strong>Brand</strong>: <?= $brand_name ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }else{
        ?>

        <?php
    }
   
    require 'includes/footer.php';
?>

<script>
   
    $('#approval_form_send').validate({

        rules: {
            select_doc_type: {
                required: true,
            },
            approval_file: {
                required : true,
                extension: "jpg,jpeg,png,pdf",
            },
        },

        messages: {
            approval_file:{
                extension: 'Only JPG,JPEG and PNG files extension are accepted',
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
        
    })
    $(".custom-file-inputs").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        var ext = this.value.match(/\.([^\.]+)$/)[1];
        var tmppath = URL.createObjectURL(event.target.files[0]);
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                $("img").fadeIn("slow").attr('src',URL.createObjectURL(event.target.files[0]));
                $("#dis_blob_path").attr("href",tmppath);
                $("#dis_blob_path").html("View Image");
                break;
            case 'pdf':
                $("#dis_blob_path").attr("href",tmppath);
                $("#dis_blob_path").html("View PDF");
            
            default:
                $("img").hide();
        }
        
    });
</script>