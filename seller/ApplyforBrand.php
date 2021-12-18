<?php
    require 'includes/header.php';
    $seller_id = $_SESSION['SELLER_ID']; // Global Seller id

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
            
            if (in_array($seller_id, $seller_request_approve_explode)) {
                $status_text = '<span class="text-success">Approved</span>';
            }
            else if (in_array($seller_id, $seller_request_in_process_explode)) {
                $status_text = '<span class="text-warning">In process</span>';
            }
            else if (in_array($seller_id, $seller_request_rejected_explode)) {
                $status_text = '<span class="text-danger">Rejected</span>';
                redirect(SELLER_FRONT_SITE.'ApplyforBrand');
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
                    $date = date("Y-m-d H:i:s");
                    SqlQuery("Insert into brand_approval_doc(seller_id,brand_id,document_data,document_type,created_on) VALUES('$seller_id','$brandid','$filename','Invoice','$date')");
                    
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
                redirect(SELLER_FRONT_SITE.'ApplyforBrand');
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
            </nav>

            <div class="container-fluid">
                <h4>Track Approval Requests.</h4>
                <hr>
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 card p-2">
                        <div class="row">
                            <div class="col-sm-12">

                                <table id="example1"
                                    class="table table-bordered table-striped dataTable dtr-inline text-center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th width="5%">ID</th>
                                            <th width="20%">Attributes</th>
                                            <th width="10%">Status</th>
                                            <th width="50%">Comments</th>
                                            <th width="15%">CREATED ON</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                             $seller_brand_approval = ExecutedQuery("SELECT * FROM brand_approval_doc WHERE seller_id = '$seller_id'");
                                             if($seller_brand_approval != 0) {
                                                foreach ($seller_brand_approval as $key => $value) {
                                                    $brand_details = ExecutedQuery("SELECT * FROM brands WHERE bid = '".$value['brand_id']."'");
                                                    if($brand_details != 0) {
                                                        $brand_details = $brand_details[0];

                                                        $seller_request_approved_explode = explode(",",$brand_details['seller_request_approved']);
                                                        $seller_request_in_process_explode = explode(",",$brand_details['seller_request_in_process']);
                                                        $seller_request_rejected_explode = explode(",",$brand_details['seller_request_rejected']);

                                                        if(in_array($seller_id,$seller_request_approved_explode)){
                                                            $approval_text = '<span class="text-success">Approved</span>';
                                                        }
                                                        else if(in_array($seller_id,$seller_request_in_process_explode)){
                                                            $approval_text = '<span class="text-warning">In Process</span>';
                                                        }
                                                        else if(in_array($seller_id,$seller_request_rejected_explode)){
                                                            $approval_text = '<span class="text-danger">Rejected</span>';
                                                        }else{
                                                            $approval_text = '<span class="">Send for approval</span>';
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?= $value['id'] ?></td>
                                                        <td>Brand: <?= $brand_details['brand_name'] ?></td>
                                                        <td><?= $approval_text ?></td>
                                                        <td><?= $value['notes_from_brand_owner'] ?></td>
                                                        <td><?= date("M d, Y h:i:s A", strtotime($value['created_on'])) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                             }
                                        ?>
                                   </tbody>
                                   <tfoot>
                                        <tr role="row">
                                            <th width="5%"></th>
                                            <th width="20%">Attributes</th>
                                            <th width="10%">Status</th>
                                            <th width="50%">Comments</th>
                                            <th width="15%">CREATED ON</th>
                                        </tr>
                                   </tfoot>
                                </table>    
                            </div>  
                        </div>  
                    </div>  
            </div>

            <input type="hidden" value='<?= $sell_row['seller_fullname'] ?>' id="seller_fullname">
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
                extension: "jpg,jpeg,png,pdf,webp",
            },
        },

        messages: {
            approval_file:{
                extension: 'Only JPG,JPEG,PNG and WEBP files extension are accepted',
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
            case 'webp':
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
    
    var seller_fullname = $("#seller_fullname").val();
    $('#example1 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );
    $("#example1").DataTable({
        "language": {
            "emptyTable": "No Brand Approval Request Submitted"
        },
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        initComplete: function () {
            // Apply the search
            this.api().columns('').every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        buttons: [{
            extend: 'print',
            title: function(){
                var printTitle = '<h5 class="text-center mb-3">List of brand approval request belong to '+seller_fullname+' Seller Account</h5>';
                return printTitle
            },
            exportOptions: {
                stripHtml: false,
                columns: [0,1, 2, 3]
                //specify which column you want to print

            }
        },

    ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>