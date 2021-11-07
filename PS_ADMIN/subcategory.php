<?php
    require 'includes/header.php';
    if (isset($_GET['operaton']) && $_GET['operaton'] != '') {
        $Category_data = ExecutedQuery("SELECT * FROM shop_category WHERE status = 1");
        $head_title = 'Add New Subcategory';
        $category_name = '';
        $sub_category = '';
        $type= 'add';
        $id = '';
        $category = '';
        $category_subcat_id  = '';
        $status  = '';
        $subcat_value = '';

        if (isset($_GET['subcat_id']) && $_GET['subcat_id'] > 0) {
            $id = get_safe_value($_GET['subcat_id']);
            $type= 'update';
            $head_title = 'Edit Subcategory';
            $cat_res = SqlQuery("SELECT * FROM sub_category WHERE subcat_id = '$id'");
            if (mysqli_num_rows($cat_res) > 0) {
                $row = mysqli_fetch_assoc($cat_res);
                $category = $row['category_id'];
                $category_subcat_id = $row['category_subcat_id'];
                $subcat_value = $row['subcat_value'];
                $status = $row['subcat_status'];
                
            }else{
                redirect(ADMIN_FRONT_SITE.'subcategory');
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
            <form action="" id="subcategory_data_form">
                <input type="hidden" name="subcategory_type" value="<?= $type ?>">
                <input type="hidden" name="subcategory_id" value="<?= $id ?>">
                <div class="card_box card-default mt-3">
                    <div class="card-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label>Category</label>
                                <select name="category_name" id='product_category_121'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    required onchange="product_category_Change()">
                                    <option selected="selected" disabled>Select Category</option>
                                    <?php
                                        foreach($Category_data as $key => $val) {
                                            if ($category == '') {
                                                $selected = '';
                                            }else{
                                                if($val['cat_id'] == $category){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = '';
                                                }
                                            }
                                            
                                            ?>
                                        <option <?= $selected ?> value="<?= $val['cat_id'] ?>"><?= $val['category_name'] ?></option>
                                    </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sub Category</label>
                                <select name="sub_category_data" id='sub_category_data'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    required>
                                    <option selected="selected" disabled>Sub Category</option>
                                   
                                </select>
                                <input type="hidden" id="sub_cat_recive_from_Db" value="<?= $category_subcat_id ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="subcat_value">Subacategory Values</label>
                                <input type="text" class="form-control" data-role="tagsinput"
                                    value="<?= $subcat_value ?>" name="subcat_value">
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

        <form action="" id="delete_all_subcategory_checkbox_frm" method="post">
            <div class="content">
                <div class="container-fluid">
                    <div class="card_box">
                        <div class="card-header">
                            <button type="submit" class="btn btn-danger float-left" id="product_subcategory_btn"
                                style="display:none">Delete</button>

                            <h3 class="card-title float-right">

                                <button class="btn btn-success"><a
                                        href="<?= ADMIN_FRONT_SITE.'subcategory?operaton=addnew' ?>"
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
                                                            id="delete_subcheck_category" onclick="select_all_subcategory()">
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Sub Category Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Sub-Category Values</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        STATUS</th>

                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Tools</th>


                                                </tr>
                                            </thead>
                                            <tbody id="category_listing_td">

                                                <?php
                                                   $SUB_category_res =SqlQuery("SELECT * FROM sub_category LEFT JOIN shop_category ON shop_category.cat_id = sub_category.category_id");
                                                   
                                                   foreach($SUB_category_res  as $key => $value) {
                                                       if ($value['subcat_status'] == 1) {
                                                           $subcat_status = '<p class="text-success">Active</p>';
                                                       }else{
                                                           $subcat_status = '<p class="text-danger">Blocked</p>';
                                                       }

                                                       $subcategories_name = explode(",", $value['sub_category']);

                                                       ?>
                                                <tr>
                                                    <td class="dtr-control sorting_1" tabindex="0"><input
                                                            type="checkbox" name="checked_subcategory_delete[]"
                                                            onclick="get_total_selected()" id="<?= $value['subcat_id']?>"
                                                            value="<?= $value['subcat_id'] ?>"></td>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $value['category_name'] ?> / <?= $value['category_subcat_id'] ?></td>
                                                    <td><?= $value['subcat_value'] ?></td>
                                                    <td><?= $subcat_status ?></td>
                                                    <td>
                                                    <a href="<?= ADMIN_FRONT_SITE.'subcategory?operaton=addnew&subcat_id='.$value['subcat_id'] ?>">Edit</a>
                                                        
                                                    </td>
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

             //Initialize Select2 Elements
             $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

    
        </script>