<?php
    require 'includes/header.php';
?>
<style>
.dark-mode .callout.callout-info,
.dark-mode .callout,
.dark-mode .invoice {
    background-color: #283046;
}
</style>
<?php
    if (isset($_GET['track_id']) && $_GET['track_id'] != '' && isset($_GET['Order_id']) && $_GET['Order_id'] != '') {
        $orderDetails = get_safe_value($_GET['Order_id']);
        $currentTrack = get_safe_value($_GET['track_id']);
        $Sql = "SELECT * FROM ordertrackingdetails WHERE track_id = '$currentTrack'";
        $res = mysqli_query($con, $Sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $currentStatusTrack = explode(",",$row['Current_Status']);
            $CurrentStatus = end($currentStatusTrack);
            $payment_details_res = SqlQuery("SELECT * FROM payment_details WHERE Order_Id = '$orderDetails'");
            if (mysqli_num_rows($payment_details_res) > 0) {
                $payment_details_row = mysqli_fetch_assoc($payment_details_res);
                $estimate_dd_array = explode(",",$payment_details_row['estimate_delivery_date']);
                // With help of track id we will get Estimate Date 
                $estimate_dd_index = array_search($currentTrack, explode(",",$payment_details_row['tracking_id']));
                $product_ids = explode(",",$payment_details_row['product_id']);
                $ProductDetails = ProductDetails("WHERE id = '$product_ids[$estimate_dd_index]'"); // with index we get that product detail
                $ProductDetails = $ProductDetails[0];
                $ProductImageById = ProductImageById($ProductDetails['id'],"limit 1");
                array_unshift($ProductImageById,"");
                unset($ProductImageById[0]);

                $product_size_array = explode(",",$payment_details_row['product_varient']);
                $product_qty = explode(",",$payment_details_row['product_qty']);
                $payment_prod_price = explode(",",$payment_details_row['payment_prod_price']);
                
                if ($payment_details_row['product_message'] != '') {
                    $product_message = explode(",PSFASHIONSTORE,",$payment_details_row['product_message']);
                    $product_message = $product_message[$estimate_dd_index];
                }else{
                    $product_message = '';
                }


                // Delivery By Boy Details
                $deliveryBoy_Ids = explode(",",$row['delivery_boy_id']);
                // now we have loop it in foreach loop 
                
            }else {
                redirect(ADMIN_FRONT_SITE);
            }
        }else{
            redirect(ADMIN_FRONT_SITE);
        }
        ?>
<div class="content-wrapper" style="min-height: 2645.34px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Track Product <br><strong>Estimate Delivery:-
                        </strong><?= date("D M d, Y", strtotime($estimate_dd_array[$estimate_dd_index]))  ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_FRONT_SITE ?>">Home</a></li>
                        <li class="breadcrumb-item active">Track id <?= $currentTrack ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="card_box col-md-12 mb-2 p-2">
                    <table id="example1" class="table table-striped">
                        <thead>
                            <th>Product Details</th>
                            <th>Delicver By</th>
                        </thead>
                        <tbody>
                            <td>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <img src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                                width="100px" alt="">
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <strong><a><?= $ProductDetails['product_name'] ?>
                                                </a></strong><br>
                                            Size: <?= $product_size_array[$estimate_dd_index] ?><br>
                                            Qty : <?= $product_qty[$estimate_dd_index].' x '.$payment_prod_price[$estimate_dd_index] ?><br>
                                            Total Price : <strong>₹
                                                    <?= number_format($payment_prod_price[$estimate_dd_index]) ?></strong><br>
                                            Current Status : <span style="color:green"><?= $CurrentStatus ?></span>

                                            <div id="mesage_display_order_0">
                                                <div class="card_box mt-3">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            Message for Order
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-success"><?= $product_message ?></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php
                                    foreach ($deliveryBoy_Ids as $key => $value) {
                                        $delivery_res = SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_id= '$value'");
                                        while ($delivery_row = mysqli_fetch_assoc($delivery_res)) {
                                            if ($delivery_row['delivery_boy_profile'] != '') {
                                                $delivery_image = DELIVERY_PROFILE.$delivery_row['delivery_boy_profile'];
                                            }else{
                                                $delivery_image = 'https://png.pngitem.com/pimgs/s/35-350426_profile-icon-png-default-profile-picture-png-transparent.png';
                                            }
                                            ?>
                                            <div class="container">
                                                <div class="row mb-2">
                                                    <div class="col-4 col-md-2 text-right">
                                                        <img src="<?= $delivery_image ?>" style="border-radius:50%;width:50px;height:50px" alt="">
                                                    </div>
                                                    <div class="col-8 col-md-10">
                                                        <strong><a><?= $delivery_row['delivery_boy_name'] ?>
                                                            </a></strong><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </td>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 card_box">
                    <div class="card-header">
                        <h4>Shipping Details</h4>
                    </div>
                    <!-- Modal is in Footer File  -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="timeline">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <?php
                                        $TrackName = explode(',', $row['Tracking_Name']);
                                        foreach ($res as $track_key => $track_value) {
                                            foreach ($TrackName as $key => $value) {
                                                $box_color = '#283046!important';
                                                $icon_color = '#283046';
                                                $icon = 'fas fa-dot-circle';
    
                                                $ordered_message = array();
                                                $current_status = explode(",",$row['Current_Status']);
                                                if (in_array("Canceled",$current_status)) {
                                                    if (isset($current_status[$key+1]) == 'Canceled') {
                                                            $box_color = '#283046!important';
                                                        }else{
                                                            $box_color = '#e74c3c!important';
                                                            $value = 'Canceled '.$value;
                                                            $icon_color = '#e74c3c';
                                                            $icon = 'fas fa-times';
                                                        }
                                                }
                                                
                                                if (in_array($value,$current_status)) {
                                                    $icon_color = 'green';
                                                    $icon = 'fas fa-check-circle';
                                                }
    
                                                if (in_array("Delivered",$current_status)) {
                                                    if (isset($current_status[$key+1]) != 'Delivered') {
                                                        $box_color = 'green!important';
                                                        $icon_color = 'green';
                                                        $icon = 'fas fa-check-circle';
                                                    }
                                                }
                                                
                                                $TrackingTime = explode(",",$row['Tracking_time']);
                                                if(!empty($TrackingTime[$key])) {
                                                    $time_text = '<span class="time"><i class="far fa-clock"></i> '.date("h:i A", strtotime($TrackingTime[$key])).'</span>';
                                                    $TEXT_Time = '<!-- timeline time label -->
                                                    <div class="time-label">
                                                        <span style="background:#283046">
                                                        '.date("d M, Y", strtotime($TrackingTime[$key])).'
                                                        </span>
                                                    </div>';
                                                }else{
                                                    $TEXT_Time = '';
                                                    $time_text = '';
                                                }
                                                
                                                if (isset(array($row['Tracking_Details'])[$track_key])) {
                                                    $ordered_message = explode(",PS_FASHION_STORE,", array($row['Tracking_Details'])[$track_key]);
                                                }
                                                ?>
                                    <?= $TEXT_Time ?>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="<?= $icon ?>" style="background:<?= $icon_color ?>"></i>
                                        <div class="timeline-item"
                                            style="background-color: <?= $box_color ?>;border:none">
                                            <?=  $time_text ?>

                                            <h3 class="timeline-header"><?= $value ?></h3>

                                            <div class="timeline-body mt-3" style="line-height:1px">
                                                <?php
                                                                if (isset($ordered_message[$key]) ) {
                                                                    echo $ordered_message[$key];
                                                                } 
                                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                   ?>

                                </div>
                                <?php
                                    if($row['Canceled_By'] == 'user'){
                                        ?>
                                <div class="callout callout-danger mt-5">
                                    User Canceled the Order
                                </div>
                                <?php
                                    }

                                    else  if($row['Canceled_By'] == 'admin'){
                                        ?>
                                <div class="callout callout-danger mt-5">
                                    Your Order has been canceled by <?= SITE_NAME ?>
                                </div>
                                <?php
                                    }else{

                                    }
                                ?>

                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php
    }else{
        ?>
<div class="content-wrapper mb-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Track User Order</h1>
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

                                <table id="example2"
                                    class="table table-bordered table-striped dataTable dtr-inline text-center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Order Id</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Tracking Id</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                Assign Delivery</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                Order Placed at</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                Estimate Delivery</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                User Details</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                Payment</th>
                                            <th class="sorting" tabindex="0" aria-  controls="example1" rowspan="1"
                                                colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                Pincode</th>    
                                            
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                     $payment_details_res = SqlQuery("Select * from payment_details");

                                                     foreach ($payment_details_res as $key => $value) {
                                                         $tarcking_id  = explode(",",$value['tracking_id']);
                                                         $estimate_delivery_date_array  = explode(",",$value['estimate_delivery_date']);
                                                         $userDetailsId = $value['payment_user_id'];
                                                         $userDetails = UsersDetails("WHERE id = '$userDetailsId'");
                                                         $userDetails = $userDetails[0];
                                                         foreach ($tarcking_id as $tarcking_id_key => $tarcking_id_val) {
                                                             $resTrack_Id = SqlQuery("SELECT * FROM ordertrackingdetails WHERE track_id='$tarcking_id_val'");
                                                             $rowTrack = mysqli_fetch_assoc($resTrack_Id);
                                                             $currentStatusTrack = explode(",",$rowTrack['Current_Status']);
                                                             $CurrentStatus = end($currentStatusTrack);
                                                             ?>
                                        <tr>
                                            <td><a
                                                    href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'] ?>"><?= $value['Order_Id'] ?></a>
                                            </td>
                                            <td><a
                                                    href="<?= ADMIN_FRONT_SITE.'TrackOrders?track_id='.$tarcking_id_val.'&Order_id='.$value['Order_Id'] ?>"><?= $tarcking_id_val ?></a>
                                            </td>
                                            <td id="dumpAssignedDeliveryData_<?= $rowTrack['id'] ?>">
                                                <?php
                                                    if ($rowTrack['delivery_boy_id'] == '') {
                                                        ?>
                                                        <button type="button" class="btn btn-default" onclick="getDeliveryBoyForAssigning(<?= $rowTrack['id'] ?>)" data-toggle="modal" data-target="#getDeliveryBoyForAssigning_<?= $rowTrack['id']  ?>">
                                                            Assign Delivery to
                                                        </button>
                                                        <div class="modal fade" id="getDeliveryBoyForAssigning_<?= $rowTrack['id'] ?>"  aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content ">
                                                                    <div class="modal-header card_box">
                                                                        <h4 class="modal-title">Assigning this item to </h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                        <div class="modal-body text-left card_box" id="hideDiv_NoDeliveryBoy_<?= $rowTrack['id'] ?>"> 
                                                                            <div class="form-group col-md-12">
                                                                                <select name="delivery_id" id="listofdeliveryBoy_<?= $rowTrack['id'] ?>"
                                                                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                                                                    required>
                                                                                    
                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer card_box justify-content-between">
                                                                            <button type="button" data-dismiss="modal" onclick="SubmitAssignedDelivery(<?= $rowTrack['id'] ?>)" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                   
                                                                </div>
                                                                <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                        <?php
                                                    }else{
                                                        $deliveryBoy_Ids = explode(",",$rowTrack['delivery_boy_id']);
                                                        foreach ($deliveryBoy_Ids as $keys => $values) {
                                                            $delivery_res = SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_id= '$values'");
                                                            while ($delivery_row = mysqli_fetch_assoc($delivery_res)) {
                                                                if ($delivery_row['delivery_boy_profile'] != '') {
                                                                    $delivery_image = DELIVERY_PROFILE.$delivery_row['delivery_boy_profile'];
                                                                }else{
                                                                    $delivery_image = 'https://png.pngitem.com/pimgs/s/35-350426_profile-icon-png-default-profile-picture-png-transparent.png';
                                                                }
                                                                ?>
                                                                <table class="table table-bordered table-striped dataTable dtr-inline">
                                                                    <thead>
                                                                        <th>Image</th>
                                                                        <th>Name</th>
                                                                        <th>Action</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <td><img src="<?= $delivery_image ?>" style="border-radius:50%;width:50px;height:50px" alt=""></td>
                                                                        <td><?= $delivery_row['delivery_boy_name'] ?></td>
                                                                        <td><a href="javascript:void(0)" onclick="RemoveAssignedDeliveryBoy(<?= $rowTrack['id'] ?>)">Remove</a></td>
                                                                    </tbody>
                                                                </table>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?= date("D M d, Y h:i A", strtotime($value["created"])) ?>
                                            </td>
                                            <td>
                                                <?= date("D M d, Y", strtotime($estimate_delivery_date_array[$tarcking_id_key])) ?>
                                            </td>
                                            <td>
                                                <table class="table table-bordered table-striped dataTable dtr-inline">
                                                    <thead>
                                                        <th>Profile</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                    </thead>
                                                    <tbody>
                                                        <td>
                                                            <img class="img-reponsive img-fluid" width="40px"
                                                                height="40px"
                                                                style="border-radius:50%;width:40px;height:40px"
                                                                src="<?= USER_PROFILE.$userDetails['user_img'] ?>"
                                                                alt="">
                                                        </td>
                                                        <td><?= $userDetails['firstname'].' '.$userDetails['lastname'] ?>
                                                        </td>
                                                        <td><?= $userDetails['email'] ?></td>
                                                    </tbody>
                                                </table>
                                            </td>
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
                                                <span class=" label label-pill bright"
                                                    style="background-color:<?= $color ?> ; padding: 5px 10px">
                                                    <?= $text ?>
                                                </span>
                                            </td>
                                            <td><?= $rowTrack['delivery_to_pincode'] ?></td>
                                          
                                            <td><?= $CurrentStatus ?> </td>
                                        </tr>
                                        <?php
                                                         }
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
            "searching": false,
            "paging": false,
            "info": false,
            "order": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#example2").DataTable({
            "responsive": true,
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#PrintInvoice").click(() => {
        var printContents = document.getElementById("InvoiceDataToPrint").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
    </script>