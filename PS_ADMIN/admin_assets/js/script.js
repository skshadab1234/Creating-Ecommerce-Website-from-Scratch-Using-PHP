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
        $("#product_delete_btn, #product_category_btn, #product_subcategory_btn").show();
    }else{
        $("#product_delete_btn, #product_category_btn, #product_subcategory_btn").hide();
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
	
var cloneNodeDataSheetCount = $("#getLastElementDataSheet").val();
$("#add_more_product_data_sheeet_field").click(()=> {
    var cloneNodeDataSheet = $("#cloneNodeDataSheet");
    cloneNodeDataSheetCount++;
    var DataAppend = '<div class="row" style="width:100%;margin: 2px 0;" id="box_'+cloneNodeDataSheetCount+'"><div class="form-group col-md-6"><label for="data_sheet_name">Product Data Sheet Name</label><input type="text" class="form-control" name="data_sheet_name[]" placeholder="Enter Product Data Sheet Name"></div><div class="form-group col-md-4"><label for="data_sheet_desc">Product Data Sheet Description</label><input type="text" class="form-control" name="data_sheet_desc[]"value="" placeholder="Enter Product Data Sheet Description"></div><div class="col-md-2" style="display: flex;    width: 100%;height: 85px;justify-content: center;align-items: center;"><a class="btn btn-danger" onclick="DeleteCloneNodeDatSheet('+cloneNodeDataSheetCount+')">Remove</a></div></div>';

    cloneNodeDataSheet.append(DataAppend);
    
})

function DeleteCloneNodeDatSheet(id) {
    $("#box_"+id).remove();
}

function removeDataSheetFromDB(id) {
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:{
            id: id,
            "removeDataSheetFromDB" : "removeDataSheetFromDB"
        },
        success:function(result){
            $("#removeDataSheetFromDB_"+id).remove();
            swal('Data Sheet Deleted Successfully', '', "success");
        }
    });
}

// Category Select All 
function select_all_category(){
	if(jQuery('#delete_check_category').prop("checked")){
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',true);
		});
        $("#product_category_btn").show();
	}else{
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',false);
		});
        $("#product_category_btn").hide();
	}
}

$("#delete_all_category_checkbox_frm").submit( (e) => {
    e.preventDefault();

    var form_data = $("#delete_all_category_checkbox_frm").serialize();

    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:form_data,
        success:function(result){
            window.location = window.location.href;
        }
    });
})

$("#category_data_form").submit( (e) => {
    e.preventDefault();
    var form_data = $("#category_data_form").serialize();
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:form_data,
        success:function(result){
            if (result == 'Updated') {
                // swal("Category Updated Successfully", '', 'success');
                swal({
                    title: "Category Updated Successfully",
                    text: "",
                    type: "success"
                }).then(function() {
                    window.location = "category";
                });
            }
            if (result == 'insert') {
                // swal("Category Inserted Successfully", '', 'success');
                swal({
                    title: "Category Inserted Successfully",
                    text: "",
                    type: "success"
                }).then(function() {
                    window.location = "category";
                });
            }
            // window.location = 'category';    
        }
    });
})
    
product_category_Change();

function  product_category_Change() {
    var id = $("#product_category_121").val();
    var sub_cat_recive_from_Db = $("#sub_cat_recive_from_Db").val();
    if (id == '') {
        jQuery('#sub_category_data').html('<option value=""  selected>Select Sub Category</option>');
    }else{
        jQuery('#sub_category_data').html('<option value=""  selected>Select Sub Category</option>');
        jQuery.ajax({
            url : "admin_ajax_call.php",
            type : "post",
            data : "id="+id+'&change_category_load_sub_category=sub_category&sub_cat_recive_from_Db='+sub_cat_recive_from_Db,
            success: function(data){
                jQuery('#sub_category_data').append(data);
            }
        });
    }
}

$(document).ready( () => {
    setTimeout( () => {
        product_subcategory_Change();
    }, 1000);
})
function product_subcategory_Change() {
    var id = $("#sub_category_data").val();
    var sub_catValue_recive_from_Db = $("#sub_catValue_recive_from_Db").val();
    if (id == '') {
        jQuery('#sub_category_value').html('<option value=""  selected>Select Sub Category Value</option>');
    }else{
        jQuery('#sub_category_value').html('<option value=""  selected>Select Sub Category Value</option>');
        jQuery.ajax({
            url : "admin_ajax_call.php",
            type : "post",
            data : "id="+id+'&change_subcategory_load_sub_category=sub_category&sub_catValue_recive_from_Db='+sub_catValue_recive_from_Db,
            success: function(data){
                jQuery('#sub_category_value').append(data);
            }
        });
    }
}


// SUBCATEGORY FORM SUBMIT 
$("#subcategory_data_form").submit( (e) => {
    e.preventDefault();
    var form_data = $("#subcategory_data_form").serialize();
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:form_data,
        success:function(result){
            if (result == 'Updated') {
                swal({
                    title: "Sub Category Updated Successfully",
                    text: "",
                    type: "success"
                }).then(function() {
                    window.location = "subcategory";
                });
            }
            if (result == 'insert') {
                swal({
                    title: "Sub Category Inserted Successfully",
                    text: "",
                    type: "success"
                }).then(function() {
                    window.location = "subcategory";
                });
            }
        }
    });
})


// Deleting Selected Subcategory value from Db 
// Category Select All 
function select_all_subcategory(){
	if(jQuery('#delete_subcheck_category').prop("checked")){
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',true);
		});
        $("#product_subcategory_btn").show();
	}else{
		jQuery('input[type=checkbox]').each(function(){
			jQuery('#'+this.id).prop('checked',false);
		});
        $("#product_subcategory_btn").hide();
	}
}


$("#delete_all_subcategory_checkbox_frm").submit( (e) => {
    e.preventDefault();

    var form_data = $("#delete_all_subcategory_checkbox_frm").serialize();
    jQuery.ajax({
        url:'admin_ajax_call.php',
        type:'post',
        data:form_data,
        success:function(result){
            window.location = window.location.href;
        }
    });
})
