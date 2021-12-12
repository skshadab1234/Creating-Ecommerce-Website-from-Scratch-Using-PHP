<?php
    require 'includes/header.php';
    if (isset($_GET['operation']) && $_GET['operation'] != '') {
        $head_title = 'Add New Delivery';
        $id = '';
        $status = '';
        $delivery_boy_name = '';
        $email = '';
        $delvery_boy_pincode = '';
        $delivery_boy_phone = '';
        $delivery_boy_address = '';
        $delivery_boy_city = '';
        $delivery_boy_landmark = '';
        $delivery_boy_state = '';

        $type = '';

        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = get_safe_value($_GET['id']);
            $type= 'update';
            $users_res = SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_id = '$id'");
            if (mysqli_num_rows($users_res) > 0) {
                $row = mysqli_fetch_assoc($users_res);
                $delivery_boy_name = $row['delivery_boy_name'];
                $email = $row['delivery_boy_email'];
                $delivery_boy_phone = $row['delivery_boy_phone'];
                $delivery_boy_address = $row['delivery_boy_address'];
                $delvery_boy_pincode = $row['delvery_boy_pincode'];
                $delivery_boy_city = $row['delivery_boy_city'];
                $delivery_boy_landmark = $row['delivery_boy_landmark'];
                $delivery_boy_state = $row['delivery_boy_state']; 
                
                $head_title = 'Edit '.$row['delivery_boy_name']." (User Since ".date("M d, Y", strtotime($row['delivery_boy_added_on'])).")";
                $status = $row['delivery_boy_verifed'];
            }else{
                redirect(ADMIN_FRONT_SITE.'deliveryboy');
            }
        }
        ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $head_title ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <form action="" id="users_data_form">
                <input type="hidden" name="user_type" value="<?= $type ?>">
                <input type="hidden" name="user_id" value="<?= $id ?>">
                <div class="card_box card-default mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="delivery_boy_name">Full Name</label>
                                <input type="text" class="form-control" name="delivery_boy_name" value="<?= $delivery_boy_name ?>"
                                    placeholder="Enter First Name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_boy_email">Email	</label>
                                <input type="text" class="form-control" name="delivery_boy_email" value="<?= $email ?>" placeholder="Enter Email" required> 
                            </div>


                            <div class="form-group col-md-6">
                                <label for="delivery_boy_phone">Phone Number</label>
                                <input type="text" class="form-control" name="delivery_boy_phone" value="<?= $delivery_boy_phone ?>" placeholder="Enter Phone Number" required> 
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_boy_address">Address</label>
                                <input type="text" class="form-control" name="delivery_boy_address" value="<?= $delivery_boy_address ?>" placeholder="Enter Phone Number" required> 
                            </div>


                            <div class="form-group col-md-6">
                                <label for="delvery_boy_pincode">Pincode</label>
                                <input type="text" class="form-control" name="delvery_boy_pincode" id="postal_code" value="<?= $delvery_boy_pincode ?>" placeholder="Enter Pincode" onkeyup='GetStateCity()' required> 
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_boy_city">City</label>
                                <input type="text" class="form-control" name="delivery_boy_city" id="city_address" value="<?= $delivery_boy_city ?>" placeholder="Enter City" required> 
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_boy_state">State</label>
                                <input type="text" class="form-control" name="delivery_boy_state" id="state_address" value="<?= $delivery_boy_state ?>" placeholder="Enter State" required> 
                            </div>

                            <div class="form-group col-md-6">
                                <label>Landmark</label>
                                <select name="delivery_boy_landmark" id='delivery_boy_landmark'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;" required>
                                    <option selected="selected" disabled value="">Select Landmark</option>
                                    <option selected="selected" value="<?= $delivery_boy_landmark ?>"><?= $delivery_boy_landmark ?></option>

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_status">Status</label><br>
                                <?php
                                      if ($type == 'update') {
                                          if ($status == 1) {
                                              $active_status = 'checked';
                                              $blocked_status = '';
                                          }else{
                                              $active_status = '';
                                              $blocked_status = 'checked';
                                          }
                                      }else{
                                        $active_status = '';
                                        $blocked_status = '';
                                      }
                                  ?>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="checkboxPrimary1" name='user_status' value="1"
                                        <?= $active_status ?> required>
                                    <label for="checkboxPrimary1">Active
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline ml-2">
                                    <input type="radio" id="checkboxPrimary2" name='user_status' value="0"
                                        <?= $blocked_status ?> required>
                                    <label for="checkboxPrimary2">Block
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" id="submit_user" class="btn btn-primary float-right">Submit</button>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    }else{
        ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Delivery Boy</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <form action="" id="delete_all_category_checkbox_frm" method="post">
            <div class="content">
                <div class="container-fluid">
                    <div class="card_box">
                        <div class="card-header">

                            <h3 class="card-title float-right">

                                <button class="btn btn-success"><a
                                        href="<?= ADMIN_FRONT_SITE.'deliveryboy?operation=addNewDelivery' ?>"
                                        style="color:#fff">Add new</a></button>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <table id="example1"
                                            class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                            aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="" width="5%">Sr no</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="" width="5%">Image</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending" width="15%">
                                                        Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending" width="20%">
                                                        Email</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending" width="5%">
                                                        Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending" >
                                                        Tools</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category_listing_td">

                                                <?php
                                                   $delivery_boy_res = SqlQuery("SELECT * FROM delivery_boy");
                                                   foreach($delivery_boy_res  as $key => $value) {
                                                       if ($value['delivery_boy_verifed'] == 1) {
                                                           $user_status = '<p class="text-success">Active</p>';
                                                       }else{
                                                           $user_status = '<p class="text-danger">Blocked</p>';
                                                       }
                                                      
                                                       if ($value['delivery_boy_profile'] == '') {
                                                            $user_img = 'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg';
                                                        }else{
                                                            $user_img = DELIVERY_PROFILE.$value['delivery_boy_profile'];
                                                        }
                                                       ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><img class="img-reponsive img-fluid" width="80px" height="80px"
                                                            src="<?= $user_img ?>" alt="<?= $value['delivery_boy_name'] ?>"></td>
                                                    </td>
                                                    <td><?= $value['delivery_boy_name'] ?>
                                                    </td>
                                                    <td><?= $value['delivery_boy_email'] ?></td>
                                                    <td><?= $user_status ?></td>
                                                    <td>
                                                        <a href="<?= ADMIN_FRONT_SITE.'deliveryboy?operation=update&id='.$value['delivery_boy_id'] ?>"
                                                            class="btn btn-primary">
                                                            Update
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                   }                 
                                               ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </form>

        <?php
    }
?>

        <?php
    require 'includes/footer.php';
?>

        <script>
        $(function() {

            
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('#example1 tfoot th:gt(1)').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );

            $("#example1").DataTable({
                mark: {
                    diacritics: false
                },
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every( function () {
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
                        exportOptions: {
                            stripHtml: false,
                            columns: [1, 2, 3, 4]
                            //specify which column, you want to print

                        }
                    }

                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });


             $.validator.setDefaults({
                    submitHandler: function(form) {
                        $("#submit_user").attr("disabled", true);
                        $("#submit_user").html('Updating...');
                        $.ajax({
                            type: "POST",
                            url: "admin_ajax_call.php",
                            data: $(form).serialize(),
                            success: function(res) {
                                $("#submit_user").attr("disabled", false);
                                $("#submit_user").html('Submit');
                                var json = $.parseJSON(res);
                                if (json.status == 'email_change_success') {
                                    swal(json.message,json.text,'success');
                                    window.location = 'deliveryboy';
                                }

                                if (json.status == 'error') {
                                    swal(json.message,' ','error');
                                }

                                if (json.status == 'success') {
                                    swal(json.message,' ','success');
                                    window.location = 'deliveryboy';
                                }
                            }
                        });
                    }
                });
                $('#users_data_form').validate({
                    rules: {
                        firstname: {
                            required: true,
                            rangelength: [3, 255]
                        },
                        lastname: {
                            required: true,
                            rangelength: [3, 255]
                        },
                        email: {
                            required:true,
                            email: true 
                        },
                    },
                    messages: {
                        product_name: {
                            required: "Please enter a Product Name",
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
        });
        </script>