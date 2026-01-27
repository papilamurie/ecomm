$(document).ready(function(){
   // Search Products
   $('#search_input').on('keyup', function(){
        let query = $(this).val();
        if(query.length > 2){
            $.ajax({
                url: '/search-products',
                method: 'GET',
                data: {q: query},
                success: function(data){
                    $('#search_result').html(data);
                }
            });
        }else{
            $('#search_result').html('');
        }
    });
});

 $(document).on("change", ".getPrice", function () {
    let size = $(this).val();
    let product_id = $(this).data("product-id"); // better than attr()

    $.ajax({
        url: "/get-product-price",
        type: "POST",
        data: {
            size: size,
            product_id: product_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
                success: function (resp) {
            if (!resp || resp.status === false) return;

            // ✅ Always update SKU (no matter discount or not)
            $(".skuText").text(resp.sku ?? "N/A");

            if (resp.discount > 0) {
                $(".getAttributePrice").html(
                    "<span class='old-price'>$" + resp.product_price + "</span> " +
                    "<span class='new-price'>$" + resp.final_price + "</span>"
                );
            } else {
                $(".getAttributePrice").html(
                    "<span class='new-price'>$" + resp.final_price + "</span>"
                );
            }
        },
        error: function (xhr) {
            console.log("Error:", xhr.responseText);
        }
    });
});


(function($){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    function refreshCart(){
        $.get('/cart/refresh', function(resp){
            $("#cart-items-body").html(resp.items_html);
            $("#cart-summary-container").html(resp.summary_html);  // ✅ Changed to hyphen
            if(resp.totalCartItems !== undefined){
                $('.totalCartItems').text(resp.totalCartItems);
            }
        });
    }

    $(document).ready(function(){
        refreshCart();
    });

    //Add to Cart(POST/Cart)
    $(document).on('submit', '#addToCart', function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': csrf},
            url: '/cart',
            type: "POST",
            data: formData,
            success: function(resp){
                if(resp.status === true){
                    $(".print-success-msg").html('<div class="alert alert-success">'+resp.message+'</div>').show().delay(3000).fadeOut();
                    refreshCart();  // ✅ This will now update totalCartItems
                }else{
                    $(".print-error-msg").html('<div class="alert alert-danger">'+resp.message+'</div>').show().delay(3000).fadeOut();
                }
            },
            error: function(xhr){
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                    const msg = xhr.responseJSON.errors[firstKey][0];
                    $(".print-error-msg").html('<div class="alert alert-danger">'+msg+'</div>').show().delay(3000).fadeOut();
                }else{
                    alert("Error");
                }
            }
        });
    });

    // plus/minus update (PATCH/cart/{id})
    $(document).on('click', '.updateCartQty', function(){
        const cartId = $(this).data('cart-id');
        const dir = $(this).data('dir');
        const input = $('.cart-qty[data-cart-id="'+cartId+'"]');
        let qty = parseInt(input.val() || '1', 10);
        qty = dir === 'up' ? qty + 1 : Math.max(1, qty - 1);
        $.ajax({
            url: '/cart/' + cartId,
            type: 'PATCH',
            headers: {'X-CSRF-TOKEN': csrf},
            data: {qty: qty},
            success: function(resp){
                $('#cart-items-body').html(resp.items_html);
                $('#cart-summary-container').html(resp.summary_html);
                if(resp.totalCartItems !== undefined){  // ✅ Add this
                    $('.totalCartItems').text(resp.totalCartItems);
                }
            },
            error: function(xhr){
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error';
                alert(msg);
            }
        });
    });

    //manual qty change
    $(document).on('change', '.cart-qty', function(){
        const cartId = $(this).data('cart-id');
        let qty = parseInt($(this).val() || '1', 10);
        if(isNaN(qty) || qty < 1) qty = 1;
        $.ajax({
            url: '/cart/' + cartId,
            type: 'PATCH',
            headers: {'X-CSRF-TOKEN': csrf},
            data: {qty: qty},
            success: function(resp){
                $('#cart-items-body').html(resp.items_html);
                $('#cart-summary-container').html(resp.summary_html);
                if(resp.totalCartItems !== undefined){  // ✅ Add this
                    $('.totalCartItems').text(resp.totalCartItems);
                }
            },
            error: function(xhr){
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error';
                alert(msg);
            }
        });
    });

    //Delete Cart Item
    $(document).on('click', '.removeCartItem', function(){
        const cartId = $(this).data('cart-id');
        $.ajax({
            url: '/cart/' + cartId,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': csrf},
            success: function(resp){
                $('#cart-items-body').html(resp.items_html);
                $('#cart-summary-container').html(resp.summary_html);
                if(resp.totalCartItems !== undefined){  // ✅ Add this
                    $('.totalCartItems').text(resp.totalCartItems);
                }
            },
            error: function(xhr){
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error';
                alert(msg);
            }
        });
    });

    function replaceFragments(resp){
        if(!resp) return;
        if(resp.items_html !== undefined){
            $("#cart-items-body").html(resp.items_html);
        }
        if(resp.summary_html !== undefined){
            $("#cart-summary-container").html(resp.summary_html);
        }
        if(resp.totalCartItems !== undefined){
            $(".totalCartItems").text(resp.totalCartItems);
        }
    }

    //Apply Coupon
    $(document).on('submit','#applyCouponForm',function(e){
        e.preventDefault();
        var code = $('#coupon_code').val().trim();
        if(!code){
            $('#coupon-msg').html('<div class="alert alert-danger">Please Enter Coupon Code</div>');
            return;
        }
        $.ajax({
            url: '/cart/apply-coupon',
            method: 'POST',
            headers: {'X-CSRF-TOKEN': csrf},
            data: { coupon_code: code },
            success: function(resp){
                $('#coupon-msg').html('<div class="alert alert-success">'+resp.message+'</div>');
                replaceFragments(resp);
            },
            error: function(xhr){
                if(xhr.responseJSON){
                    const resp = xhr.responseJSON;
                    $('#coupon-msg').html('<div class="alert alert-danger">'+(resp.message || 'Error')+'</div>');
                    replaceFragments(resp);
                }else{
                    $('#coupon-msg').html('<div class="alert alert-danger">Error applying coupon</div>');
                }
            }
        });
    });

    //Remove Coupon
$(document).on('click','#removeCouponBtn', function(e){
    e.preventDefault();
    $.ajax({  // ✅ Fixed: was 'a.ajax'
        url: '/cart/remove-coupon',
        method: 'POST',
        headers: {'X-CSRF-TOKEN': csrf},
        success: function(resp){
            $('#coupon-msg').html('<div class="alert alert-success">'+resp.message+'</div>');
            replaceFragments(resp);
            $('#coupon_code').val('');
        },
        error: function(){
            $('#coupon-msg').html('<div class="alert alert-danger">Error Removing Coupon</div>');
        }
    });
});

})(jQuery);



