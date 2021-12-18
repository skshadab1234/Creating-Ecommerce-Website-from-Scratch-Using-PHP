<?php
    
    require 'includes/header.php';

    if (isset($_GET['deliveryTrackId']) && $_GET['deliveryTrackId'] > 0 && isset($_GET['Invoice']) && $_GET['Invoice'] != '') {
        $delivery_id = get_safe_value($_GET['deliveryTrackId']);
        $invoice_file = get_safe_value($_GET['Invoice']);
        $orderTrackDetails = ExecutedQuery("SELECT * FROM ordertrackingdetails where id = '$delivery_id'");
        $orderTrackDetails = $orderTrackDetails[0];
        $track_id = $orderTrackDetails['track_id'];
        $delivery_product_id = $orderTrackDetails['track_product_id'];
        $track_Order_id = $orderTrackDetails['track_Order_id'];
        $Current_Status_01 = explode(",",$orderTrackDetails['Current_Status']);

        if (in_array("Delivered",$Current_Status_01)) {
            $delivery_icon = 'alert-success';
            $delivery_message = 'D';
        }else{
            $delivery_icon = 'alert-danger';
            $delivery_message = 'P';
        }

        // Preventing Url that anybody change then redirect it to the Dashboard 
        if ($delivery_id != $orderTrackDetails['id']) {
            redirect(DELIVERY_FRONT_SITE);
        }


        // Trying to get estimate delivery date 
        $payment_row = ExecutedQuery("SELECT * FROM payment_details where Order_Id = '$track_Order_id'");
        $payment_row = $payment_row[0];
        
        $payment_row_tid = explode(",",$payment_row['tracking_id']);
        $getIndex = array_search($track_id,$payment_row_tid);

        // Now with the help of this index we will get estimate date,size,quantity,price
        $estimate_delivery_date_explode = explode(",",$payment_row['estimate_delivery_date']);
        $estimate_delivery_date = $estimate_delivery_date_explode[$getIndex];
        $size_explode = explode(",",$payment_row['product_varient']);
        $qty_explode =  explode(",",$payment_row['product_qty']);
        $price_explode = explode(",",$payment_row['payment_prod_price']);
        $per_product_invoice_explode = explode(",",$payment_row['per_product_invoice']);

        if ($per_product_invoice_explode[$getIndex] != $invoice_file) {
            redirect(DELIVERY_FRONT_SITE);
        }
        // Getting Product Detail
        $ProductDetatils = ProductDetails("WHERE id = '$delivery_product_id'");
        $ProductDetatils = $ProductDetatils[0];
        // Product Image 
        $ProductImageById = ProductImageById($ProductDetatils['id'], 'limit 1');
        
        $delivery_address_explode = explode("<br>",$payment_row['delivery_address_id']);


        // Payment Status 
        $payment_status = $payment_row['payment_status'];
        if ($payment_status == 'succeeded') {
            $status_pay = 'Paid';
        }else{
            $status_pay = 'Not Paid';
        }
    }else{
        redirect(DELIVERY_FRONT_SITE);
    }
    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mb-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="callout callout-primary" style="background:#283046!important;border-left:0">
                <h3> <a class="text-white" target="_blank"
                        href="<?= PER_PRODUCT_INVOICE.$invoice_file ?>">#<?= substr($invoice_file,0,-4) ?></a> <span
                        class="alert <?= $delivery_icon ?>"
                        style="width: 30px;height: 30px;display: inline-flex;justify-content: center;align-items: center;margin-left: 13px;font-size: 19px;"><?= $delivery_message ?></span>
                </h3>
                <h5 class="mb-5">Delivery Date : <?= date("D M d, Y H:i:s", strtotime($estimate_delivery_date)) ?></h5>
                <table id="example1" class=" table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <th width="10%">Product Image</th>
                        <th>Product Details</th>
                    </thead>
                    <tbody>
                        <td>
                            <img style="width:auto;height:200px"
                                src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[0]['product_img'] ?>"
                                alt="<?= $ProductDetatils['product_name'] ?>">
                        </td>
                        <td>
                            <h5 style="font-weight:600"><?= $ProductDetatils['product_name'] ?></h5>
                            <h5 style="line-height:30px">
                                Size : <?= $size_explode[$getIndex] ?> <br>
                                Qty : <?= $qty_explode[$getIndex] ?> <br>
                                <strong>Total Price : ₹
                                    <?= number_format($price_explode[$getIndex] * $qty_explode[$getIndex]) ?></strong>
                            </h5>
                        </td>
                    </tbody>
                </table>

            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card_box">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Customer
                                        Detail</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Store
                                        Information</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Name</span>
                                                    <span
                                                        class="info-box-number"><?= $delivery_address_explode[0] ?></span>
                                                </div>
                                                <span class="info-box-icon "><i class="far fa-user-circle"></i></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-info">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Company Name</span>
                                                    <span
                                                        class="info-box-number"><?= $delivery_address_explode[1] ?></span>
                                                </div>
                                                <span class="info-box-icon "><i class="fas fa-building"></i></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-secondary">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Mobile Number</span>
                                                    <span
                                                        class="info-box-number"><?= $delivery_address_explode[5] ?></span>
                                                </div>
                                                <span class="info-box-icon "><a
                                                        href="tel:<?= $delivery_address_explode[5] ?>"
                                                        class="text-white"><i class="fas fa-phone"></i></a></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Payment Status</span>
                                                    <span class="info-box-number"><?= $status_pay ?></span>
                                                </div>
                                                <span class="info-box-icon "><i class="fas fa-rupee-sign"></i></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-info">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Address</span>
                                                    <span
                                                        class="info-box-number"><?= $delivery_address_explode[2].",".$delivery_address_explode[3].', '.$delivery_address_explode[4] ?></span>
                                                </div>
                                                <span class="info-box-icon "><a
                                                        href="https://maps.google.com/maps?q=<?= urlencode(trim($delivery_address_explode[2])) ?>"
                                                        class="text-white" target="_blank "><i
                                                            class="fas fa-map-marker-alt"></i></a></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>

                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Owner Name</span>
                                                    <span class="info-box-number">Steve Jobs</span>
                                                </div>
                                                <span class="info-box-icon "><i class="far fa-user-circle"></i></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Store Name</span>
                                                    <span class="info-box-number">Pankaj Fashion Store</span>
                                                </div>
                                                <span class="info-box-icon "><i class="far fa-building"></i></span>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- ./card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>

            <div id="Track_Status" >

            </div>

            <?php
                $TrackingName_row = ExecutedQuery("SELECT * FROM ordertrackingdetails where track_id = '$track_id'");
                $Tracking_Name = explode(",",$TrackingName_row[0]['Tracking_Name']);
                $Current_Status = explode(",",$TrackingName_row[0]['Current_Status']);
                $filtered_status = array_filter($Current_Status);
                $endStatus = end($filtered_status);

                if ($endStatus != 'Delivered') {
                    ?>
                    <div class="card_box mt-3" id="changeDelivery_Div_Form">
                        <form action="" method="post" id="ChangeDeliveryStatus">
                            <input type="hidden" name='track_id' value="<?= $track_id ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="product_publish_as_data">SELECT STATUS</label>
                                        <select  name="current_statuss" class="form-control select2 select2-hidden-accessible" style="width: 100%;" required>
                                            <option value="" selected disabled>SELECT STATUS</option>
                                            <?php
                                                
                                                foreach ($Tracking_Name as $key => $value) {
                                                    if (in_array($value,$Current_Status)) {
                                                        if ($endStatus == $value) {
                                                            $disabled= '';
                                                        }else{
                                                            $disabled = 'disabled';
                                                        }
                                                        $selected = 'selected="selected"';
                                                        
                                                    }else{
                                                        $selected = '';
                                                    }
                                                    ?>
                                                        <option value="<?= $value ?>" id="<?= $value.'_'.$track_id ?>" <?= $selected.' '.$disabled ?>><?=  $value ?></option>            
                                                    <?php
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="track_meesage">Message</label>
                                        <textarea class="form-control" name="track_meesage" required></textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="location">Location</label>
                                        <input class="form-control" name="location" placeholder="Enter Location">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="submit_delivery_status" type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </form>
                    </div>   
                    <?php
                }
            ?>
            
        </div>

        <input type="hidden" id="track_id_status" value="<?=  $track_id ?>">
        <?php
    require 'includes/footer.php';

    ?>


        <script>
            
            $(document).ready(()=> {
                var track_id = $("#track_id_status").val();
                getCurrentTrackStatus(track_id)
            })
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });


        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        </script>