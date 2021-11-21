<?php
    
    require 'includes/header.php';

    
    // $DeliveredOrder = explode(",",);
    // $totalDelivery = count($DeliveredOrder);

    $DelveredOrder = GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['Delivered'];
    $PendingOrder = GetAssignedDeliveryForDeliveryBoy($DELIVERYData['delivery_boy_id'])['Pending'];
    if ($DelveredOrder != '')  {
        $DelveredOrder = explode(",",$DelveredOrder);
        $totalDelivery = count($DelveredOrder);
    }else{
        $totalDelivery = 0;
    }

    if ($PendingOrder != '')  {
        $PendingOrder = explode(",",$PendingOrder);
        $totalPending = count($PendingOrder);
    }else{
        $totalPending = 0;
    }
    
    
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
            <div class="row">
                <div class="card_box">
                    <div class="row">
                        
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
    require 'includes/footer.php';
?>