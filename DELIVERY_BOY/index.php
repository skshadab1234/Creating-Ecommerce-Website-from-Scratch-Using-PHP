<?php
    
    require 'includes/header.php';

    
    // $DeliveredOrder = explode(",",);
    // $totalDelivery = count($DeliveredOrder);

    $DelveredOrder = GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['Delivered'];
    $PendingOrders = GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['Pending'];

    $DelveredOrders = explode(",",$DelveredOrder);
    $totalDelivery = ($DelveredOrders[0] == 0) ? 0 : count($DelveredOrders);

    $explodePendingOrder = explode(",",$PendingOrders);
    $totalPending = ($explodePendingOrder[0] == 0) ? 0 : count($explodePendingOrder);
    
    $DeliveredTrackId = explode(",",GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['DeliveredTrackId']);
    $DeliveredTrackId = array_filter($DeliveredTrackId);
    $PendingTrackId = explode(",",GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['PendingTrackId']);
    $PendingTrackId = array_filter($PendingTrackId);

    
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box card_box">
                        <div class="inner" id="orders_data">
                            <h3><?= $totalDelivery ?></h3>
                            <p>Delivered</p>
                        </div>
                        <div class="icon">
                            <i class="ion-android-done-all text-success"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box card_box">
                        <div class="inner" id="product_total">
                            <h3><?= $totalPending ?></h3>

                            <p>Pending</p>
                        </div>
                        <div class="icon">
                            <i class="ion-android-done text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Pending</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="p-2 card_box">
                <?php
                    if ($explodePendingOrder[0] > 0) {

                    ?>
                <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                    aria-describedby="example2_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Engine version: activate to sort column ascending">
                                Estimate Delivery</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="CSS grade: activate to sort column ascending">View Details</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Browser: activate to sort column ascending">Total Price
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Platform(s): activate to sort column ascending">
                                Size/Qty</th>

                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Rendering engine: activate to sort column descending">
                                Invoice</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="CSS grade: activate to sort column ascending">Status</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                    
                        foreach ($explodePendingOrder as $key => $value) {
                            $ress = SqlQuery("SELECT * FROM ordertrackingdetails WHERE delivery_boy_id = ".$DELIVERYData['delivery_boy_id']." && track_product_id = '$value' && track_id = '$PendingTrackId[$key]'");
                            $row = mysqli_fetch_assoc($ress);
                            $currentStatus = explode(",",$row['Current_Status']);
                            $filtered_status = array_filter($currentStatus);
                            if (!in_array("Delivered",$currentStatus)) {
                                $order_id = $row['track_Order_id'];
                                $trackId = $row['track_id'];
                                $payment_res = SqlQuery("SELECT * FROM payment_details WHERE Order_Id='$order_id'");
                                foreach($payment_res as $pay_key => $payment_row) {
                                    $tracking_id = explode(",",$payment_row['tracking_id']);
                                    $getProductId = explode(",",$payment_row['product_id']);
                                    $per_product_invoice = explode(",",$payment_row['per_product_invoice']);
                                    $product_varient = explode(",",$payment_row['product_varient']);
                                    $payment_prod_price = explode(",",$payment_row['payment_prod_price']);
                                    $estimate_delivery_date = explode(",",$payment_row['estimate_delivery_date']);
                                    $qty = explode(",",$payment_row['product_qty']);
                                    $getProductIndex = array_search($trackId,$tracking_id);
                                    // pr($getProductId[$pay_key]);
                                    $ProductDetails =  ProductDetails('where id='.$getProductId[$getProductIndex].'');
                                    $ProductDetails = $ProductDetails[0];
                                    
                                    if(isset($per_product_invoice[$getProductIndex]) == '') {
                                        // $invoice_msg =  "No Index<br>";
                                        
                                    }else{
                                        $invoice_msg =  "<a href=".PER_PRODUCT_INVOICE.$per_product_invoice[$getProductIndex]." target='_blank'>#".substr($per_product_invoice[$getProductIndex],0,-4)."</a>";
                                        ?>
                                        <tr>
                                            <td><?= date("d/m/Y h:i A",strtotime($estimate_delivery_date[$getProductIndex])) ?></td>
                                            <td> <a
                                                    href="<?= DELIVERY_FRONT_SITE.'DeliveryDetails?deliveryTrackId='.$row['id'].'&Invoice='.$per_product_invoice[$getProductIndex] ?>">View</a>
                                            </td>
                                            <td>₹ <?= number_format($payment_prod_price[$getProductIndex] * $qty[$getProductIndex]) ?>
                                            </td>
                                            <td><?= $product_varient[$getProductIndex] ?>/<?= $qty[$getProductIndex] ?></td>
                                            <td><?= $invoice_msg ?></td>
                                            <td><?= end($filtered_status) ?></td>
                                        </tr>
                                        <?php
                                    }

                                }
                                
                            }
                            
                        }    
                        ?>
                    </tbody>
                </table>
                <?php
                        
                    }else{
                        ?>
                        <div class="container-fluid">
                            <div class="card_box"
                                style="width:100%;height:200px;justify-content:center;display:flex;align-items:center">
                                <div class="inner">
                                    <h3>No Pending Order(s)</h3>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    
                    
                ?>
            </div>

            
        </div>

      
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Delivered</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content mb-5">
        <div class="container-fluid">
            <div class="p-2 card_box">
                <?php
                    if ($DelveredOrders[0] > 0) {

                    ?>
                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                    aria-describedby="example2_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Engine version: activate to sort column ascending">
                                Delivered Date</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="CSS grade: activate to sort column ascending">View Details</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Browser: activate to sort column ascending">Total Price
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Platform(s): activate to sort column ascending">
                                Size/Qty</th>

                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Rendering engine: activate to sort column descending">
                                Invoice</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="CSS grade: activate to sort column ascending">Status</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                    
                        foreach ($DelveredOrders as $key => $value) {
                            $ress = SqlQuery("SELECT * FROM ordertrackingdetails WHERE delivery_boy_id = ".$DELIVERYData['delivery_boy_id']." && track_product_id = '$value' && track_id = '$DeliveredTrackId[$key]'");
                            $row = mysqli_fetch_assoc($ress);
                            $currentStatus = explode(",",$row['Current_Status']);
                            $filtered_status = array_filter($currentStatus);

                            $Tracking_time = explode(",",$row['Tracking_time']);
                            if (in_array("Delivered",$currentStatus)) {
                                $order_id = $row['track_Order_id'];
                                $trackId = $row['track_id'];
                                $payment_res = SqlQuery("SELECT * FROM payment_details WHERE Order_Id='$order_id'");
                                foreach($payment_res as $pay_key => $payment_row) {
                                    $getProductId = explode(",",$payment_row['product_id']);
                                    $per_product_invoice = explode(",",$payment_row['per_product_invoice']);
                                    $product_varient = explode(",",$payment_row['product_varient']);
                                    $payment_prod_price = explode(",",$payment_row['payment_prod_price']);
                                    $estimate_delivery_date = explode(",",$payment_row['estimate_delivery_date']);
                                    $qty = explode(",",$payment_row['product_qty']);
                                    $getProductIndex = array_search($value,$getProductId);
                                    
                                    // pr($getProductId[$pay_key]);
                                    $ProductDetails =  ProductDetails('where id='.$getProductId[$getProductIndex].'');
                                    $ProductDetails = $ProductDetails[0];
                                    
                                    if(isset($per_product_invoice[$getProductIndex]) == '') {
                                        // $invoice_msg =  "No Index<br>";
                                        
                                    }else{
                                        $invoice_msg =  "<a href=".PER_PRODUCT_INVOICE.$per_product_invoice[$getProductIndex]." target='_blank'>#".substr($per_product_invoice[$getProductIndex],0,-4)."</a>";
                                        ?>
                        <tr>
                            <td><?= date("d/m/Y h:i A",strtotime(end($Tracking_time))) ?></td>
                            <td> <a
                                    href="<?= DELIVERY_FRONT_SITE.'DeliveryDetails?deliveryTrackId='.$row['id'].'&Invoice='.$per_product_invoice[$getProductIndex] ?>">View</a>
                            </td>
                            <td>₹ <?= number_format($payment_prod_price[$getProductIndex] * $qty[$getProductIndex]) ?>
                            </td>
                            <td><?= $product_varient[$getProductIndex] ?>/<?= $qty[$getProductIndex] ?></td>
                            <td><?= $invoice_msg ?></td>
                            <td><?= end($filtered_status) ?></td>
                        </tr>
                        <?php
                                    }

                                }
                                
                            }
                            
                        }    
                        ?>
                    </tbody>
                </table>
                <?php
                        
                    }else{
                        ?>
                        <div class="container-fluid">
                            <div class="card_box"
                                style="width:100%;height:200px;justify-content:center;display:flex;align-items:center">
                                <div class="inner">
                                    <h3>No Order Delivered</h3>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    
                    
                ?>
            </div>

            
        </div>

      
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    require 'includes/footer.php';
?>
    <script>
    $("#example1, #example2").DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        buttons: [{
                extend: 'print',
                exportOptions: {
                    stripHtml: false,
                    columns: [0, 2, 3, 4, 5]
                    //specify which column you want to print

                }
            }

        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>