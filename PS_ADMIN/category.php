<?php
    require 'includes/header.php';
    if (isset($_GET['operation']) && $_GET['operation'] != '') {
        $head_title = 'Add New Category';
        $category_name = '';
        $sub_category = '';
        $type= 'add';
        $id = '';

        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = get_safe_value($_GET['id']);
            $type= 'update';
            $cat_res = SqlQuery("SELECT * FROM shop_category WHERE cat_id = '$id'");
            if (mysqli_num_rows($cat_res) > 0) {
                $row = mysqli_fetch_assoc($cat_res);
                $category_name = $row['category_name'];
                $sub_category = $row['sub_category'];
                $status = $row['status'];
            }else{
                redirect(ADMIN_FRONT_SITE.'category');
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
            <form action="" id="category_data_form">
                <input type="hidden" name="category_type" value="<?= $type ?>">
                <input type="hidden" name="category_id" value="<?= $id ?>">
                <div class="card_box card-default mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" name="category_name"
                                    value="<?= $category_name ?>" placeholder="Enter Category Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sub_category">Sub Category</label>
                                <input type="text" class="form-control" name="sub_category" value="<?= $sub_category ?>"
                                    data-role="tagsinput">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sub_category">Status</label><br>
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
                                    <input type="radio" id="checkboxPrimary1" name='category_status' value="1"
                                        <?= $active_status ?> required>
                                    <label for="checkboxPrimary1">Active
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline ml-2">
                                    <input type="radio" id="checkboxPrimary2" name='category_status' value="0"
                                        <?= $blocked_status ?> required>
                                    <label for="checkboxPrimary2">Block
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" id="" class="btn btn-primary float-right">Submit</button>
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
                        <h1 class="m-0">Category</h1>
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
                            <button type="submit" class="btn btn-danger float-left" id="product_category_btn"
                                style="display:none">Delete</button>

                            <h3 class="card-title float-right">

                                <button class="btn btn-success"><a
                                        href="<?= ADMIN_FRONT_SITE.'category?operation=addNewCategory' ?>"
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
                                                    <th class="sorting"><input type="checkbox"
                                                            id="delete_check_category" onclick="select_all_category()">
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Category Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Category Sub-Category</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        STATUS</th>


                                                </tr>
                                            </thead>
                                            <tbody id="category_listing_td">

                                                <?php
                                                   $category_res =SqlQuery("SELECT * FROM shop_category");
                                                   foreach($category_res  as $key => $value) {
                                                       if ($value['status'] == 1) {
                                                           $cat_status = '<p class="text-success">Active</p>';
                                                       }else{
                                                           $cat_status = '<p class="text-danger">Blocked</p>';
                                                       }
                                                       ?>
                                                <tr>
                                                    <td class="dtr-control sorting_1" tabindex="0"><input
                                                            type="checkbox" name="checked_category_delete[]"
                                                            onclick="get_total_selected()" id="<?= $value['cat_id']?>"
                                                            value="<?= $value['cat_id'] ?>"></td>
                                                    <td><?= $key+1 ?></td>
                                                    <td><a
                                                            href="<?= ADMIN_FRONT_SITE.'category?operation=editCategory&id='.$value['cat_id'].'' ?>"><?= $value['category_name'] ?></a>
                                                    </td>
                                                    <td><?= $value['sub_category'] ?></td>
                                                    <td><?= $cat_status ?></td>
                                                </tr>
                                                <?php
                                                   }                 
                                               ?>
                                            </tbody>

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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
        });
        </script>