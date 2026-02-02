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

// Product Attribute Price AJAX
$(document).on("change", ".getPrice", function () {
    var size = $(this).val();
    var product_id = $(this).data("product-id");

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

            var finalFormatted = resp.final_price_formatted || resp.final_price_display || '';
            var baseFormatted = resp.product_price_formatted || resp.product_price_display || '';

            // Fallback to numeric formatting if formatted versions not available
            if (!finalFormatted && typeof resp.final_price !== 'undefined') {
                finalFormatted = Number(resp.final_price).toFixed(2);
            }
            if (!baseFormatted && typeof resp.product_price !== 'undefined') {
                baseFormatted = Number(resp.product_price).toFixed(2);
            }

            // Display price with or without discount
            if (resp.discount > 0 || (resp.percent && Number(resp.percent) > 0)) {
                $('.getAttributePrice').html(
                    "<span class='new-price'>" + finalFormatted + "</span>" +
                    "<span class='old-price'>" + baseFormatted + "</span>"
                );
            } else {
                $('.getAttributePrice').html(
                    "<span class='new-price'>" + finalFormatted + "</span>" // Fixed: removed hardcoded $
                );
            }

            // Update mini price if exists
            if (resp.final_price_formatted) {
                $('#mini-price').text(resp.final_price_formatted);
            }
        },
        error: function (xhr, status, err) {
            console.log("Error Fetching Price:", err || status);
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

// Login Form Ajax Handler
$(document).on('submit', '#loginForm', function(e) {
    e.preventDefault();

    // Clear previous errors
    $('.help-block.text-danger').text('');

    var $btn = $('#loginButton');
    $btn.prop('disabled', true).text('Please Wait...');

    var payload = {
        email: $('#loginEmail').val(),
        password: $('#loginPassword').val(),
        user_type: $('input[name="user_type"]:checked').val()
    };

    $.ajax({
        url: window.routes && window.routes.userLoginPost ? window.routes.userLoginPost : '/user/login',
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(resp) {
            if(resp.success) {
                $('#loginSuccess').html('<div class="alert alert-success">' + resp.message + '</div>');
                // Keep button disabled during redirect
                window.location.href = resp.redirect || '/';
            } else {
                $('#loginSuccess').html('<div class="alert alert-danger">Login Failed</div>');
                $btn.prop('disabled', false).text('LOGIN');
            }
        },
        error: function(xhr) {
            $btn.prop('disabled', false).text('LOGIN');

            if(xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function(key, val) {
                    $('[data-error="' + key + '"]').text(val[0]);
                });
            } else {
                $('#loginSuccess').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                console.error(xhr.responseText || xhr);
            }
        }
    });
});

// Register Form Ajax Handler
$(document).on('submit', '#registerForm', function(e) {
    e.preventDefault();

    // Clear previous errors
    $('.help-block.text-danger').text('');

    var $btn = $('#registerButton');
    $btn.prop('disabled', true).text('Please Wait...');

    var payload = {
        name: $('#name').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        password_confirmation: $('#password_confirmation').val(),
        user_type: $('input[name="user_type"]:checked').val()
    };

    $.ajax({
        url: window.routes && window.routes.userRegisterPost ? window.routes.userRegisterPost : '/user/register',
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(resp) {
            if(resp.success) {
                $('#registerSuccess').html('<div class="alert alert-success">' + resp.message + '</div>');
                $('#registerForm')[0].reset();

                // Redirect after 1.5 seconds
                setTimeout(function() {
                    window.location.href = resp.redirect || '/';
                }, 1500);
            } else {
                $('#registerSuccess').html('<div class="alert alert-danger">Registration Failed</div>');
                $btn.prop('disabled', false).text('REGISTER');
            }
        },
        error: function(xhr) {
            $btn.prop('disabled', false).text('REGISTER');

            if(xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function(key, val) {
                    $('[data-error="' + key + '"]').text(val[0]);
                });
            } else {
                $('#registerSuccess').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                console.error(xhr.responseText || xhr);
            }
        }
    });
});

// Currency Switcher
(function () {
    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    var btn = document.getElementById('current-currency-btn');
    var list = document.getElementById('currency-list');

    if (!btn || !list) return;

    // Toggle currency dropdown
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        list.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        list.classList.remove('show');
    });

    // Prevent closing when clicking inside list
    list.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Currency switch URL
    var switchUrl = (window.appConfig && window.appConfig.currencySwitchUrl)
        ? window.appConfig.currencySwitchUrl
        : '/currency/switch';

    var csrfToken = getCsrfToken();

    // Handle currency item clicks
    document.querySelectorAll('.currency-item').forEach(function (el) {
        el.addEventListener('click', function () {
            var code = this.getAttribute('data-code');
            if (!code) return;

            fetch(switchUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(function (res) {
                return res.json().catch(function () {
                    return {};
                });
            })
            .then(function (resp) {
                if (resp && resp.status === 'success') {
                    location.reload();
                } else {
                    alert(resp.message || 'Could not switch currency');
                }
            })
            .catch(function (err) {
                console.error(err);
                alert('Network error switching currency');
            });
        });
    });
})();


