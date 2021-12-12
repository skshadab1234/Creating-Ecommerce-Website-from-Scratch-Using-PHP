$(document).ready( () => {
    $("#delivery_Login_Form").submit( (e) => {
        e.preventDefault();

        $("#sign_button_admin").prop("disabled", true);

        var data = $("#delivery_Login_Form").serialize();
        $.ajax({
            url : "delivery_ajax_call.php",
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

// Forgot Password System Delivery
$("#delivery_forgot_password").submit( (e) => {
    e.preventDefault();

    var reset_email = $("#delivery_forgot_password").serialize();
    $("#reset_pass_button").prop("disabled", 'disabled');
    $("#reset_pass_button").html("Sending Link");

    $.ajax({
        url : "delivery_ajax_call.php",
        type : "post",
        data : reset_email,
        success : (res) => {
            var data = $.parseJSON(res);
            
            $("#reset_pass_button").attr("disabled", false);
            $("#reset_pass_button").html("Send reset link");

            if (data.status == 'success') {
                $("#delivery_forgot_password")[0].reset();
                swal("Check Your Mail", data.message ,'success');
            }

            else if(data.status == 'error') {
                swal("Email id Not Found", data.message ,'error');
            }
        }
    }); 
})

// Update Password Admin 
$("#update-password-delivery").submit( (e) => {
    e.preventDefault();

    var form_data = $("#update-password-delivery").serialize();
    $.ajax({
        url : 'delivery_ajax_call.php',
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

// Key up GetStateCity
function GetStateCity() {
    var zip = $("#postal_code");
    var city = $("#city");
    var state = $("#state");

    if(zip.val().length > 5){
        jQuery.ajax({
            url:'../ajax_call.php',
            type:'post',
            data:'pincodeOfAddressToGetCityState='+zip.val(),
            success:function(data){
                    
                if(data=='no'){
                    alert('Wrong Pincode');
                    jQuery('#city_address, #city_for_db').val('');
                    jQuery('#state_address, #state_for_db').val('');
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                }else{
                    var getData=$.parseJSON(data);
                    jQuery('#city_address, #city_for_db').val(getData.city);
                    jQuery('#state_address, #state_for_db').val(getData.state);
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                    $("#delivery_boy_landmark").append(getData.address_complement);
                }
            }
        });
    }
}

// creating func to get current tracking status from php function 
function getCurrentTrackStatus(getCurrentTrackStatus_Response) {
    $.ajax({
        url:'delivery_ajax_call.php',
        type:'post',
        data: {getCurrentTrackStatus_Response:getCurrentTrackStatus_Response},
        success:function(data){
            $("#Track_Status").html(data);
        }
    })
}

// Submit Delivery Status 
$("#ChangeDeliveryStatus").submit(e=>{
    e.preventDefault();

    var form_data = $("#ChangeDeliveryStatus").serialize();
    jQuery.ajax({
        url:'delivery_ajax_call.php',
        type:'post',
        data: form_data,
        success:function(data){
            var json = $.parseJSON(data);
            
            getCurrentTrackStatus(json.track_id);
            if (json.status == 'success') {
                $("#"+json.Status_Name+"_"+json.track_id).prop('disabled', true);
            }
            if(json.status == 'delivered') {
                $("#changeDelivery_Div_Form").remove();
                swal("Package Delivered to Customer", 'Thanks for Delivering', 'success');
            }
            
            $("#ChangeDeliveryStatus")[0].reset();
        }
    });
})





