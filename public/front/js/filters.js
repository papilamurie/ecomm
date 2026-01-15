$(document).ready(function (){

    // Handle filter checkboxes (colors, sizes, etc.)
    $(document).on('change', '.filterAjax', function(){
        RefreshFilters("yes");
    });

    //Handle Sort Dropdown
    $(document).on('change', '.getsort', function(){
        RefreshFilters("yes");
    });

    //Price range filter
    $(document).on('click', '#pricesort', function(){
        var minprice = parseInt($('#from_range').val());
        var maxprice = parseInt($('#to_range').val());

        $("#priceRange").val(minprice + "-" + maxprice);

        debounce(function (){
            $("input[name='price']").val($("#priceRange").val()).click();
        },100)();

        RefreshFilters("yes");
    });
});

//build query and call Ajax
function RefreshFilters(type){
    var queryStringObject = {};

    //Collect checked filters
    $(".filterAjax").each(function(){
        var name = $(this).attr('name');
        queryStringObject[name] = [];

        $.each($("input[name='" + name + "']:checked"), function(){
            queryStringObject[name].push($(this).val());
        });

        if(queryStringObject[name].length == 0){
            delete queryStringObject[name];
        }
    });

    //Price range
    var priceVal = $("#priceRange").val();
    if(priceVal && priceVal !== "NaN-NaN"){
        queryStringObject["price"] = [priceVal];
    }

    //sort dropdown
    var value = $('.getsort').val();
    var name = $('.getsort').attr('name');

    if(value){
        queryStringObject[name] = [value];
    }

    if(type === "yes"){
        filterproducts(queryStringObject);
    }else{
        filterproducts({});
    }
}

// Ajax call for filtered products
function filterproducts(queryStringObject){
    $('body').css({'overflow':'hidden'});

    let queryString = "";
    var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;

    for(var key in queryStringObject){
        if(queryString == ''){
            queryString += "?" + key + "=";
        }else{
            queryString += "&" + key + "=";
        }
        var queryValue = queryStringObject[key].join("~");
        queryString += encodeURIComponent(queryValue);
    }

    newUrl += queryString;

    if(history.pushState){
        window.history.pushState({path:newUrl},'',newUrl);
    }

    if(newUrl.indexOf("?") >= 0){
        newUrl = newUrl + "&json=";
    }else{
        newUrl = newUrl + "?json=";
    }

    $.ajax({
        url: newUrl,
        type: 'get',
        dataType: 'json',
        success: function (resp){
            $("#appendProducts").html(resp.view);
            document.body.style.overflow = 'scroll';
        },
        error:function(){}
    });
}

// debounce helper
function debounce(fn, delay){
    var timer;
    return function(){
        clearTimeout(timer);
        timer = setTimeout(fn, delay);
    };
}
