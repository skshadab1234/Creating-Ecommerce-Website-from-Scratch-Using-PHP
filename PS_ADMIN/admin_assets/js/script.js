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


// Forgot Password Syustem 

$("#admin_forgot_password").submit( (e) => {
    e.preventDefault();

    var reset_email = $("#admin_forgot_password").serialize();
    $("#reset_pass_button").prop("disabled", 'disabled');
    $("#reset_pass_button").html("Sending Link");

    $.ajax({
        url : "admin_ajax_call.php",
        type : "post",
        data : reset_email,
        success : (res) => {
            var data = $.parseJSON(res);
            
            $("#reset_pass_button").attr("disabled", false);
            $("#reset_pass_button").html("Send reset link");

            if (data.status == 'success') {
                $("#admin_forgot_password")[0].reset();
                swal("Check Your Mail", data.message ,'success');
            }

            else if(data.status == 'error') {
                swal("Email id Not Found", data.message ,'error');
            }
        }
    }); 
})

// Update Password Admin 
$("#update-password-admin").submit( (e) => {
    e.preventDefault();

    var form_data = $("#update-password-admin").serialize();
    $.ajax({
        url : 'admin_ajax_call.php',
        method : 'post',
        data : form_data,
        success : (res) => {
            var data = $.parseJSON(res);
            
            if (data.status == 'error') {
                swal(data.message ,'','error');
            }
            if (data.status == 'success') {
                swal(data.message ,'','success');
                setTimeout( () => {
                    window.location = 'login';
                }, 3000);
            }
        }
    });
})

// Product Adding after main setting section 
$("#form_main_setting_product").submit( (e) => {
    e.preventDefault();
    var form_data = $("#form_main_setting_product").serialize();
    $.ajax({
        url : 'admin_ajax_call.php',
        method : 'post',
        data : form_data,
        success : (res) => {
            var data = $.parseJSON(res);

            if (data.status == 'error') {
                swal(data.message, '', data.status);
            }
            else if (data.status == 'success') {
                swal(data.message, '', data.status);
            }
            else if (data.status == 'warning') {
                swal(data.message, '', data.status);
            }
        }
    });
})

// Selecting checkbox to delete Product 

function select_all(){
	if(jQuery('#delete_check_data').prop("checked")){
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',true);
		});
        $("#product_delete_btn").show();
	}else{
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',false);
		});
        $("#product_delete_btn").hide();
	}
}

function get_total_selected() {
    if ($('input[type=checkbox]:checked').length > 0) {
        $("#product_delete_btn").show();
    }else{
        $("#product_delete_btn").hide();
    }

}


$("#delete_all_product_checkbox_frm").submit( (e) => {
    e.preventDefault();

    var form_data = $("#delete_all_product_checkbox_frm").serialize();
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:form_data,
        success:function(result){
            ProductListingAjax();
            $("#example1_info").html(result);
        }
    });
})

ProductListingAjax();

function ProductListingAjax() {
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:{
            "ProductListingAjax" : "ProductListingAjax"
        },
        success:function(result){
            $("#product_listing_td").html(result);
        }
    });
}
	


