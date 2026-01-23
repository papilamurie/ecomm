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


//Add To Cart
$("#addToCart").submit(function(e){
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        xhrFields: {
            withCredentials: true // ensures session cookie is sent
        },
        success: function(resp){
            if(resp.status){
                $(".print-success-msg")
                    .html("<div class='alert alert-success'>"+resp.message+"</div>")
                    .show().delay(3000).fadeOut();
            }else{
                $(".print-error-msg")
                    .html("<div class='alert alert-danger'>"+resp.message+"</div>")
                    .show().delay(3000).fadeOut();
            }
        },
        error: function(xhr){
            console.log(xhr.responseJSON);
            alert("An error occurred.");
        }
    });
});


