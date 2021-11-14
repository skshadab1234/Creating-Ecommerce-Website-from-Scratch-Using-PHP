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
        $row = mysqli_fetch_assoc($res);

        ?>
<div class="content-wrapper" style="min-height: 2645.34px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Track Product</h1>
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
                <div class="col-md-12">
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
                                                    <div class="timeline-item" style="background-color: <?= $box_color ?>;border:none">
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

                                <table id="example1"
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
                                                colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                User Details</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                Payment</th>
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
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        stripHtml: false,
                        columns: [0, 1, 2, 3, 4]
                        //specify which column you want to print

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


    });

    $("#PrintInvoice").click(() => {
        var printContents = document.getElementById("InvoiceDataToPrint").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });
    </script>