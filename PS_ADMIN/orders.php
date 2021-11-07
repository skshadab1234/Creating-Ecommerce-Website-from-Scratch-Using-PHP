<?php
    require 'includes/header.php';
?>
    <style>
        .dark-mode .callout.callout-info, .dark-mode .callout, .dark-mode .invoice {
            background-color: #283046;
        }
    </style>
<?php
    if (isset($_GET['orderDetails']) && $_GET['orderDetails'] != '') {
        $orderDetails = get_safe_value($_GET['orderDetails']);

        $Sql = "SELECT * FROM payment_details WHERE Order_Id = '$orderDetails'";
        $res = mysqli_query($con, $Sql);
        $row = mysqli_fetch_assoc($res);

        $getAddressById = getAddressById($row['delivery_address_id']);
        
        ?>
        <div class="content-wrapper" style="min-height: 2645.34px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN_FRONT_SITE ?>">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section>

            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3" id="InvoiceDataToPrint">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                        <h4>
                            <img src="<?= FRONT_SITE_PATH.'logo.png' ?>" width="50px"> <?= SITE_NAME ?>
                            <small class="float-right">Date: <?= date("d M,Y", strtotime($row['created'])) ?></small>
                        </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong><?= SITE_NAME ?></strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            Phone: (804) 123-5432<br>
                            Email: info@almasaeedstudio.com
                        </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                        To
                        <address>
                           <?= $row['delivery_address_id'] ?>
                        </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Order ID:</b> <?= $row['Order_Id'] ?><br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="10%"></th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th>Total price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                        $product_ids = explode(',', $row['product_id']);
                                        array_unshift($product_ids,"");
                                        unset($product_ids[0]);
                                        foreach ($product_ids as $key => $value) {
                                            $Prdsql = "SELECT * from product_details where id = '$value'";
                                            $Prdres = mysqli_query($con , $Prdsql);
                                            while ($Prdrow = mysqli_fetch_assoc($Prdres)) {
                                                $ProductImageById = ProductImageById($Prdrow['id'],"limit 1");
                                                array_unshift($ProductImageById,"");
                                                unset($ProductImageById[0]);

                                                $product_varient = explode(',', $row['product_varient']);
                                                array_unshift($product_varient,"");
                                                unset($product_varient[0]);

                                                $product_qty = explode(',', $row['product_qty']);
                                                array_unshift($product_qty,"");
                                                unset($product_qty[0]);
                                                    
                                                    ?>

                                    <tr>
                                        <td>
                                        <img class="img-fluid" width="200px" height="200px"
                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" alt=""
                                                    title="" itemprop="image">
                                        </td>
                                        <td>
                                            <strong>
                                                <a>
                                                
                                                    <?= $Prdrow['product_name'] ?>
                                                </a>
                                            </strong><br>
                                            Size: <?= $product_varient[$key] ?><br>
                                        </td>
                                        <td>
                                            <?= $product_qty[$key] ?>
                                        </td>
                                        <td class="text-xs-right">₹ <?= $Prdrow['product_price'] ?></td>
                                        <td class="text-xs-right">₹ <?= $product_qty[$key] * $Prdrow['product_price'] ?></td>
                                    </tr>

                                    <?php
                                            }
                                        }
                                    ?>
                                
                            </tbody>
                            
                        </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                        
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                            <tbody><tr>
                                <th style="width:50%">Subtotal:</th>
                                <?php
                                    if ($row['delivery_charge'] == 'Free') {
                                        $subtotal = $row['amount_captured'];
                                    }else{
                                        // if delivery charge is free then don;t remove 500rs in subtotal 
                                        $subtotal = $row['amount_captured'] - 500;
                                    }
                                ?>
                                <td><?= "₹ ".$subtotal ?></td>
                            </tr>
                            <tr>
                                <th>Shipping and handling</th>
                                <?php
                                    if ($row['delivery_charge'] == 'Free') {
                                        $shipping_fee = '<span style="color:green">Free</span>';
                                    }else{
                                        $shipping_fee = "₹ 500";
                                    }
                                ?>
                                <td><?= $shipping_fee ?></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>₹ <?= $row['amount_captured'] ?></td>
                            </tr>
                            </tbody></table>
                        </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <button id="PrintInvoice" type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                            <a class="btn btn-primary float-right" style="margin-right: 5px;" href="<?= FRONT_SITE_PATH ?>download?filename=<?= $row['invoice_file'] ?>&redirect=<?= $url ?>">
                                <i class="fas fa-download"></i> Generate PDF
                            </a>
                        </div>
                    </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <?php
    }else{
        ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Orders</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

            <div class="content">
                <div class="container-fluid">
                    <div class="card_box">
                        <div class="card-header">
                            <h3 class="card-title float-right">
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
                                                        style="">Order Id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Order Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Total Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Payment</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Status</th>                                                        
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        Invoice</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                     $payment_details_res = SqlQuery("Select * from payment_details");
                                                     foreach ($payment_details_res as $key => $value) {
                                                         ?>
                                                            <tr>
                                                                <td><a href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'] ?>"><?= $value['Order_Id'] ?></a></td>
                                                                <td><?= date("d M,Y", strtotime($value['added_on'])) ?></td>
                                                                <td class="text-xs-right">₹ <?= $value['amount_captured'] ?></td>
                                                                <td class="hidden-md-down">By Card</td>
                                                                <td>
                                                                <?php
                                                                    if($value['payment_status'] == 'succeeded') {
                                                                        // Done 
                                                                        $text = 'Success';
                                                                        $color = 'green';
                                                                    }else{
                                                                        // Error 
                                                                        $text = 'Error';
                                                                        $color = 'red';
                                                                    }
                                                                ?>
                                                                <span class=" label label-pill bright" style="background-color:<?= $color ?> ; padding: 5px 10px">
                                                                    <?= $text ?>
                                                                </span>
                                                            </td>
                                                            <td class="hidden-md-down">
                                                                <a style="color:#ddd" href="<?= FRONT_SITE_PATH.'Invoices?orderId='.$value['Order_Id'].'&redirect='.$page_url ?>">Generate</a> / <a href="<?= FRONT_SITE_PATH ?>download?filename=<?= $value['invoice_file'] ?>&redirect=<?= $page_url ?>" style="color:#ddd">Download</a> / <a href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'].'&PrintData=print' ?>" style="color:#ddd">Print</a></td>
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


        <?php
    }

    if (isset($_GET['PrintData']) && $_GET['PrintData'] != '') {
        ?>
        <script>
                var printContents = document.getElementById("InvoiceDataToPrint").innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
        </script>
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

        $("#PrintInvoice").click( ()=> {
                var printContents = document.getElementById("InvoiceDataToPrint").innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
        });
        </script>