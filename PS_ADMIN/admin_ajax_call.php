<?php
require 'includes/session.php';

if (isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
    $admin_email = get_safe_value($_POST['admin_email']);
    $admin_password = get_safe_value($_POST['admin_password']);

    $query = "SELECT * FROM admins WHERE admin_email = '$admin_email'";
    $results = mysqli_query($con, $query);
    if (mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            if (password_verify($admin_password, $row["admin_password"]))
            {
                if ($row['admin_verified'] == 0) {
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Please Verify Your Account.',
                        'field' => 'error'
                    );
                }else {
                    $_SESSION["ADMIN_ID"] = $row['id'];

                    $arr = array(
                        'status' => 'success',
                        'msg' => 'Wait a minute....redirecting',
                    );

                }
                
            }
            else
            {
                
                //return false;
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Password is incorrect',
                        'field' => 'error'
                    );
                
            }
        }
    }else{
        $arr = array(
            'status' => 'error',
            'msg' => 'Email Id Not Found',
            'field' => 'error'
        );
    }

echo json_encode($arr);
}

elseif (isset($_POST['SelectedDate'])) {
    $SelectedDate = get_safe_value($_POST['SelectedDate']);
    $convert_selectedDate = date("Y-m-d", strtotime($SelectedDate));
        
    // Working for Orders Section 
        // Required Function Data 
        $todayOrderTotal = COUNT(OrderSql("WHERE added_on = '$convert_selectedDate' && payment_status='succeeded'"));

        // Getting Total Product Sale Yesterday and Getting how much product sale today compare to yesterday 
        $yesterDate= date('Y-m-d',strtotime("-1 days", strtotime($convert_selectedDate)));

        $YesterdayTotalOrder = COUNT(OrderSql("WHERE added_on = '$yesterDate' && payment_status='succeeded'"));

        if ($YesterdayTotalOrder == 0) {
            $SaleMoreOrdersTotal = 0;    
            $SaleMoreOrdersTotal_Color = 'text-danger';
            $SaleMoreOrdersTotal_Arrow = 'ion-arrow-down-c';
        }
        else if ($todayOrderTotal > $YesterdayTotalOrder) {
            $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
            $SaleMoreOrdersTotal_Color = 'text-success';
            $SaleMoreOrdersTotal_Arrow = 'ion-arrow-up-c';
        }else{
            $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
            $SaleMoreOrdersTotal_Color = 'text-danger';
            $SaleMoreOrdersTotal_Arrow = 'ion-arrow-down-c';
        }

        if ($convert_selectedDate == date('Y-m-d')) {
            $output_date = 'Today';
        }else{
            $output_date = date("d M, Y", strtotime($SelectedDate));
        }
        $orders_html = '<h3>'.numtostring($todayOrderTotal).'<span style="font-size: 14px; font-weight:100" class="'.$SaleMoreOrdersTotal_Color.'"> '.numtostring($SaleMoreOrdersTotal).'<i class="'.$SaleMoreOrdersTotal_Arrow.'"></i></span> </h3>
        <p>'.$output_date.' Orders</p>';

    // End of Order Section 

    // Start of Product Section 
        $TodayProducts = COUNT(ProductDetails("WHERE product_added_on='$convert_selectedDate'"));
        $TotalProducts = COUNT(ProductDetails("WHERE product_status='1'"));

        $product_html = '<h3>'.numtostring($TodayProducts).'</h3>
                        <p>Total Products <span class="text-success">'.numtostring($TotalProducts).'</span></p>';


    // End of Product Section     
    
    // Start of Customer Details Section 
        $UsersTotalTodayAdded = COUNT(UsersDetails("WHERE userAdded_On='$convert_selectedDate'"));
        $VerifiedUsersTotal = COUNT(UsersDetails("WHERE verify='1'"));
        $users_html = '<h3>'.numtostring($UsersTotalTodayAdded).'</h3>
                       <p>Total Users <span class="text-success">'.numtostring($VerifiedUsersTotal).'</span></p>';

    // End of Customer Section 

    // Start of Revenue Section 
        $TodayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as today_earned FROM payment_details WHERE added_on = '$convert_selectedDate'"));
        $YesterDayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as yester_earned FROM payment_details WHERE added_on = '$yesterDate'"));
        $Total_Revenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as total_earned FROM payment_details"));

        if ($YesterDayRevenue['yester_earned'] == 0) {
            $YesterDayRevenueTotal = 0;    
            $YesterDayRevenueTotal_Color = 'text-danger';
            $YesterDayRevenueTotal_Arrow = 'ion-arrow-down-c';
        }
        else if ($TodayRevenue['today_earned'] > $YesterDayRevenue['yester_earned']) {
            $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
            $YesterDayRevenueTotal_Color = 'text-success';
            $YesterDayRevenueTotal_Arrow = 'ion-arrow-up-c';
        }else{
            $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
            $YesterDayRevenueTotal_Color = 'text-danger';
            $YesterDayRevenueTotal_Arrow = 'ion-arrow-down-c';
        }

        $revenue_html = '<h3>'.numtostring((int)$TodayRevenue['today_earned']).'
                            <span style="font-size: 14px; font-weight:100" class="'.$YesterDayRevenueTotal_Color.'"> 
                                '.numtostring($YesterDayRevenueTotal).'
                                <i class="'.$YesterDayRevenueTotal_Arrow.'"></i>
                            </span> 
                        </h3>
                        <p>Revenue <span class="text-success">'.numtostring((int)$Total_Revenue['total_earned']).'</span></p>';
    $arr = array(
            'order_html' => $orders_html, 
            'product_html' => $product_html,
            'users_html' => $users_html,
            'revenue_html' => $revenue_html
        );
        echo json_encode($arr);

}






























