<?php
    require 'includes/header.php';
    if (isset($_GET['operation']) && $_GET['operation'] != '') {
        $head_title = 'Add New Users';
        $id = '';
        $status = '';
        $firstname = '';
        $lastname = '';
        $email = '';
        $newsletter = '';

        $type = '';

        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = get_safe_value($_GET['id']);
            $type= 'update';
            $users_res = SqlQuery("SELECT * FROM users WHERE id = '$id'");
            if (mysqli_num_rows($users_res) > 0) {
                $row = mysqli_fetch_assoc($users_res);
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $email = $row['email'];
                $head_title = 'Edit '.$row['firstname'].' '.$row['lastname']." (User Since ".date("M d, Y", strtotime($row['userAdded_On'])).")";
                $status = $row['verify'];
                $newsletter = $row['newsletter'];
            }else{
                redirect(ADMIN_FRONT_SITE.'users');
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
                            <div class="col-sm-6">
                                <!-- radio -->
                                <div class="form-group clearfix">
                                    <label for="social_title">Social Title</label><br>
                                    <?php
                                        $gender = array("1"=>'Mr',"2"=>'Mrs');
                                        foreach ($gender as $key => $value) {
                                           
                                            if($type == 'update' ){
                                                if ($value == $row['social_title']) {
                                                    $checked = 'checked';
                                                }else{
                                                    $checked = '';
                                                }
                                               
                                            }else{
                                                $checked = '';
                                            }
                                            
                                            if ($key == 1) {
                                                $ml_2 = '';
                                            }else{
                                                $ml_2 = 'ml-2';
                                            }
                                            ?>
                                                 <div class="icheck-primary d-inline <?= $ml_2 ?>">
                                                    <input type="radio" id="radioPrimary<?= $key ?>" value="<?= $value   ?>" name="social_title" <?= $checked ?> >
                                                    <label for="radioPrimary<?= $key ?>"> <?= $value ?>
                                                    </label>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                   
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" name="firstname" value="<?= $firstname ?>"
                                    placeholder="Enter First Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control" name="lastname" value="<?= $lastname ?>" placeholder="Enter Last Name"> 
                            </div>


                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $email ?>" placeholder="Enter Email"> 
                            </div>

                            <div class="form-group col-md-6">
                                <label for="user_status">Status</label><br>
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

                            <div class="form-group col-md-6">
                                <label for="newsletter">Newsletter</label><br>
                                <?php
                                      if ($type == 'update') {
                                          if ($newsletter == 1) {
                                              $active_news = 'checked';
                                              $blocked_news = '';
                                          }else{
                                              $active_news = '';
                                              $blocked_news = 'checked';
                                          }
                                      }else{
                                        $active_news = '';
                                        $blocked_news = '';
                                      }
                                  ?>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="checkboxPrimary3" name='newsletter' value="1"
                                        <?= $active_news ?> required>
                                    <label for="checkboxPrimary3">Active
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline ml-2">
                                    <input type="radio" id="checkboxPrimary4" name='newsletter' value="0"
                                        <?= $blocked_news ?> required>
                                    <label for="checkboxPrimary4">Block
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
                        <h1 class="m-0">Users</h1>
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
                                        href="<?= ADMIN_FRONT_SITE.'users?operation=addNewUsers' ?>"
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
                                                        style="">Sr no</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Image</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Email</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Newsletter</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Tools</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category_listing_td">

                                                <?php
                                                   $user_res = SqlQuery("SELECT * FROM users");
                                                   foreach($user_res  as $key => $value) {
                                                       if ($value['verify'] == 1) {
                                                           $user_status = '<p class="text-success">Active</p>';
                                                       }else{
                                                           $user_status = '<p class="text-danger">Blocked</p>';
                                                       }
                                                       if ($value['newsletter'] == 1) {
                                                          $newsletter = '<p class="text-success">Active</p>';
                                                        }else{
                                                            $newsletter = '<p class="text-danger">Blocked</p>';
                                                        }
                                                       if ($value['user_img'] == '') {
                                                            $user_img = 'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg';
                                                        }else{
                                                            $user_img = USER_PROFILE.$value['user_img'];
                                                        }
                                                       ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><img class="img-reponsive img-fluid" width="80px" height="80px"
                                                            src="<?= $user_img ?>" alt=""></td>
                                                    </td>
                                                    <td><?= $value['social_title'].'. '.$value['firstname'].' '.$value['lastname'] ?>
                                                    </td>
                                                    <td><?= $value['email'] ?></td>
                                                    <td><?= $newsletter ?></td>
                                                    <td><?= $user_status ?></td>
                                                    <td>
                                                        <a href="<?= ADMIN_FRONT_SITE.'users?operation=update&id='.$value['id'] ?>"
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
            $('#example1 tfoot th:gt(1)').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );
            $("#example1").DataTable({
                mark: {
                    diacritics: false
                },
                "responsive": true,
                "autoWidth": false,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
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
                            columns: [1, 2, 3, 4, 5]
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
                                var json = $.parseJSON(res);
                                $("#submit_user").attr("disabled", false);
                                $("#submit_user").html('Submit');
                                if (json.status == 'email_change_success') {
                                    swal(json.message,json.text,'success');
                                    window.location = 'users';
                                }

                                if (json.status == 'error') {
                                    swal(json.message,' ','error');
                                }

                                if (json.status == 'success') {
                                    swal(json.message,' ','success');
                                    window.location = 'users';
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