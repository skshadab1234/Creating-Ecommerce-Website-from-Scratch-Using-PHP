// -----------------Login Script Start------------------------------------------
$(document).ready(() => {
    $("#SignSubmit_Desktop").submit((e) => {
        e.preventDefault();
        var data = $("#SignSubmit_Desktop").serialize();
        $(".login-button").prop("disabled", true);
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {
                var json = $.parseJSON(res);
                $(".login-button").prop("disabled", false);

                
                if (json.status == 'success') {
                    swal("Login Successfully" , json.msg ,"success");   
                    setTimeout( () => {
                        window.location.href = window.location.href; //one level up
                    }, 2000)
                }

                else if (json.status == 'error') {
                    swal( json.msg ,"" ,"error");   
                }
            }
        });
    })

    $("#SignSubmit_Phone").submit((e) => {
        e.preventDefault();
        var data = $("#SignSubmit_Phone").serialize();
        $(".login-button").prop("disabled", true);
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {

                var json = $.parseJSON(res);
                $(".login-button").prop("disabled", false);

                if (json.status == 'success') {
                    swal("Login Successfully" , json.msg ,"success");   
                    setTimeout( () => {
                        window.location.href = window.location.href; //one level up
                    }, 2000)
                }

                else if (json.status == 'error') {
                    swal(json.msg, "" , "error");   
                }
            }
        });
    })

    $("#LoginiPage_Submit").submit((e) => {
        e.preventDefault();
        var data = $("#LoginiPage_Submit").serialize();
        $(".login-button").prop("disabled", true);
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {

                var json = $.parseJSON(res);
                $(".login-button").prop("disabled", false);

                if (json.status == 'success') {
                    swal("Login Successfully" , json.msg ,"success");   
                    setTimeout( () => {
                        window.location.href = window.location.href; //one level up
                    }, 2000)
                }

                else if (json.status == 'error') {
                    swal(json.msg, "" , "error");   
                }
            }
        });
    })
// -----------------Login Script End------------------------------------------

// -----------------Register Script Start------------------------------------------

    $("#Signup_Desktop").submit((e) => {
        e.preventDefault();
        var data = $("#Signup_Desktop").serialize();
        $(".register-button").prop("disabled", true);
        $(".register-button").html("Sending Mail");
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {
                var json = $.parseJSON(res);
                $(".register-button").prop("disabled", false);
                $(".register-button").html("Register");

                if (json.status == 'success') {
                    $("#Signup_Desktop")[0].reset();
                    swal("Account Created Successfully" , json.msg ,"success");   
                }

                else if (json.status == 'error') {
                    swal(json.msg ,"" , "error");   
                }
            }
        });
    })

    $("#SignUp_Phone").submit((e) => {
        e.preventDefault();
        var data = $("#SignUp_Phone").serialize();
        $(".register-button").prop("disabled", true);
        $(".register-button").html("Sending Mail");
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {
                var json = $.parseJSON(res);
                $(".register-button").prop("disabled", false);
                $(".register-button").html("Register");

                if (json.status == 'success') {
                    $("#Signup_Desktop")[0].reset();
                    swal("Account Created Successfully" , json.msg ,"success");   
                }

                else if (json.status == 'error') {
                    swal(json.msg , "","error");   
                }
            }
        });
    })
    
    // Register Page Signup 
    $("#RegisterPageSignup").submit((e) => {
        e.preventDefault();
        var data = $("#RegisterPageSignup").serialize();
        $(".register-button").prop("disabled", true);
        $(".register-button").html("Sending Mail");
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {
                var json = $.parseJSON(res);
                $(".register-button").prop("disabled", false);
                $(".register-button").html("Register");

                if (json.status == 'success') {
                    $("#RegisterPageSignup")[0].reset();
                    swal("Account Created Successfully" , json.msg ,"success");   
                }
                else if (json.status == 'error') {
                    swal(json.msg , "" ,"error");   
                }
            }
        });
    })

// -----------------Register Script End------------------------------------------
});


setInterval(() => {
    getCartTotal();
    getCartDetails();
    ShowAllWishlistData();
}, 1000);


// Getting Cart Total to get real time cart total without refresing the page 
function getCartTotal() {
    var CARTTOTALDAILY = 'CARTTOTALDAILY'
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: {
            CARTTOTALDAILY : CARTTOTALDAILY
        },
        success: (res) => {
            $(".cart-products-count-btn").html(res);
        }
    });  
}

getCartTotal();




$('input[name=check_size], input[name=check_sizes]').change(function () {

    $(".page-loading-overlay").show();

    var check1 = $(" input[name=check_sizes]:checked").val();
    var check2 = $("input[name=check_size]:checked").val();

    setTimeout(() => {
        $(".page-loading-overlay").hide();
        $("input[name='qty']").val('1');
    }, 1000)
});


// Quick View Product 
function quickviewaction(prod_id) {
    var quickview = 'quickview';
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data  : {
            prod_id : prod_id,
            quickview : quickview,
        },
        success : (res) => {
            $("#quickview_product").html(res);
            setTimeout( () => {
                $(".modal-backdrop").addClass("fade in");
                $("#blockcart-modal-wrap").show();
                $(".modal-backdrop").show();
                $("#quickview-modal-3-13").addClass("quickview in");
                $("#quickview-modal-3-13").css({"display":"block"});
                
            }, 1000)
        }
    })
}

// Add to Cart For Mobile

$("#add-to-cart-all-items").submit((e) => {
    e.preventDefault();
    var data = $("#add-to-cart-all-items").serialize();
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: data,
        success: (res) => {
            // caliing getCartDetails function to get details when we click add to cart button 
            getCartDetails();

            var json_arr = $.parseJSON(res);
            $(".modal-backdrop").addClass("fade in");
            $(".modal-backdrop").show();
            $("#blockcart-modal-wrap").show();
            $("#blockcart-modal").show();
            
            if (json_arr.status = 'logged') {
                $("#blockcart-modal .modal-content .modal-header .modal-title").html(json_arr.modal_title);
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
            }else{
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
            }

        }
    });
})

// Add to Cart For Desktop 

$("#add-to-cart-desktop").submit((e) => {
    e.preventDefault();
    var data = $("#add-to-cart-desktop").serialize();
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: data,
        success: (res) => {
            // caliing getCartDetails function to get details when we click add to cart button 
            getCartDetails();

            var json_arr = $.parseJSON(res);
            $(".modal-backdrop").addClass("fade in");
            $(".modal-backdrop").show();
            $("#blockcart-modal-wrap").show();
            $("#blockcart-modal").show();
            
            if (json_arr.status = 'logged') {
                $("#blockcart-modal .modal-content .modal-header .modal-title").html(json_arr.modal_title);
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
            }else{
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
            }

            
        }
    });
})

// Close the Modal fal
$(".close").click(() => {
    $(".modal-backdrop").removeClass("fade in");
    $(".modal-backdrop").hide();
    $("#blockcart-modal-wrap").hide();
    $("#blockcart-modal").hide();
    $("#quickview-modal-3-13").removeClass("quickview in");
    $("#quickview-modal-3-13").css({"display":"none"});
})

// Add to Cart For Singal Product in list of Product Like Home Page Product 
function addtoCart(prod_id, user_id, qty, prod_price, check_size, type='', wish_id = '') {
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: {
            prod_id : prod_id,
            user_id : user_id,
            qty : qty,
            prod_price : prod_price,
            check_size : check_size,
            type: type,
            wish_id: wish_id
        },
        success: (res) => {
            // caliing getCartDetails function to get details when we click add to cart button 
            getCartDetails();
            $(".rb-ajax-loading").hide();
            var json_arr = $.parseJSON(res);
            $(".modal-backdrop").addClass("fade in");
            $(".modal-backdrop").show();
            $("#blockcart-modal-wrap").show();
            $("#blockcart-modal").show();
            
            if (json_arr.status = 'logged') {
                $("#blockcart-modal .modal-content .modal-header .modal-title").html(json_arr.modal_title);
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
                if (type != '') {
                    $('#removeWishlstProduct_'+prod_id).fadeTo(1000, 0.01, function(){ 
                        $(this).slideUp(150, function() {
                            $(this).remove(); 
                        }); 
                    });
                }
            }else{
                $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                $(".cart-products-count-btn").html(json_arr.Cart_Total);
            }

            
        }
    });
}

function ShowAllWishlistData() {
    var show_wishlist = 'show_wishlist';
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data  : {
            show_wishlist : show_wishlist,
        },
        success : (res) => {
            $(".show_all_wishlist").html(res);
        }
    });

}

ShowAllWishlistData();


function getCartDetails() {
    var id = $("#user_id_login").val();
    var type = 'getcartDetails';
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data  : {
            id : id,
            type : type,
        },
        success : (res) => {
            var json_enc = $.parseJSON(res);
            
            $(".no-items").show();
            $(".cart-grid-right").show();
            $(".cart-products").show();
            $(".cart-subtotals ").show();
            $(".cart-buttons").show();
            
            if (json_enc.status == 'success') {
                $(".no-items").hide();
                $(".cart-products").html(json_enc.cart_product);
                $(".cart-products-count").html(json_enc.cart_products_count);
                $(".js-subtotal").html(json_enc.cart_total+" items");
                $(".price-total, #cart-subtotal-products .value").html(json_enc.price_total);
                $("#cart-subtotal-shipping .value").html(json_enc.shipping_price);
                $("#Total_Payabale, #pay_by_check_total").html(json_enc.total_payable);
                $("#product_payment_section").html(json_enc.product_payment_section);
                $("#detaills_page_data").html(json_enc.detaills_page_data);
                $(".cart-products-count-btn").html(json_enc.CartTotal);
            }
           
            else if(json_enc.status == 'error'){
                $(".no-items").show();
                $(".cart-grid-right").hide();
                $(".no-items").html(json_enc.msg);
                $(".cart-products").hide();
                $(".cart-subtotals ").hide();
                $(".cart-buttons").hide();
            }
            
        }
    })
}

getCartDetails();

$("#cart-toogle").click( () => {
    getCartDetails();
});

function getCartData() {
    var id = $("#user_id_login").val();
    var data = 'getCartData';
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data  : {
            id : id,
            data : data,
        },
        success : (res) => {
            if (res == 'No_Data') {
                // Hiding Container at inital level and then when we have itme then we shoow 
                $("#cart_container").hide();
                
            }else{
                $(".cart-items").html(res);
            }
            
        }
    })
}

getCartData();


function delete_product_from_cart(uid, pid, size) {
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : {
            uid : uid,
            pid : pid,
            size : size,
        },
        success : (res) => {
            getCartDetails();
            var data = $.parseJSON(res);
            swal("Product Deleted Successfully" , data.CartTotal+' Remains in yout Cart' ,"success");   

            $(".cart-products-count-btn").html(data.CartTotal);
            getCartData();
            
        }
    })
}



function setAddresDefault(setAddresDefaultId) {
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : {
            setAddresDefaultId : setAddresDefaultId,
        },
        success : (res) => {
            alert(res)
            
        }
    })
}


$("#submitAddress").submit( (e) => {
    e.preventDefault();

    var data = $("#submitAddress").serialize();
    $(".page-loading-overlay").show();

    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : data,
        success : (res) => {
            $("#payment_confirm_address").html(res);
            $("body#checkout section.checkout-step .btn.btn-primary").removeClass("disabled");
            $(".page-loading-overlay").hide();
            $("#checkout-addresses-step").addClass("-complete");
            $("#checkout-addresses-step").removeClass("current -current js-current-step");
            $("#checkout-payment-step").addClass("-reachable -clickable -complete -current js-current-step");
            $("#checkout-payment-step").removeClass("-unreachable");
            $("#checkout-payment-step .step-title").removeClass("not-allowed")
        }   
    })
})

// JAB USR LOGN NAHI RAHEGA TB login_to_CHECKOUT YE WALI ID EXIST KREGI US SAMAYE HAME ISKE CLICK EVENT PE CHECKOUT PAGE OPEN KRNA HAI 
$("#login_to_CHECKOUT, #cart_checkout_id, #add_wishlist_no_login, #back_to_login_forgot_password, #InviteNowNoLogin").click( () => {
    $("#blockcart").removeClass("open");
    $(".mfp-bg, .mfp-wrap").hide();
    setTimeout(()=>{
        $(".rb-login").addClass("active");
    }, 500)
})



$("#new_wishlist").submit( (e) => {
    e.preventDefault();
    var data = $("#new_wishlist").serialize();
    
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : data,
        success : (res) => {
            var data = $.parseJSON(res);
            
            if(data.status == 'success') {
                $("#success_wishlist").show("slow");
                $("#success_wishlist").html(data.message);
                $("#new_wishlist")[0].reset();
            }

            else if(data.status == 'error') {
                $("#error_wishlist").show("slow");
                $("#error_wishlist").html(data.message);
            }

            setTimeout( () => {
                $("#success_wishlist").hide("slow");
                $("#error_wishlist").hide("slow");
            }, 2000);
        }
    });    
})


// No Login Ad to wisshlist 
$(".no_login_wishlist_2").click( () =>  {
    $(".mfp-bg, .mfp-wrap").show();
    
    setTimeout( () => {
        $(".mfp-bg, .mfp-wrap").hide();
    }, 5000)
})

// Add the item to Wishlist 
function AddtoWishList(wishlist_id, prod_id, sizes){
    var AddtoWishList = 'AddtoWishList';
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : {
            wishlist_id : wishlist_id,
            prod_id : prod_id,
            sizes : sizes,
            AddtoWishList : AddtoWishList
        },
        success : (res) => {
            var data = $.parseJSON(res);
            
            if (data.status == 'success') {
                $(".rb_added"+wishlist_id+'_'+prod_id).css({"color":"green", "pointer-events" : "none"});
                $(".rb_added"+wishlist_id+'_'+prod_id+' i').removeAttr('class');
                $(".rb_added"+wishlist_id+'_'+prod_id+' i').addClass("fa fa-check");

                swal("Added To Wishlist", data.message, "success");
            }
        }
    
    })
}

$("#forgotten-password").submit( (e) => {
    e.preventDefault();
    var form_data = $("#forgotten-password").serialize();
    $("#reset_pass_button").prop("disabled", 'disabled');
    $("#reset_pass_button").html("Sending Link");
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : form_data,
        success : (res) => {
            var data = $.parseJSON(res);
            
            $("#reset_pass_button").attr("disabled", false);
            $("#reset_pass_button").html("Send reset link");

            if (data.status == 'success') {
                $("#forgotten-password")[0].reset();
                swal("Check Your Mail", data.message ,'success');
            }

            else if(data.status == 'error') {
                swal("Email id Not Found", data.message ,'error');
            }
        
        }
    })
})


// Update Passoword 
$("#update-password").submit( (e) =>  {
    e.preventDefault();
    var form_data = $("#update-password").serialize();
    $.ajax({
        url : 'ajax_call.php',
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
                    window.location = window.location.href;
                }, 3000);
            }
        }
    });
})


// Product Search Work 

$("#Search_Product_mb").keyup( () => { // Searchng on Mobile Device
    var search_val_mb = $("#Search_Product_mb").val()
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : {search_val_mb:search_val_mb},
        success : (res) => {
            var data = $.parseJSON(res);
            
            if (data.status == 'error') {
                $("#notfoundproducterror").html(data.message);
                $("#Product_Getted_From_DB").html('');   
            }
            if (data.status == 'success') {
                $("#notfoundproducterror").html('');
                $("#Product_Getted_From_DB").html(data.message);    
            }
            
        }
    });
})

$("#Search_Product_For_Desktop").keyup( () => { // Seacrhing on Desktop Device
    var search_val_mb = $("#Search_Product_For_Desktop").val();
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : {search_val_mb:search_val_mb},
        success : (res) => {
            var data = $.parseJSON(res);
            $("#Product_Getted_From_DB_Desktop").show();
            if (data.status == 'error') {
                $("#notfound_Product_Desktop").html(data.message);
                $("#Product_Getted_From_DB_Desktop").html('');   
            }
            if (data.status == 'success') {
                $("#notfound_Product_Desktop").html('');
                $("#Product_Getted_From_DB_Desktop").html(data.message);    
            }
            
        }
    });
})

// Prventing Dropdown Box When we Click on body it will hide but not hide when we click on dropdown box 
$(document).on('click', function (event) {
    if (!$(event.target).closest('#Product_Getted_From_DB_Desktop').length) {
        $("#Product_Getted_From_DB_Desktop").hide();
    }else{
        $("#Product_Getted_From_DB_Desktop").show();
    }
});



// Profile Identity Update 
$("#customer-form").submit( (e) => {
    e.preventDefault();
    var form_data = $("#customer-form").serialize();
    $.ajax({
        url : 'ajax_call.php',
        method : 'post',
        data : form_data,
        success : (res) => {
            var data = $.parseJSON(res);
            if (data.status == 'success') {
                 swal(data.message,data.text,data.status);
            }

            if (data.status == 'error') {
                swal(data.message,'',data.status);
           }
           
        }
    });
})


function shopProductListing() {
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: {
            "shopProductListing" : "shopProductListing"
        },
        success: (res) => {
            $("#shopProductListing").html(res);
        }
    });  
}
shopProductListing();

function autoSizeTextArea(idname) {
    var text = jQuery(idname).val(),
    // look for any "\n" occurences
    matches = text.match(/\n/g),
    breaks = matches ? matches.length : 2;

    jQuery(idname).attr('rows',breaks + 2);
}


// Add Comment For Your Order 
$("#addcommentforyourOrder").submit( (e) => {
    e.preventDefault();
    if (!$.trim($('.addcomentfororder').val())) {
        swal("Add some message",'','error');
    }else{
        var form_data = $("#addcommentforyourOrder").serialize();
        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: form_data,
            success: (res) => {
                var data = $.parseJSON(res);
                $('html, body').animate({
                    scrollTop: $("#mesage_display_order_"+data.prod_num_id+", #mesage_display_ordermobile_"+data.prod_num_id).offset().top - 400
                }, 1000);
            
                $("#mesage_display_order_"+data.prod_num_id+", #mesage_display_ordermobile_"+data.prod_num_id).hide();
                setTimeout(()=>{
                    $("#mesage_display_order_"+data.prod_num_id+", #mesage_display_ordermobile_"+data.prod_num_id).show();
                    $("#mesage_display_order_"+data.prod_num_id+", #mesage_display_ordermobile_"+data.prod_num_id).html(data.msgText);
                }, 1300)
                
                autoSizeTextArea("#textareacommentorder_"+data.Order_id);
            }
        }); 
    }
     
})


// After Delivery Add review 
$("#product_review_submit").submit( e => {
    e.preventDefault();
    var form_data = $("#product_review_submit").serialize();
    $(".rb-ajax-loading").show();
    $.ajax({
        url: 'ajax_call.php',
        type: 'post',
        data: form_data,
        success: (res) => {
            var data = $.parseJSON(res);

            if (data.status == 'success') {
                if (data.rate >= 2.5) {
                    var color = 'green';
                }else{
                    var color = 'red';
                }
                setTimeout( () => {
                    $(".rb-ajax-loading").hide();
                    $("#rating_system_add").html('<div class="container-fluid mt-2"><header class="page-header"><h1>Thanks for Rating</h1></header><div class="card"><div class="row"><div class="col-sm-10"><p class="text-justify p-2">'+data.message+'</p></div><div class="col-sm-2 " style="display: flex;justify-content: center;align-items: center;padding: 20px"><h1 class="rating_class" style="background: '+color+'" >'+data.rate+'<span class="ml-1"><i class="fa fa-star"></i></span></h1></div></div></div></div>');
                }, 1000);
            }

            if (data.status == 'error') {
                swal("Already Rateed", '', 'error');
            }
        }
    });
})



// Download Invoice 
function DownloadInvoice(ProductOrderId, track_id,pid, qty_key, prd_varint_key, payment_prod_price, filename, redirect) {
    $("#DownloadInvoiceAtag_" +ProductOrderId+track_id+pid+prd_varint_key).hide();
    $.ajax({
        url: 'Invoices.php',
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
















