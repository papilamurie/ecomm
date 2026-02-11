<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property string|null $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $subadmin_id
 * @property string $module
 * @property int $view_access
 * @property int $edit_access
 * @property int $full_access
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereEditAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereFullAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereSubadminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminsRole whereViewAccess($value)
 */
	class AdminsRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $link
 * @property string|null $title
 * @property string $alt
 * @property string $image
 * @property int $sort
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banners whereUpdatedAt($value)
 */
	class Banners extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property string|null $logo
 * @property float $discount
 * @property string|null $description
 * @property string $url
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $menu_status
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMenuStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUrl($value)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $session_id
 * @property int $user_id
 * @property int $product_id
 * @property string $product_size
 * @property int $product_qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereProductQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereProductSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $image
 * @property string|null $size_chart
 * @property float $discount
 * @property string|null $description
 * @property string $url
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $menu_status
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Filter> $filters
 * @property-read int|null $filters_count
 * @property-read Category|null $parentcategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMenuStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSizeChart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUrl($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereUpdatedAt($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $admin_id
 * @property string $table_name
 * @property string|null $column_order
 * @property string|null $hidden_columns
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereColumnOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereHiddenColumns($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColumnPreference whereUpdatedAt($value)
 */
	class ColumnPreference extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $iso_code
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\State> $states
 * @property-read int|null $states_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $coupon_option
 * @property string $coupon_code
 * @property array<array-key, mixed>|null $categories
 * @property string|null $brands
 * @property array<array-key, mixed>|null $users
 * @property string|null $coupon_type
 * @property string $amount_type
 * @property float $amount
 * @property int|null $min_qty
 * @property int|null $max_qty
 * @property float|null $min_cart_value
 * @property float|null $max_cart_value
 * @property int $total_usage_limit
 * @property int $usage_limit_per_user
 * @property numeric|null $max_discount
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property int $status
 * @property int $visible
 * @property int $used_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereAmountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereBrands($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCouponOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCouponType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMaxCartValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMaxQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMinCartValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMinQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereTotalUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsageLimitPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereVisible($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string|null $symbol
 * @property string|null $name
 * @property float $rate
 * @property int $status
 * @property bool $is_base
 * @property string|null $flag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereIsBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereUpdatedAt($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filter_name
 * @property string|null $filter_column
 * @property int $sort
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereFilterColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereFilterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filter whereUpdatedAt($value)
 */
	class Filter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $filter_id
 * @property string $value
 * @property int $sort
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Filter $filter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FilterValue whereValue($value)
 */
	class FilterValue extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property int|null $brand_id
 * @property int $admin_id
 * @property string $admin_type
 * @property string $product_name
 * @property string|null $product_url
 * @property string $product_code
 * @property string $product_color
 * @property string $family_color
 * @property string|null $group_code
 * @property float $product_price
 * @property float $product_discount
 * @property float $product_discount_amount
 * @property string $discount_applied_on
 * @property float $product_gst
 * @property float $final_price
 * @property string|null $main_image
 * @property float $product_weight
 * @property string|null $product_video
 * @property string|null $description
 * @property string|null $wash_care
 * @property string|null $search_keywords
 * @property string|null $fabric
 * @property string|null $pattern
 * @property string|null $sleeve
 * @property string|null $fit
 * @property string|null $occassion
 * @property int $stock
 * @property int $sort
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $is_featured
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductsAttribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Brand|null $brand
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterValue> $filterValues
 * @property-read int|null $filter_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $product_images
 * @property-read int|null $product_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAdminType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDiscountAppliedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFabric($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFamilyColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFinalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereGroupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOccassion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductGst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSearchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSleeve($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWashCare($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int $sort
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage whereUpdatedAt($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property string $size
 * @property string $sku
 * @property numeric $price
 * @property int $stock
 * @property int $sort
 * @property int $status 1=Active,0=Inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsAttribute whereUpdatedAt($value)
 */
	class ProductsAttribute extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsCategory whereUpdatedAt($value)
 */
	class ProductsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductsFilter query()
 */
	class ProductsFilter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating 1-5
 * @property string|null $review
 * @property int $status 1=Approved,0=Pending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereUpdatedAt($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $user_type Customer|Vendor
 * @property int $status 1 = active, 0 = inactive
 * @property string|null $address_line1
 * @property string|null $address_line2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property string $country
 * @property string|null $phone
 * @property string|null $company
 * @property int $is_admin Flag for admin users
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserType($value)
 */
	class User extends \Eloquent {}
}

