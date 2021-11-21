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
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <input type="date" class='form-control' value='<?= $date ?>' id="Date_Dashboard">
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
                            <!-- <h3<span style="font-size: 14px; font-weight:100" class=""><i class=""></i></span> </h3>
                            <p>Today Orders</p> -->
                        </div>
                        <div class="icon">
                            <i class="ion-arrow-graph-up-right text-success"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box card_box">
                        <div class="inner" id="product_total">
                            <!-- <h3></h3>

                            <p>Products</p> -->
                        </div>
                        <div class="icon">
                            <i class="ion-ios-cart-outline text-info"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box card_box">
                        <div class="inner" id="users_html">
                            <!-- <h3>44</h3>

                            <p>Customers</p> -->
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add text-primary"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box card_box">
                        <div class="inner" id="revenue_html">
                            <!-- <h3>65</h3>

                            <p>Revenue</p> -->
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash text-success"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-md-6 ">
                    <!-- Bar chart -->
                    <div class="card_box">
                        <div class="card-header">
                            <h3 class="card-title datatable_order_date" >Today Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example1_wrapper">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="total_order_table"
                                            class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                                            aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="example1" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Rendering engine: activate to sort column descending">
                                                        Order Id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">Total Price
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Payment</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending">
                                                        Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">Invoice</th>
                                                </tr>
                                            </thead>
                                            <tbody id="today_order_date">
                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>


        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
    require 'includes/footer.php';
?>

<script>
    // $("#example1").DataTable({
    //     buttons: [{
    //         extend: 'print',
    //         exportOptions: {
    //             stripHtml: false,
    //             columns: [0, 1, 2,3]
    //             //specify which column you want to print

    //         }
    //     }

    // ]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //     "responsive": true,
    // });
</script>