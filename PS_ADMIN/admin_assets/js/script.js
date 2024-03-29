var ADMIN_FRONT_SITE = $("#Adming_front_side").val();
$(document).ready(() => {
    $("#Admin_Login_Form").submit((e) => {
        e.preventDefault();

        $("#sign_button_admin").prop("disabled", true);

        var data = $("#Admin_Login_Form").serialize();
        $.ajax({
            url: "admin_ajax_call.php",
            type: "post",
            data: data,
            success: (res) => {
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


$('#Date_Dashboard').change(function () {
    // Getting Selected Date
    var SelectedDate = $(this).val();
    DashboardData(SelectedDate);
});


var dates = $("#date").val();

function DashboardData(date) {
    if (date < '2021-10-04') {
        swal({
            title: "Date is not equal to Company Startup Date",
            text: '',
            type: "success"
        }).then(function () {
            $("#Date_Dashboard").val(dates);
            $("#Date_Dashboard").trigger("change");
        });
    }
    else if (date > dates) {
        swal({
            title: "No Data Found!",
            text: '',
            type: "success"
        }).then(function () {
            $("#Date_Dashboard").val(dates);
            $("#Date_Dashboard").trigger("change");
        });

    }
    else {
        $.ajax({
            url: "admin_ajax_call.php",
            type: "post",
            data: 'SelectedDate=' + date,
            success: (res) => {
                var json = $.parseJSON(res);
                $("#orders_data").html(json.order_html);
                $("#product_total").html(json.product_html);
                $("#users_html").html(json.users_html);
                $("#revenue_html").html(json.revenue_html);
                $(".datatable_order_date").html(json.datatable_order_date)
                // $("#today_order_date").html(json.today_orders_total);
                $("#dailyNews").dataTable().fnDestroy()

                $('#total_order_table').DataTable({
                    "destroy": true,
                    "responsive": true,
                    "autoWidth": false,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    'ajax': ADMIN_FRONT_SITE + 'json/data.json',
                });
            }
        })
    }
}

DashboardData(dates)

// Forgot Password Syustem 

$("#admin_forgot_password").submit((e) => {
    e.preventDefault();

    var reset_email = $("#admin_forgot_password").serialize();
    $("#reset_pass_button").prop("disabled", 'disabled');
    $("#reset_pass_button").html("Sending Link");

    $.ajax({
        url: "admin_ajax_call.php",
        type: "post",
        data: reset_email,
        success: (res) => {
            var data = $.parseJSON(res);

            $("#reset_pass_button").attr("disabled", false);
            $("#reset_pass_button").html("Send reset link");

            if (data.status == 'success') {
                $("#admin_forgot_password")[0].reset();
                swal("Check Your Mail", data.message, 'success');
            }

            else if (data.status == 'error') {
                swal("Email id Not Found", data.message, 'error');
            }
        }
    });
})

// Update Password Admin 
$("#update-password-admin").submit((e) => {
    e.preventDefault();

    var form_data = $("#update-password-admin").serialize();
    $.ajax({
        url: 'admin_ajax_call.php',
        method: 'post',
        data: form_data,
        success: (res) => {
            var data = $.parseJSON(res);

            if (data.status == 'error') {
                swal(data.message, '', 'error');
            }
            if (data.status == 'success') {
                swal(data.message, '', 'success');
                setTimeout(() => {
                    window.location = 'login';
                }, 3000);
            }
        }
    });
})

// Product Adding after main setting section 
$("#form_main_setting_product").submit((e) => {
    e.preventDefault();
    var form_data = $("#form_main_setting_product").serialize();
    $.ajax({
        url: 'admin_ajax_call.php',
        method: 'post',
        data: form_data,
        success: (res) => {
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

// Selecting checkbox to Update Product and Showig and Hiding All Buttons
$("#product_activate_btn").click(()=>{
    $("#productStatusAfterBtnClick").val('1');
});

$("#product_deactivate_btn").click(()=>{
    $("#productStatusAfterBtnClick").val('0');
});

$("#product_draft_btn").click(()=>{
    $("#productStatusAfterBtnClick").val('2');
});

// Selecting checkbox to Update Brand and Showig and Hiding All Buttons
$("#product_brand_btn").click(()=>{
    $("#productBrandStatusAfterBtnClick").val('1');
});

$("#product_brand_btn_d").click(()=>{
    $("#productBrandStatusAfterBtnClick").val('0');
});


function select_all() {
    if (jQuery('#update_check_data').prop("checked")) {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', true);
        });
        $("#product_activate_btn,  #product_deactivate_btn, #product_draft_btn, #update_stock_bulk, #update_qc_status").show();
    } else {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', false);
        });
        $("#product_activate_btn,  #product_deactivate_btn, #product_draft_btn, #update_stock_bulk, #update_qc_status").hide();
    }
}

function get_total_selected() {
    if ($('input[type=checkbox]:checked').length > 0) {
        $("#product_activate_btn, #product_deactivate_btn, #product_draft_btn, #product_brand_btn, #product_brand_btn_d, #product_category_btn, #product_subcategory_btn, #update_stock_bulk, #update_qc_status").show();
    } else {
        $("#product_activate_btn, #product_deactivate_btn, #product_draft_btn, #product_brand_btn, #product_brand_btn_d, #product_category_btn, #product_subcategory_btn, #update_stock_bulk, #update_qc_status").hide();
    }
}

$("#update_all_product_checkbox_frm").submit((e) => {
    e.preventDefault();

    var form_data = $("#update_all_product_checkbox_frm").serialize();
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            ProductListingAjax();
            $("#update_all_product_checkbox_frm")[0].reset();
            $(".modal").hide();
            $(".fade").hide();
            $("body").css({"overflow-y" : "auto"});
            $("#product_activate_btn,  #product_deactivate_btn, #product_draft_btn, #update_stock_bulk, #update_qc_status").hide();
        }
    });
})

ProductListingAjax();

function ProductListingAjax() {
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: {
            "ProductListingAjax": "ProductListingAjax"
        },
        success: function (result) {
                $("#ProductListExample").dataTable().fnDestroy()

                $('#ProductListExample tfoot th:gt(1)').each( function () {
                    var title = $(this).text();
                    $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
                } );

               $('#ProductListExample').DataTable({
                    dom: 'Blfrtip',
                    "destroy": true,
                    "responsive": true,
                    "autoWidth": false,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    initComplete: function () {
                        // Apply the search
                        this.api().columns(':gt(1)').every( function () {
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

                    buttons: [
                        {
                            extend: 'searchBuilder',
                            config: {
                                depthLimit: 2
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                stripHtml: false,
                                columns: [1, 2, 3,4,5,6,7,8,9]
                                //specify which column you want to print
                            }
                        }    
                    ],
            
                    
                    'ajax': ADMIN_FRONT_SITE + 'json/product.json',
                });

        }
    });
}

var cloneNodeDataSheetCount = $("#getLastElementDataSheet").val();
$("#add_more_product_data_sheeet_field").click(() => {
    var cloneNodeDataSheet = $("#cloneNodeDataSheet");
    cloneNodeDataSheetCount++;
    var DataAppend = '<div class="row" style="width:100%;margin: 2px 0;" id="box_' + cloneNodeDataSheetCount + '"><div class="form-group col-md-6"><label for="data_sheet_name">Product Data Sheet Name</label><input type="text" class="form-control" name="data_sheet_name[]" placeholder="Enter Product Data Sheet Name"></div><div class="form-group col-md-4"><label for="data_sheet_desc">Product Data Sheet Description</label><input type="text" class="form-control" name="data_sheet_desc[]"value="" placeholder="Enter Product Data Sheet Description"></div><div class="col-md-2" style="display: flex;    width: 100%;height: 85px;justify-content: center;align-items: center;"><a class="btn btn-danger" onclick="DeleteCloneNodeDatSheet(' + cloneNodeDataSheetCount + ')">Remove</a></div></div>';

    cloneNodeDataSheet.append(DataAppend);

})

function DeleteCloneNodeDatSheet(id) {
    $("#box_" + id).remove();
}

function removeDataSheetFromDB(id) {
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: {
            id: id,
            "removeDataSheetFromDB": "removeDataSheetFromDB"
        },
        success: function (result) {
            $("#removeDataSheetFromDB_" + id).remove();
            swal('Data Sheet Deleted Successfully', '', "success");
        }
    });
}

// Category Select All 
function select_all_category() {
    if (jQuery('#delete_check_category').prop("checked")) {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', true);
        });
        $("#product_category_btn").show();
    } else {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', false);
        });
        $("#product_category_btn").hide();
    }
}

$("#delete_all_category_checkbox_frm").submit((e) => {
    e.preventDefault();

    var form_data = $("#delete_all_category_checkbox_frm").serialize();

    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            window.location = window.location.href;
        }
    });
})

$("#category_data_form").submit((e) => {
    e.preventDefault();
    var form_data = $("#category_data_form").serialize();
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            if (result == 'Updated') {
                // swal("Category Updated Successfully", '', 'success');
                swal({
                    title: "Category Updated Successfully",
                    text: "",
                    type: "success"
                }).then(function () {
                    window.location = "category";
                });
            }
            if (result == 'insert') {
                // swal("Category Inserted Successfully", '', 'success');
                swal({
                    title: "Category Inserted Successfully",
                    text: "",
                    type: "success"
                }).then(function () {
                    window.location = "category";
                });
            }
            // window.location = 'category';    
        }
    });
})

product_category_Change();

function product_category_Change() {
    var id = $("#product_category_121").val();
    var sub_cat_recive_from_Db = $("#sub_cat_recive_from_Db").val();
    if (id == '') {
        jQuery('#sub_category_data').html('<option value="-1"  selected>Select Sub Category</option>');
    } else {
        jQuery('#sub_category_data').html('<option value="-1"  selected>Select Sub Category</option>');
        jQuery.ajax({
            url: "admin_ajax_call.php",
            type: "post",
            data: "id=" + id + '&change_category_load_sub_category=sub_category&sub_cat_recive_from_Db=' + sub_cat_recive_from_Db,
            success: function (data) {
                jQuery('#sub_category_data').append(data);
            }
        });
    }
}

$(document).ready(() => {
    setTimeout(() => {
        product_subcategory_Change();
    }, 1000);
})
function product_subcategory_Change() {
    var id = $("#sub_category_data").val();
    var sub_catValue_recive_from_Db = $("#sub_catValue_recive_from_Db").val();
    if (id == '') {
        jQuery('#sub_category_value').html('<option value=""  selected>Select Sub Category Value</option>');
    } else {
        jQuery('#sub_category_value').html('<option value=""  selected>Select Sub Category Value</option>');
        jQuery.ajax({
            url: "admin_ajax_call.php",
            type: "post",
            data: "id=" + id + '&change_subcategory_load_sub_category=sub_category&sub_catValue_recive_from_Db=' + sub_catValue_recive_from_Db,
            success: function (data) {
                jQuery('#sub_category_value').append(data);
            }
        });
    }
}


// SUBCATEGORY FORM SUBMIT 
$("#subcategory_data_form").submit((e) => {
    e.preventDefault();
    var form_data = $("#subcategory_data_form").serialize();
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            if (result == 'Updated') {
                swal({
                    title: "Sub Category Updated Successfully",
                    text: "",
                    type: "success"
                }).then(function () {
                    window.location = "subcategory";
                });
            }
            if (result == 'insert') {
                swal({
                    title: "Sub Category Inserted Successfully",
                    text: "",
                    type: "success"
                }).then(function () {
                    window.location = "subcategory";
                });
            }
        }
    });
})


// Deleting Selected Subcategory value from Db 
// Category Select All 
function select_all_subcategory() {
    if (jQuery('#delete_subcheck_category').prop("checked")) {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', true);
        });
        $("#product_subcategory_btn").show();
    } else {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', false);
        });
        $("#product_subcategory_btn").hide();
    }
}


$("#delete_all_subcategory_checkbox_frm").submit((e) => {
    e.preventDefault();

    var form_data = $("#delete_all_subcategory_checkbox_frm").serialize();
    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            window.location = window.location.href;
        }
    });
})


// Brand Select All 
function select_all_brand() {
    if (jQuery('#delete_check_brand').prop("checked")) {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', true);
        });
        $("#product_brand_btn,#product_brand_btn_d").show();
    } else {
        jQuery('input[type=checkbox]').each(function () {
            jQuery('#' + this.id).prop('checked', false);
        });
        $("#product_brand_btn,#product_brand_btn_d").hide();
    }
}

$("#delete_all_brand_checkbox_frm").submit((e) => {
    e.preventDefault();

    var form_data = $("#delete_all_brand_checkbox_frm").serialize();

    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            window.location = window.location.href;
        }
    });
})


// Brand Adding to Db
$("#brand_data_form").submit((e) => {
    e.preventDefault();
    var form_data = $("#brand_data_form").serialize();

    jQuery.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: form_data,
        success: function (result) {
            // window.location = window.location.href;
            if (result == 'exist') {
                swal("Brand Exist", 'Try to add another brand', 'error');
            } else {
                $("#brand_data_form").hide();
                $("#brand_images").show();
            }
        }
    });
});


// Key up GetStateCity
function GetStateCity() {
    var zip = $("#postal_code");

    if (zip.val().length > 5) {
        jQuery.ajax({
            url: '../ajax_call.php',
            type: 'post',
            data: 'pincodeOfAddressToGetCityState=' + zip.val(),
            success: function (data) {

                if (data == 'no') {
                    alert('Wrong Pincode');
                    jQuery('#city_address').val('');
                    jQuery('#state_address').val('');
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                } else {
                    var getData = $.parseJSON(data);
                    jQuery('#city_address, #city_for_db').val(getData.city);
                    jQuery('#state_address, #state_for_db').val(getData.state);
                    $("#delivery_boy_landmark").html('<option value=""  disabled>--please choose--</option>');
                    $("#delivery_boy_landmark").append(getData.address_complement);
                }
            }
        });
    }
}


function getDeliveryBoyForAssigning(orderTrackId) {
    $.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: "OrderTrackId=" + orderTrackId,
        success: function (data) {
            var res = $.parseJSON(data);
            if (res.status == 'success') {
                $("#listofdeliveryBoy_" + orderTrackId).html('<option value=""  selected disabled>--please choose--</option>');
                $("#listofdeliveryBoy_" + orderTrackId).append(res.list);
            }
            else if (res.status == 'error') {
                $("#listofdeliveryBoy_" + orderTrackId).html('<option value=""  selected disabled>--please choose--</option>');
                // $('.modal').removeClass('show');

                swal(res.message, '', res.status);

            }
        }
    })
}

function SubmitAssignedDelivery(orderTrackId) {
    var SubmitAssignedDelivery_id = $("#listofdeliveryBoy_" + orderTrackId).val();

    if (SubmitAssignedDelivery_id == null) {
        swal("Please Select Delivery Boy", '', 'error');
    } else {
        $.ajax({
            url: 'admin_ajax_call.php',
            type: 'post',
            data: "SubmitAssignedDelivery_id=" + SubmitAssignedDelivery_id + "&orderTrackId=" + orderTrackId,
            success: function (data) {
                $("#dumpAssignedDeliveryData_" + orderTrackId).html(data);
                $(".modal-backdrop").remove();
                $("body").removeClass("modal-open")
            }
        })
    }
}

function RemoveAssignedDeliveryBoy(orderTrackid) {
    $.ajax({
        url: 'admin_ajax_call.php',
        type: 'post',
        data: "RemoveAssignedDeliveryBoy=" + orderTrackid,
        success: function (data) {
            $("#dumpAssignedDeliveryData_" + orderTrackid).html(data);
        }
    })
}

// Download Invoice 
function DownloadInvoice(ProductOrderId, track_id,pid, qty_key, prd_varint_key, payment_prod_price, filename, redirect) {
    $("#DownloadInvoiceAtag_" +ProductOrderId+track_id+pid+prd_varint_key).hide();
    $.ajax({
        url: '../Invoices.php',
        method: 'post',
        data: {
            ProductOrderId: ProductOrderId,
            track_id:track_id,
            pid: pid,
            qty_key: qty_key,
            prd_varint_key: prd_varint_key,
            payment_prod_price: payment_prod_price,
            filename: filename,
            redirect: redirect
        },
        success: (res) => {
            var data = $.parseJSON(res);

            $("#DownloadInvoiceAtag_" +ProductOrderId+track_id+pid+prd_varint_key).show();

            swal({
                title: "Invoice Downloaded Successfully",
                type: "success"
            }).then(() => {
                $("#addInvoiceMessagefromRespone_"+ProductOrderId+track_id+pid+prd_varint_key).html("<a href="+data.filepath+data.filename+" target='_blank'>#"+data.filename+"</a>");   
            });
        }
    })

}














