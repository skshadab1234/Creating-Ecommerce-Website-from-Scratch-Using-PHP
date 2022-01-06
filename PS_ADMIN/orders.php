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
        $track_id = explode(",",$row['tracking_id']);
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
                        <table id="example2" class="table table-striped">
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
                                        foreach ($product_ids as $key => $value) {
                                            $Prdsql = "SELECT * from product_details where id = '$value'";
                                            $Prdres = mysqli_query($con , $Prdsql);
                                            
                                            $track_res = SqlQuery("SELECT * FROM ordertrackingdetails WHERE track_id = '$track_id[$key]'");
                                            $track_row = mysqli_fetch_assoc($track_res);
                                            $current_status_track = explode(",",$track_row['Current_Status']);
                                            $filtered_status = array_filter($current_status_track);

                                            if (in_array("Delivered",$current_status_track)) {
                                                $rate_res = SqlQuery("SELECT * FROM product_rating where Track_id = '".$track_row['track_id']."'");
                                                $rate_row = mysqli_fetch_assoc($rate_res);
                                                
                                                if ($rate_row != '') {
                                                    $appen_table_head = '<th>Rated</th>';
                                                    $star_rate = '<span class="float-right">
                                                                '.star_rate($rate_row['rated_no']).'               
                                                              </span>';    
                                                    $appen_table_body = '<td>'.$star_rate.'</td>';
                                                }else{
                                                    $appen_table_head = '<th>Rate Now</th>';
                                                    // rating_system_add
                                                    $star_rate = "<a href=".FRONT_SITE_PATH.'trackmyorder?track_id='.$track_id[$key].'&Order_id='.$row['Order_Id'].'#rating_system_add'." target='_blank'>Rate this product</a>";
                                                    $appen_table_body = '<td>'.$star_rate.'</td>';
                                                }
                                                
                                            }else{
                                                $star_rate = '';
                                                $appen_table_head = '';
                                                $appen_table_body = '';
                                            }

                                            while ($Prdrow = mysqli_fetch_assoc($Prdres)) {
                                                $ProductImageById = ProductImageById($Prdrow['id'],"limit 1");
                                                array_unshift($ProductImageById,"");
                                                unset($ProductImageById[0]);

                                                $product_varient = explode(',', $row['product_varient']);

                                                $product_qty = explode(',', $row['product_qty']);
                                                
                                                $product_message = explode(",PSFASHIONSTORE,",$row['product_message']);

                                                $payment_prod_price = explode(',', $row['payment_prod_price']);

                                                $estimate_delivery_date = explode(',', $row['estimate_delivery_date']);

                                                $per_product_invoice = explode(',', $row['per_product_invoice']);

                                                $track_ids = explode(",",$row['tracking_id']);
                                                
                                                if ($per_product_invoice[$key] != '') {
                                                    $invoice_message =  "<a href=".PER_PRODUCT_INVOICE.$per_product_invoice[$key]." target='_blank'>#".substr($per_product_invoice[$key],0,-4)."</a>";
                                                }else{
                                                    $invoice_message = "<a href='javascript:void(0)' 
                                                                 id='DownloadInvoiceAtag_".$orderDetails.$track_ids[$key].$Prdrow['id'].$product_varient[$key]."'
                                                                 onclick=\"DownloadInvoice('".$orderDetails."','".$track_ids[$key]."', '".$Prdrow["id"]."', '".$product_qty[$key]."', '".$product_varient[$key]."', '".$payment_prod_price[$key]."', '".$per_product_invoice[$key]."','".$url."')\">Download</a>";
                                                }

                                                $message_display = '';
                                                if(!empty($product_message[$key])){
                                                    $message_display .= '<div class="card_box mt-3">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">
                                                                                    Message for Order
                                                                                </h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <p class="text-success"> '.$product_message[$key].'</p>
                                                                            </div>
                                                                            
                                                                        </div>';
                                                                   
                                                }
                                                    ?>

                                   <tr>
                                        <td><img style="width:5rem;height:100%;max-width: 5rem;" src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" ></td>
                                        <td>
                                            <strong>
                                                <a>
                                                
                                                    <?= $Prdrow['product_name'] ?>
                                                </a>
                                            </strong><br>
                                            Size: <?= $product_varient[$key] ?><br>
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Estimate Delivery</th>
                                                    <th>Tracking Id</th>
                                                    <th>Current Status</th>
                                                    <th>Download Invoice</th>
                                                    <?= $appen_table_head ?>
                                                </thead>
                                                <tbody>
                                                    <td><?= date("D M d, Y", strtotime($estimate_delivery_date[$key])) ?></td>
                                                    <td><a href="<?= ADMIN_FRONT_SITE.'TrackOrders?track_id='.$track_id[$key].'&Order_id='.$row['Order_Id'] ?>" target="_blank"><?= $track_id[$key] ?></a></td>
                                                    <td><span style="color:green"><?= end($filtered_status) ?></td>
                                                    <td id="addInvoiceMessagefromRespone_<?= $orderDetails.$track_ids[$key].$Prdrow["id"].$product_varient[$key] ?>"><?= $invoice_message ?></td>
                                                    <?= $appen_table_body ?>
                                                </tbody>
                                            </table>
                                            <div id="mesage_display_order_<?= $key ?>">
                                                <?= $message_display ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $product_qty[$key] ?>
                                        </td>
                                        <td class="text-xs-right">₹ <?= number_format($payment_prod_price[$key])  ?></td>
                                        <td class="text-xs-right">₹ <?= number_format($product_qty[$key] * $payment_prod_price[$key]) ?></td>
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
                            <a class="btn btn-primary float-right" style="margin-right: 5px;" href="<?= FRONT_SITE_PATH ?>download?filename=<?= $row['invoice_file'] ?>&filepath=UserInvoice/<?= $row['invoice_file'] ?>&redirect=<?= $url ?>">
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
                                                    <th>Order Id</th>
                                                    <th>Order Date</th>
                                                    <th>Total Price</th>
                                                    <th>Payment</th>
                                                    <th>Status</th>                                                        
                                                    <th data-orderable="false"> Invoice</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                     $payment_details_res = SqlQuery("Select * from payment_details");
                                                     foreach ($payment_details_res as $key => $value) {
                                                        if ($value['payment_mode'] == 'wallet') {
                                                            $payment_mode = 'Wallet';
                                                        }elseif ($value['payment_mode'] == 'stripe') {
                                                            $payment_mode = 'Stripe';
                                                        }else{
                                                            $payment_mode = "";
                                                        }
                                                         ?>
                                                            <tr>
                                                                <td><a href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'] ?>"><?= $value['Order_Id'] ?></a></td>
                                                                <td><?= date("d M,Y h:i", strtotime($value['created'])) ?></td>
                                                                <td class="text-xs-right">₹ <?= $value['amount_captured'] ?></td>
                                                                <td class="hidden-md-down">By <?= $payment_mode ?></td>
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
                                                                <a style="color:#ddd" href="<?= FRONT_SITE_PATH.'Invoices?orderId='.$value['Order_Id'].'&redirect='.$page_url ?>">Generate</a> / <a href="<?= FRONT_SITE_PATH ?>download?filename=<?= $value['invoice_file'] ?>&filepath=UserInvoice/<?= $value['invoice_file']?>&redirect=<?= $page_url ?>" style="color:#ddd">Download</a> / <a href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'].'&PrintData=print' ?>" style="color:#ddd">Print</a></td>
                                                            </tr>
                                                         <?php
                                                     }
                                                ?>
                                               
                                            </tbody>
                                            <style>
                                                #example1 tfoot th:nth-last-child(1) input{
                                                   visibility:hidden;
                                                }
                                            </style>
                                            <tfoot>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Date</th>
                                                    <th>Total Price</th>
                                                    <th>Payment Status</th>
                                                    <th>Status</th>
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
            $('#example1 tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
            } );

            $("#example1").DataTable({
                mark: {
                    diacritics: false
                },
                "order": [[ 1, "desc" ]],
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
                            columns: [0, 1, 2, 3, 4]
                            //specify which column, you want to print

                        }
                    }

                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
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