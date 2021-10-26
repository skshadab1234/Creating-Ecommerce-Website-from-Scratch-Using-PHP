$(document).ready( () => {
    $("#Admin_Login_Form").submit( (e) => {
        e.preventDefault();

        $("#sign_button_admin").prop("disabled", true);

        var data = $("#Admin_Login_Form").serialize();
        $.ajax({
            url : "admin_ajax_call.php",
            type : "post",
            data : data,
            success : (res) => {
                var json = $.parseJSON(res);
                $("#sign_button_admin").prop("disabled", false);

                if (json.status == 'success') {
                    swal("Login Successfully", json.msg, "success");
                    window.location.href = window.location.href; //one level up
                }

                else if (json.status == 'error') {
                    swal("Error", json.msg, "error");
                }
            }
        })
    })
})


$('#Date_Dashboard').change(function(){
    // Getting Selected Date
    var SelectedDate =  $(this).val();
    DashboardData(SelectedDate);
});


var dates = $("#date").val();

function DashboardData(date) {
    if (date < '2021-10-04') {
        swal({
            title: "Date is not equal to Company Startup Date",
            text : '',
            type: "success"
        }).then(function() {
            $("#Date_Dashboard").val(dates);
            $("#Date_Dashboard").trigger("change");
        });
    }
    else if (date > dates) {
        swal({
            title: "No Data Found!",
            text : '',
            type: "success"
        }).then(function() {
            $("#Date_Dashboard").val(dates);
            $("#Date_Dashboard").trigger("change");
        });
        
    }
    else{
        $.ajax({
            url : "admin_ajax_call.php",
            type : "post",
            data : 'SelectedDate='+date,
            success : (res) => {
                var json = $.parseJSON(res);
                $("#orders_data").html(json.order_html);
                $("#product_total").html(json.product_html);
                $("#users_html").html(json.users_html);
                $("#revenue_html").html(json.revenue_html);
            }
        })
    }
}

DashboardData(dates)