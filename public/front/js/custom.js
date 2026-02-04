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

             // Update SKU
                if (resp.sku) {
                    $(".skuText").text(resp.sku);
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

(function(){
    //Delay init until DOM ready
    document.addEventListener('DOMContentLoaded', function(){
        const starContainer = document.getElementById('star-rating');
        const ratingInput = document.getElementById('ratingInput');
        const reviewForm = document.getElementById('reviewForm');

        console.log('[review debug] init', { starContainer: !!starContainer, ratingInput: !!ratingInput, reviewForm: !!reviewForm });
        if(!starContainer || !ratingInput){
            console.warn('[review debug] starContainer or ratingInput missing. Abort star init.');
            return;
        }

        //Ensure there is exactly one form/input/container
        try{
            if(document.querySelectorAll('#star-rating').length !== 1) console.warn('[review debug] #star-rating count:',
                document.querySelectorAll('#star-rating').length);
            if(document.querySelectorAll('#ratingInput').length !== 1) console.warn('[review debug] #ratingInput count:',
                document.querySelectorAll('#ratingInput').length);
        } catch(e){ console.error(e);}

        // Event delegation: handle click/hover on the container
        function setVisual(value){
            const stars = starContainer.querySelectorAll('i[data-value]');
            stars.forEach(s=>{
                const v = parseInt(s.getAttribute('data-value') || 0, 10);
                if(v<=value){ s.classList.remove('far'); s.classList.add('fas');}
                else{ s.classList.remove('fas'); s.classList.add('far');}
            });
        }

        //initialize from existing value
        const initial = parseInt(ratingInput.value || '0', 10) || 0;
        if(initial) setVisual(initial);

        //single handler for clicks
        starContainer.addEventListener('click', function(evt){
            const el = evt.target.closest('i[data-value]');
            if(!el) return;
            const val = parseInt(el.getAttribute('data-value') || 0, 10) || 0;
            ratingInput.value = val;
            setVisual(val);
            console.log('[review debug] star clicked', val);
        });

        //mouseover/out handlers
        starContainer.addEventListener('mouseover', function(evt){
            const el = evt.target.closest('i[data-value]');
            if(!el) return;
            const val = parseInt(el.getAttribute('data-value')||0, 10) || 0;
            setVisual(val);
        }, true);

        starContainer.addEventListener('mouseout', function(evt){
            //restore to selected rating
            const current = parseInt(ratingInput.value || 0, 10) || 0;
            setVisual(current);
        }, true);

        //ajax submit
        if(reviewForm){
            reviewForm.addEventListener('submit', function(e){
                //if you prefer non-ajax remove this block and server will redirect with flash(option A)
                e.preventDefault();
                if(!ratingInput.value || ratingInput.value == 0){
                    alert('Please Select a Rating (1-5).');
                    return;
                }

                const tokenEl = reviewForm.querySelector('input[name="_token"]');
                const token = tokenEl ? tokenEl.value :
                (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||"");

                const fd = new FormData(reviewForm);
                fetch(reviewForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: fd,
                    credentials: 'same-origin'
                }).then(async res=>{
                    const json = await res.json().catch(()=>null);
                    if (res.ok) {
                        // show inline message (simple)
                        const parent = reviewForm.parentElement;
                        const old = parent.querySelector('.ajax-review-alert');
                        if (old) old.remove();
                        const div = document.createElement('div');
                        div.className = 'ajax-review-alert alert alert-success mt-3';
                        div.innerHTML = (json && json.message) ? json.message : 'Thank you — review submitted.';
                        parent.insertBefore(div, parent.firstChild);
                        // reset
                        reviewForm.reset();
                        ratingInput.value = 0;
                        setVisual(0);
                    } else {
                        const parent = reviewForm.parentElement;
                        const old = parent.querySelector('.ajax-review-alert');
                        if (old) old.remove();
                        const div = document.createElement('div');
                        div.className = 'ajax-review-alert alert alert-danger mt-3';
                        let msg = 'Unable to submit review.';
                        if (json && json.message) msg = json.message;
                        else if (json && json.errors) msg = Object.values(json.errors).flat().join('<br>');
                        div.innerHTML = msg;
                        parent.insertBefore(div, parent.firstChild);
                    }
                }).catch(err=>{
                    console.error('[review debug] submit error', err);
                    alert('Server error — try again later.');
                });
            });
        }
    });
})();

(function () {
    'use strict';

    function getCsrfToken() {
        if (window.App && window.App.csrfToken) return window.App.csrfToken;
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function showAlert(containerId, html) {
        const el = document.getElementById(containerId);
        if (el) el.innerHTML = html;
    }

    function clearFieldErrors() {
        document.querySelectorAll('[data-error-for]').forEach(el => el.innerText = "");
    }

    function displayFieldErrors(errors) {
        for (const key in errors) {
            const el = document.querySelector('[data-error-for="' + key + '"]');
            if (el) el.innerText = errors[key][0];
        }
    }

    async function handleFetch(fetchPromise, btn, originalText, successCallback) {
        try {
            const res = await fetchPromise;
            btn.disabled = false;
            btn.innerText = originalText;
            if (res.ok) {
                const json = await res.json().catch(() => ({}));
                if (successCallback) successCallback(json);
                return;
            }
            if (res.status === 422) {
                const json = await res.json().catch(() => ({}));
                displayFieldErrors(json.errors || {});
                return;
            }
            const text = await res.text().catch(() => "");
            console.error('Unexpected response:', res.status, text);
        } catch (err) {
            btn.disabled = false;
            btn.innerText = originalText;
            console.error(err);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = getCsrfToken();

        // Forgot form
        const forgotForm = document.getElementById('forgotForm');
        if (forgotForm) {
            const forgotBtn = document.getElementById('forgotButton');
            forgotForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearFieldErrors();
                showAlert('forgotSuccess', "");
                if (!forgotBtn) return;
                const originalText = forgotBtn.innerText;
                forgotBtn.disabled = true;
                forgotBtn.innerText = 'Please wait...';
                const email = forgotForm.email ? forgotForm.email.value : "";
                const url = window.App && window.App.routes && window.App.routes.forgotPost
                    ? window.App.routes.forgotPost
                    : '/user/password/forgot';
                const fetchPromise = fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ email })
                });
                handleFetch(fetchPromise, forgotBtn, originalText, function (json) {
                    showAlert('forgotSuccess', '<div class="alert alert-success">' + (json.message || 'Reset link sent.') + '</div>');
                });
            });
        }

        // Reset form
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            const resetBtn = document.getElementById('resetButton');
            resetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearFieldErrors();
                showAlert('resetSuccess', "");
                if (!resetBtn) return;
                const originalText = resetBtn.innerText;
                resetBtn.disabled = true;
                resetBtn.innerText = 'Please wait...';
                const payload = {
                    token: resetForm.token ? resetForm.token.value : "",
                    email: resetForm.email ? resetForm.email.value : "",
                    password: resetForm.password ? resetForm.password.value : "",
                    password_confirmation: resetForm.password_confirmation ? resetForm.password_confirmation.value : ""
                };
                const url = window.App && window.App.routes && window.App.routes.resetPost
                    ? window.App.routes.resetPost
                    : '/user/password/reset';
                const fetchPromise = fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });
                handleFetch(fetchPromise, resetBtn, originalText, function (json) {
                    showAlert('resetSuccess', '<div class="alert alert-success">' + (json.message || 'Password reset successful.') + '</div>');
                    if (json.redirect) setTimeout(() => window.location.href = json.redirect, 1200);
                });
            });
        }
    });
})();


