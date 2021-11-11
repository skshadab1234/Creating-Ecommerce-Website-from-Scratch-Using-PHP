<?php
    require 'includes/header.php';
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cart</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class="content">
            <div class="container-fluid">
                <form action="" id="brand_data_form" method="post">
                    <div class="card_box card-default mt-3">
                        <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label>Products Name</label>
                                    <select name="product_id" id='product_id'
                                        class="form-control select2 select2-hidden-accessible" style="width: 100%;" required>
                                        <option selected="selected" disabled>Select Products</option>
                                        <?php
                                            $ProductDetails = ProductDetails('Where product_status = 1');
                                            foreach($ProductDetails as $key => $val) {
                                                ?>
                                        <option value="<?= $val['id'] ?>"><?= $val['product_name'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label>Products varient</label>
                                <select name="Product_size_list" id='Product_size_list'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;" required>
                                    <option selected="selected" disabled>Select Size</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="data_sheet_name">Product Quantity</label>
                                <input type="text" class="form-control" name="prod_qty"
                                    value="" placeholder="Enter Product Price">
                            </div>
                        </div>
                        <div class="card-footer">
                                <button class="btn btn-primary float-right">Submit</button>
                            </div>
                            <!-- /.row -->
                    </div>
                </form>
            </div>

            <div class="container-fluid">

            </div>
        </div>

<?php
    require 'includes/footer.php';
?>

<script>
     //Initialize Select2 Elements
     $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    
</script>