(function($) {

    $(".toggle-password").click(function() {

        $(this).toggleClass("zmdi-eye zmdi-eye-off");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });

})(jQuery);

// Key up GetStateCity for Pickup Validation and cONFIRMATION
function GetStateCity() {
  var zip = $("#postal_code");

  if (zip.val().length > 5) {
      $.ajax({
          url: '../ajax_call.php',
          type: 'post',
          data: 'pincodeOfAddressToGetCityState=' + zip.val()+'&checkPincodeServicable=yes',
          success: function (data) {
              if (data == 'no') {
                  $('#city_address').val('');
                  $('#state_address').val('');
                  $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                  $("#pickup_address_pincode_button").attr("disabled",true);
              } else {
                  var getData = $.parseJSON(data);
                  
                  if (getData.status == 'delivereable') {
                    // agar address delivery hosake ga us pincode pe tho button aur saare input field enable krna hai 
                    $("#address_line_pincode").attr("disabled",false);
                    $('#city_address, #city_for_db').val(getData.city);
                    $('#state_address, #state_for_db').val(getData.state);
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                    $("#delivery_boy_landmark").append(getData.address_complement);
                    $("#pickup_address_pincode_button").attr("disabled",false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Congrulations',
                        text: 'Great!We can pick up any product from this pincode and ship it to crores of buyers accross India',
                    })
                  }

                  if (getData.status == 'not_delivereable') {
                    $("#address_line_pincode").attr("disabled",true);
                    $('#city_address').val('');
                    $('#state_address').val('');
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                    $("#pickup_address_pincode_button").attr("disabled",true);
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Sorry! the pin code entered by you is not serviceable from our site as of now. We are working continously for making pin codes serviceable.',
                      })
                  }
                
                  
              }
          }
      });
  }
}


$.validator.setDefaults({
    submitHandler: function(form) {
        $.ajax({
            url: 'seller_ajax_call.php',
            method: 'post',
            data: $(form).serialize(),
            success: (res) => {
                if(res == 'invalid') {
                    Swal.fire({
                        icon: 'error',
                        title: "Invalid Ifsc code",
                        text: "Please enter valid ifsc code.",
                    });
                }else{
                    Swal.fire({
                        title: "Congratulations!",
                        text: "Bank Details Updated Successfully",
                        icon: "success"
                    }).then(function() {
                        window.location = window.location.href;
                    });
                }
            }
        })
    }
});
$('#bank-account-form').validate({
    rules: {
        bank_holder_name: {
            required: true,
            rangelength: [3, 50]
        },
        account_number: {
            required: true,
            digits: true,
            rangelength: [9, 17]
        },
        retype_account_number: {
            required: true,
            digits: true,
            rangelength: [9, 17],
            equalTo: "#password",
        },
        ifsc_code: {
            required: true,
            rangelength: [11, 11],
        },
    },
    messages: {
        bank_holder_name: {
            rangelength: "Enter your full name mentioned on bank pass book."
        },
        account_number: {
            digits: "Enter Digits Only",
            rangelength: "Enter Correct Account Number",
        },
        retype_account_number: {
            digits: "Enter Digits Only",
            rangelength: "Enter Correct Account Number",
            equalTo: "Account Number didn't match"
        },
        ifsc_code: {
            rangelength: "Enter Valid IFSC Code"
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

$('#ifsc_code').on('keyup blur', function() { // fires on every keyup & blur
    if ($('#ifsc_code').valid()) { // checks form for validity
        $('#ifsc_code_submit_check_btn, #BANK_ACCOUNT_FORM_SUBMIT_BTN').prop('disabled',false); // enables button
    } else {
        $('#ifsc_code_submit_check_btn, #BANK_ACCOUNT_FORM_SUBMIT_BTN').prop('disabled','disabled'); // disables button
    }
});
$("#ifsc_code_submit_check_btn").click(() => {
    var ifsccode = $("#ifsc_code");

    $.ajax({
        url: "seller_ajax_call.php",
        method: 'post',
        data: "IFSC_CODE_FOR_GETTING_VERIFIED_BANK_DETAILS=" + ifsccode.val(),
        success: (res) => {

            if (res == 'Invalid') {
                $("#bank_details").html('');
                $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", true);
                Swal.fire({
                    icon: 'error',
                    title: "Invalid Ifsc code",
                    text: "Please enter valid ifsc code.",
                })
            } else {
                $("#bank_details").html(res);
                $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", false);
            }
        }
    })

});

