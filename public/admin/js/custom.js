//Add/Remove Attribute script
const maxField = 10;
const wrapper = $('.field_wrapper');
const addButton = '.add_button';
const removeTmpl = '<a href="javascript:void(0);" class="btn btn-sm btn-danger remove_button" title="Remove Row"><i class="fas fa-minus"></i></a>';

$(document).on('click', addButton, function (e){
    e.preventDefault();
    if(wrapper.find('.attribute-row').length>=maxField) return;
    const row = $(this).closest('.attribute-row').clone();
    row.find('input').val('');
    row.find(addButton).replaceWith(removeTmpl);
    wrapper.append(row);
});

wrapper.on('click', '.remove_button', function (e){
    e.preventDefault();
    $(this).closest('.attribute-row').remove();
});

$("#current_pwd").keyup(function() {
    var current_pwd = $("#current_pwd").val();
    $.ajax({
        type: 'POST',
        url: '/admin/verify-password',
        data: {
            current_pwd: current_pwd,
            _token: $('meta[name="csrf-token"]').attr('content') // <-- add this
        },
        success: function(resp) {
            if(resp == "false"){
                $("#verifyPwd").html("<span style='color:red'>Current Password is Incorrect</span>");
            } else if(resp == "true"){
                $("#verifyPwd").html("<span style='color:green'>Current Password is Correct</span>");
            }
        },
        error: function(xhr) {
            alert("Error: " + xhr.status);
        }
    });
});
$(document).on('click','#deleteProfileImage',function() {
    if(confirm('Are you sure you want to remove your profile image?')) {

        $.ajax({
            type: 'POST',
            url: '/admin/delete-profile-image',
            data: {
                admin_id: $(this).data('admin-id'),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (resp.status) {  // <-- FIXED
                    alert(resp.message);
                    $('#profileImageBlock').remove();
                     window.location.reload();
                } else {
                    alert(resp.message);

                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.status);
            }
        });

    }
});

// Update Subadmin Status
$(document).on("click", ".updateSubadminStatus", function () {

    var icon = $(this).children("i");
    var status = icon.data("status");
    var subadmin_id = $(this).data("subadmin_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-subadmin-status",
        data: {
            status: status,
            subadmin_id: subadmin_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            // Update UI based on response
            if (resp.status == 0) {
                $("a[data-subadmin_id='" + subadmin_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-subadmin_id='" + subadmin_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});

// Update Category Status
$(document).on("click", ".updateCategoryStatus", function () {

    var icon = $(this).find("i");
    var status = icon.attr("data-status"); // FIXED
    var category_id = $(this).data("category_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-category-status",
        data: {
            status: status,
            category_id: category_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            if (resp.status == 0) {
                $("a[data-category_id='" + category_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-category_id='" + category_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});

// Update Products Status
$(document).on("click", ".updateProductStatus", function () {

    var icon = $(this).find("i");
    var status = icon.attr("data-status"); // FIXED
    var product_id = $(this).data("product_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-product-status",
        data: {
            status: status,
            product_id: product_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            if (resp.status == 0) {
                $("a[data-product_id='" + product_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-product_id='" + product_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});

// Update Attribute Status
$(document).on("click", ".updateAttributeStatus", function () {

    var icon = $(this).find("i");
    var status = icon.attr("data-status"); // FIXED
    var attribute_id = $(this).data("attribute_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-attribute-status",
        data: {
            status: status,
            attribute_id: attribute_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            if (resp.status == 0) {
                $("a[data-attribute_id='" + attribute_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-attribute_id='" + attribute_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});

// Update Brand Status
$(document).on("click", ".updateBrandStatus", function () {

    var icon = $(this).find("i");
    var status = icon.attr("data-status"); // FIXED
    var brand_id = $(this).data("brand_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-brand-status",
        data: {
            status: status,
            brand_id: brand_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            if (resp.status == 0) {
                $("a[data-brand_id='" + brand_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-brand_id='" + brand_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});

// Update Banners Status
$(document).on("click", ".updateBannerStatus", function () {

    var icon = $(this).find("i");
    var status = icon.attr("data-status"); // FIXED
    var banner_id = $(this).data("banner_id");

    $.ajax({
        type: "POST",
        url: "/admin/update-banner-status",
        data: {
            status: status,
            banner_id: banner_id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (resp) {

            if (resp.status == 0) {
                $("a[data-banner_id='" + banner_id + "']").html(
                    "<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>"
                );
            } else if (resp.status == 1) {
                $("a[data-banner_id='" + banner_id + "']").html(
                    "<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>"
                );
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        }
    });
});




// Delete category Image

 $(document).on('click','#deleteCategoryImage',function() {
    if(confirm('Are you sure you want to remove this category image?')) {

        $.ajax({
            type: 'POST',
            url: '/admin/delete-category-image',
            data: {
                category_id: $(this).data('category-id'),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (resp.status) {  // <-- FIXED
                    alert(resp.message);
                    $('#categoryImageBlock').remove();
                     window.location.reload();
                } else {
                    alert(resp.message);

                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.status);
            }
        });

    }
});

// Delete Sizechart Image

 $(document).on('click','#deleteSizechartImage',function() {
    if(confirm('Are you sure you want to remove this sizechart image?')) {

        $.ajax({
            type: 'POST',
            url: '/admin/delete-sizechart-image',
            data: {
                category_id: $(this).data('category-id'),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (resp.status) {  // <-- FIXED
                    alert(resp.message);
                    $('#sizechartImageBlock').remove();
                     window.location.reload();
                } else {
                    alert(resp.message);

                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.status);
            }
        });

    }
});
// confirm delete for subadmin
// $(".confirmDelete").click(function(){

//     var name = $(this).attr('name');
//     if(confirm('Are you sure you want to delete this ' + name + '?')){
//         return true;
//     }
//     return false;
// });
$(document).on("click", ".confirmDelete", function (e) {
    e.preventDefault();
    let button = $(this);
    let module = button.data("module");
    let moduleid = button.data("id");
    let form = button.closest("form");
    let redirectUrl = "/admin/delete-" + module + "/" + moduleid;
    Swal.fire({
        title: 'Are You Sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result)=>{
        if(result.isConfirmed){
            //check if form exists and has  delete route
            if (form.length>0 && form.attr("action") && form.attr("method")==="POST"){
                //create and append  hidden method if not present
               if(form.find("input[name='_method']").length===0){
                form.append('<input type="hidden" name="_method" value="DELETE">');
               }
               form.submit();
            }else{
                window.location.href = redirectUrl;
            }
        }
    });
});

$(document).on("click", ".deleteProductImage", function () {
    let url = $(this).data("url");

    Swal.fire({
        title: 'Delete image?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
});
$(document).on("click", ".deleteProductAttribute", function () {
    let url = $(this).data("url");

    Swal.fire({
        title: 'Delete Attribute?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
});
$(document).on("click", ".deleteProductVideo", function () {
    let url = $(this).data("url");

    Swal.fire({
        title: 'Delete Video?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
});
$(document).on("click", ".deleteProductImages", function () {
    let url = $(this).data("url");

    Swal.fire({
        title: 'Delete Image?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
});






