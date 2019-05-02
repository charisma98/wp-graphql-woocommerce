<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29fb4e57dbe1a5186c8d438e6b04c82c
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPGraphQL\\Extensions\\WooCommerce\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPGraphQL\\Extensions\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'WPGraphQL\\Extensions\\WooCommerce\\Actions' => __DIR__ . '/../..' . '/src/class-actions.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Cart_Items' => __DIR__ . '/../..' . '/src/connection/class-cart-items.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Coupons' => __DIR__ . '/../..' . '/src/connection/class-coupons.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Customers' => __DIR__ . '/../..' . '/src/connection/class-customers.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Order_Items' => __DIR__ . '/../..' . '/src/connection/class-order-items.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Orders' => __DIR__ . '/../..' . '/src/connection/class-orders.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Posts' => __DIR__ . '/../..' . '/src/connection/class-posts.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Product_Attributes' => __DIR__ . '/../..' . '/src/connection/class-product-attributes.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Products' => __DIR__ . '/../..' . '/src/connection/class-products.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Refunds' => __DIR__ . '/../..' . '/src/connection/class-refunds.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Shipping_Methods' => __DIR__ . '/../..' . '/src/connection/class-shipping-methods.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Tax_Rates' => __DIR__ . '/../..' . '/src/connection/class-tax-rates.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\Variation_Attributes' => __DIR__ . '/../..' . '/src/connection/class-variation-attributes.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\WC_Connection' => __DIR__ . '/../..' . '/src/connection/class-wc-connection.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Connection\\WC_Terms' => __DIR__ . '/../..' . '/src/connection/class-wc-terms.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Cart_Item_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-cart-item-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Coupon_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-coupon-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Customer_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-customer-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Order_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-order-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Order_Item_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-order-item-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Post_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-post-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Product_Attribute_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-product-attribute-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Product_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-product-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Refund_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-refund-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Shipping_Method_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-shipping-method-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Tax_Rate_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-tax-rate-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\Variation_Attribute_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-variation-attribute-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\WC_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/trait-wc-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Connection\\WC_Terms_Connection_Resolver' => __DIR__ . '/../..' . '/src/data/connection/class-wc-terms-connection-resolver.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Factory' => __DIR__ . '/../..' . '/src/data/class-factory.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Loader\\WC_Customer_Loader' => __DIR__ . '/../..' . '/src/data/loader/class-wc-customer-loader.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Data\\Loader\\WC_Post_Crud_Loader' => __DIR__ . '/../..' . '/src/data/loader/class-wc-post-crud-loader.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Filters' => __DIR__ . '/../..' . '/src/class-filters.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Coupon' => __DIR__ . '/../..' . '/src/model/class-coupon.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Crud_CPT' => __DIR__ . '/../..' . '/src/model/class-crud-cpt.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Customer' => __DIR__ . '/../..' . '/src/model/class-customer.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Order' => __DIR__ . '/../..' . '/src/model/class-order.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Order_Item' => __DIR__ . '/../..' . '/src/model/class-order-item.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Product' => __DIR__ . '/../..' . '/src/model/class-product.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Product_Variation' => __DIR__ . '/../..' . '/src/model/class-product-variation.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Refund' => __DIR__ . '/../..' . '/src/model/class-refund.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Shipping_Method' => __DIR__ . '/../..' . '/src/model/class-shipping-method.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Shop_Manager_Caps' => __DIR__ . '/../..' . '/src/model/trait-shop-manager-caps.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Model\\Tax_Rate' => __DIR__ . '/../..' . '/src/model/class-tax-rate.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Backorders' => __DIR__ . '/../..' . '/src/type/enum/class-backorders.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Catalog_Visibility' => __DIR__ . '/../..' . '/src/type/enum/class-catalog-visibility.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Customer_Connection_Orderby_Enum' => __DIR__ . '/../..' . '/src/type/enum/class-customer-connection-orderby-enum.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Discount_Type' => __DIR__ . '/../..' . '/src/type/enum/class-discount-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Manage_Stock' => __DIR__ . '/../..' . '/src/type/enum/class-manage-stock.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Order_Status' => __DIR__ . '/../..' . '/src/type/enum/class-order-status.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Product_Types' => __DIR__ . '/../..' . '/src/type/enum/class-product-types.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Stock_Status' => __DIR__ . '/../..' . '/src/type/enum/class-stock-status.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Tax_Class' => __DIR__ . '/../..' . '/src/type/enum/class-tax-class.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Tax_Rate_Connection_Orderby_Enum' => __DIR__ . '/../..' . '/src/type/enum/class-tax-rate-connection-orderby-enum.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\Tax_Status' => __DIR__ . '/../..' . '/src/type/enum/class-tax-status.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPEnum\\WC_Connection_Orderby_Enum' => __DIR__ . '/../..' . '/src/type/enum/class-wc-connection-orderby-enum.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPInputObject\\Tax_Rate_Connection_Orderby_Input' => __DIR__ . '/../..' . '/src/type/input/class-tax-rate-connection-orderby-input.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPInputObject\\WC_Connection_Orderby_Input' => __DIR__ . '/../..' . '/src/type/input/class-wc-connection-orderby-input.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Cart_Type' => __DIR__ . '/../..' . '/src/type/object/class-cart-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Coupon_Type' => __DIR__ . '/../..' . '/src/type/object/class-coupon-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Customer_Address_Type' => __DIR__ . '/../..' . '/src/type/object/class-customer-address-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Customer_Type' => __DIR__ . '/../..' . '/src/type/object/class-customer-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Order_Item_Type' => __DIR__ . '/../..' . '/src/type/object/class-order-item-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Order_Type' => __DIR__ . '/../..' . '/src/type/object/class-order-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Product_Attribute_Type' => __DIR__ . '/../..' . '/src/type/object/class-product-attribute-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Product_Download_Type' => __DIR__ . '/../..' . '/src/type/object/class-product-download-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Product_Rating_Counter_Type' => __DIR__ . '/../..' . '/src/type/object/class-product-rating-counter-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Product_Type' => __DIR__ . '/../..' . '/src/type/object/class-product-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Product_Variation_Type' => __DIR__ . '/../..' . '/src/type/object/class-product-variation-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Refund_Type' => __DIR__ . '/../..' . '/src/type/object/class-refund-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Shipping_Method_Type' => __DIR__ . '/../..' . '/src/type/object/class-shipping-method-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Tax_Rate_Type' => __DIR__ . '/../..' . '/src/type/object/class-tax-rate-type.php',
        'WPGraphQL\\Extensions\\WooCommerce\\Type\\WPObject\\Variation_Attribute_Type' => __DIR__ . '/../..' . '/src/type/object/class-variation-attribute-type.php',
        'WP_GraphQL_WooCommerce' => __DIR__ . '/../..' . '/src/class-wp-graphql-woocommerce.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit29fb4e57dbe1a5186c8d438e6b04c82c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit29fb4e57dbe1a5186c8d438e6b04c82c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit29fb4e57dbe1a5186c8d438e6b04c82c::$classMap;

        }, null, ClassLoader::class);
    }
}
