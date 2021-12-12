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
            $filtered_status = array_filter($currentStatusTrack);
            $CurrentStatus = end($filtered_status);
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
                    $product_message_explode = explode(",PSFASHIONSTORE,",$payment_details_row['product_message']);
                    $product_messages = $product_message_explode[$estimate_dd_index];
                    $product_message = ' <div id="mesage_display_order_0">
                            <div class="card_box mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Message for Order
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-success">'.$product_messages.'</p>
                                </div>

                            </div>
                        </div>';
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
                    <table id="example2" class="table table-striped">
                        <thead>
                            <th>Product Details</th>
                            <th>Deliver Address</th>
                            <th>Deliver By</th>
                        </thead>
                        <tbody>
                            <td>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <strong><a><?= $ProductDetails['product_name'] ?>
                                                </a></strong><br>
                                            Size: <?= $product_size_array[$estimate_dd_index] ?><br>
                                            Qty : <?= $product_qty[$estimate_dd_index].' x '.$payment_prod_price[$estimate_dd_index] ?><br>
                                            Total Price : <strong>₹
                                                    <?= number_format($payment_prod_price[$estimate_dd_index]) ?></strong><br>
                                            Current Status : <span style="color:green"><?= $CurrentStatus ?></span>

                                            <?=  $product_message ?>
                                           
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <address>
                                    <?= $payment_details_row['delivery_address_id'] ?>
                                </address>
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
                                            <table class="table table-bordered table-striped dataTable dtr-inline text-center">
                                                <thead>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                </thead>
                                                <tbody>
                                                    <td><img src="<?= $delivery_image ?>" style="border-radius:50%;width:50px;height:50px" alt=""></td>
                                                    <td><?= $delivery_row['delivery_boy_name'] ?></td>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                    }
                                ?>
                            </td>
                        </tbody>
                    </table>
                </div>
               <?= OrderTrackStatus($currentTrack) ?>
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

                                <table id="example1"
                                    class="table table-bordered table-striped dataTable dtr-inline text-center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>Order Id</th>
                                            <th>Tracking Id</th>
                                            <th>Assign Delivery</th>
                                            <th>Invoice Status</th>
                                            <th>Payment</th>
                                            <th>Pincode</th>    
                                            <th>Status</th>
                                            <th>User Details</th>
                                            <th>Order Placed at</th>
                                            <th>Estimate Delivery</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                     $payment_details_res = SqlQuery("Select * from payment_details");

                                                     foreach ($payment_details_res as $key => $value) {
                                                         $tarcking_id  = explode(",",$value['tracking_id']);
                                                         $product_ids_array  = explode(",",$value['product_id']);
                                                         $estimate_delivery_date_array  = explode(",",$value['estimate_delivery_date']);
                                                         $product_qty_array  = explode(",",$value['product_qty']);
                                                         $product_varient_array  = explode(",",$value['product_varient']);
                                                         $payment_prod_price_array  = explode(",",$value['payment_prod_price']);
                                                         $per_product_invoice_array  = explode(",",$value['per_product_invoice']);
                                                         $userDetailsId = $value['payment_user_id'];
                                                         $userDetails = UsersDetails("WHERE id = '$userDetailsId'");
                                                         $userDetails = $userDetails[0];
                                                         foreach ($tarcking_id as $tarcking_id_key => $tarcking_id_val) {
                                                             $resTrack_Id = SqlQuery("SELECT * FROM ordertrackingdetails WHERE track_id='$tarcking_id_val'");
                                                             $rowTrack = mysqli_fetch_assoc($resTrack_Id);
                                                             $currentStatusTrack = explode(",",$rowTrack['Current_Status']);
                                                             $filtered_status = array_filter($currentStatusTrack);
                                                             $CurrentStatus = end($filtered_status);

                                                             
                                                            if ($per_product_invoice_array[$tarcking_id_key] != '') {
                                                                 $invoice_message =  "<a href=".PER_PRODUCT_INVOICE.$per_product_invoice_array[$tarcking_id_key]." target='_blank'>#".substr($per_product_invoice_array[$tarcking_id_key],0,-4)."</a>";
                                                             }else{
                                                                 $order_id = $value['Order_Id'];

                                                                 $invoice_message = "<a href='javascript:void(0)' 
                                                                 id='DownloadInvoiceAtag_".$value['Order_Id'].$product_ids_array[$tarcking_id_key].$product_varient_array[$tarcking_id_key]."'
                                                                 onclick=\"DownloadInvoice('".$value['Order_Id']."', '".$product_ids_array[$tarcking_id_key]."', '".$product_qty_array[$tarcking_id_key]."', '".$product_varient_array[$tarcking_id_key]."', '".$payment_prod_price_array[$tarcking_id_key]."', '".$per_product_invoice_array[$tarcking_id_key]."','".$url."')\">Download</a>";
                                                             }
                                                             ?>
                                                            <tr>
                                                                <td><a target="_blank"
                                                                        href="<?= ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'] ?>"><?= $value['Order_Id'] ?></a>
                                                                </td>
                                                                <td><a target="_blank"
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
                                                                            if ($CurrentStatus == 'Delivered') {
                                                                                //  agar Ye product Delivered hogaya hai tho action button and link ko hata dena hai 
                                                                                 $showLink = '';
                                                                             }else{
                                                                                //  show btn and link 
                                                                                $showLink = "<a href=\"javascript:void(0)\" onclick=\"RemoveAssignedDeliveryBoy(".$rowTrack['id'].")\">Remove</a>";
                                                                             }

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
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <td><img src="<?= $delivery_image ?>" style="border-radius:50%;width:50px;height:50px" alt=""></td>
                                                                                            <td><?= $delivery_row['delivery_boy_name'].'<br>'.$delivery_row['delivery_boy_email'].'<br>'.$showLink ?></td>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td id="addInvoiceMessagefromRespone_<?= $value['Order_Id'].$product_ids_array[$tarcking_id_key].$product_varient_array[$tarcking_id_key] ?>"><?= $invoice_message ?></td>
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
                                                                    <?= date("d/m/Y h:i A", strtotime($value["created"])) ?>
                                                                </td>
                                                                <td>
                                                                    <?= date("D M d, Y", strtotime($estimate_delivery_date_array[$tarcking_id_key])) ?>
                                                                </td>
                                                                
                                                            
                                                            </tr>
                                                            <?php
                                                         }
                                                     }
                                                ?>

                                    </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Track Id</th>
                                                <th>Assign Delivery Boy</th>
                                                <th>Invoice</th>
                                                <th>Payment Status</th>
                                                <th>Pincode</th>
                                                <th>DELIVERY Status</th>
                                                <th>USer Details</th>
                                                <th>Order Placed Date</th>
                                                <th>Estimate Delivery Date</th>
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
            "order": [[ 8, "desc" ]],
            "responsive": true,
            "autoWidth": false, 
            "lengthMenu": [[2,5, 10, 25, 50, -1], [2,5, 10, 25, 50, "All"]],
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        stripHtml: false,
                        columns: [0,1, 2, 3,4,5,6,7,8,9]
                        //specify which column you want to print

                    }
                }

            ],
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
          
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#example2").DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching":false,
            "paging": false,
            "info": false,
            "order": false,
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