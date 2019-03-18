<?php

class ProductQueriesTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    // tests
    public function testProductQuery()
    {
        $product = new WC_Product();
        $product->set_name( 'Test Product' );
        $product->set_slug( 'test-product' );
        $product->set_description( 'lorem ipsum dolor' );
        $product->set_sku( 'wp-pennant' );
        $product->set_price( 11.05 );
        $product->set_weight( .2 );
        $product->save();

        $query = "
            query {
                product(id: \"{$product->get_id()}\") {
                    productId
                    name
                    slug
                    date
                    modified
                    status
                    featured
                    catalogVisibility
                    description
                    shortDescription
                    sku
                    price
                    regularPrice
                    salePrice
                    dateOnSaleFrom
                    dateOnSaleTo
                    totalSales
                    taxStatus
                    taxClass
                    manageStock
                    stockQuantity
                    stockStatus
                    backorders
                    soldIndividually
                    weight
                    length
                    width
                    height
                    reviewsAllowed
                    purchaseNote
                    menuOrder
                    virtual
                    downloadable
                    shippingClassId
                    downloads
                    downloadLimit
                    downloadExpiry
                    ratingCount
                    averageRating
                    reviewCount
                    upsell {
                        nodes {
                            id
                            name
                        }
                    }
                    crossSell {
                        nodes {
                            id
                            name
                        }
                    }
                    parent {
                        id
                        name
                    }
                    categories {
                        nodes {
                            id
                            name
                        }
                    }
                    tags {
                        nodes {
                            id
                            name
                        }
                    }
                    image {
                        id
                        src
                    }
                    galleryImages {
                        nodes {
                            id
                            src
                        }
                    }
                    attributes {
                        id
                        name
                        position
                        visible
                        variation
                        options
                    }
                    defaultAttributes {
                        id
                        name
                        option
                    }
                }
            }
        ";

        $actual = do_graphql_request( $query );

        $expected = [
            'data' => [
                'product' => [
                    'productId'         => $product->get_id(),
                    'name'              => $product->get_name(),
                    'slug'              => $product->get_slug(),
                    'date'              => $product->get_date_created(),
                    'modified'          => $product->get_date_modified(),
                    'status'            => $product->get_status(),
                    'featured'          => $product->get_featured(),
                    'catalogVisibility' => $product->get_catalog_visibility(),
                    'description'       => $product->get_description(),
                    'shortDescription'  => $product->get_short_description(),
                    'sku'               => $product->get_sku(),
                    'price'             => $product->get_price(),
                    'regularPrice'      => $product->get_regular_price(),
                    'salePrice'         => $product->get_sale_price(),
                    'dateOnSaleFrom'    => $product->get_date_on_sale_from(),
                    'dateOnSaleTo'      => $product->get_date_on_sale_to(),
                    'totalSales'        => $product->get_total_sales(),
                    'taxStatus'         => $product->get_tax_status(),
                    'taxClass'          => $product->get_tax_class(),
                    'manageStock'       => $product->get_manage_stock(),
                    'stockQuantity'     => $product->get_stock_quantity(),
                    'stockStatus'       => $product->get_stock_status(),
                    'backorders'        => $product->get_backorders(),
                    'soldIndividually'  => $product->get_sold_individually(),
                    'weight'            => $product->get_weight(),
                    'length'            => $product->get_length(),
                    'width'             => $product->get_width(),
                    'height'            => $product->get_height(),
                    'reviewsAllowed'    => $product->get_reviews_allowed(),
                    'purchaseNote'      => $product->get_purchase_note(),
                    'menuOrder'         => $product->get_menu_order(),
                    'virtual'           => $product->get_virtual(),
                    'downloadable'      => $product->get_downloadable(),
                    'shippingClassId'   => $product->get_shipping_class_id(),
                    'downloads'         => $product->get_downloads(),
                    'downloadLimit'     => $product->get_download_limit(),
                    'downloadExpiry'    => $product->get_download_expiry(),
                    'ratingCount'       => $product->get_rating_count(),
                    'averageRating'     => $product->get_average_rating(),
                    'reviewCount'       => $product->get_review_count(),
                ]
            ]
        ];

        /**
         * use --debug flag to view
         */
        \Codeception\Util\Debug::debug( [ 
            'actual'    => $actual,
            'expected'  => $expected,
        ] );

        $this->assertEquals( $expected, $actual );
    }

    public function testProductByQuery()
    {
        $product = new WC_Product();
        $product->set_name( 'Test Product' );
        $product->set_slug( 'test-product' );
        $product->set_description( 'lorem ipsum dolor' );
        $product->set_sku( 'wp-pennant' );
        $product->set_price( 11.05 );
        $product->set_weight( .2 );
        $product->save();

        $query = "
            query {
                productBy(slug: \"{$product->get_slug()}\") {
                    productId
                    name
                    slug
                    date
                    modified
                    status
                    featured
                    catalogVisibility
                    description
                    shortDescription
                    sku
                    price
                    regularPrice
                    salePrice
                    dateOnSaleFrom
                    dateOnSaleTo
                    totalSales
                    taxStatus
                    taxClass
                    manageStock
                    stockQuantity
                    stockStatus
                    backorders
                    soldIndividually
                    weight
                    length
                    width
                    height
                    reviewsAllowed
                    purchaseNote
                    menuOrder
                    virtual
                    downloadable
                    shippingClassId
                    downloads
                    downloadLimit
                    downloadExpiry
                    ratingCount
                    averageRating
                    reviewCount
                }
            }
        ";

        $actual = do_graphql_request( $query );

        $expected = [
            'data' => [
                'productBy' => [
                    'productId'         => $product->get_id(),
                    'name'              => $product->get_name(),
                    'slug'              => $product->get_slug(),
                    'date'              => $product->get_date_created(),
                    'modified'          => $product->get_date_modified(),
                    'status'            => $product->get_status(),
                    'featured'          => $product->get_featured(),
                    'catalogVisibility' => $product->get_catalog_visibility(),
                    'description'       => $product->get_description(),
                    'shortDescription'  => $product->get_short_description(),
                    'sku'               => $product->get_sku(),
                    'price'             => $product->get_price(),
                    'regularPrice'      => $product->get_regular_price(),
                    'salePrice'         => $product->get_sale_price(),
                    'dateOnSaleFrom'    => $product->get_date_on_sale_from(),
                    'dateOnSaleTo'      => $product->get_date_on_sale_to(),
                    'totalSales'        => $product->get_total_sales(),
                    'taxStatus'         => $product->get_tax_status(),
                    'taxClass'          => $product->get_tax_class(),
                    'manageStock'       => $product->get_manage_stock(),
                    'stockQuantity'     => $product->get_stock_quantity(),
                    'stockStatus'       => $product->get_stock_status(),
                    'backorders'        => $product->get_backorders(),
                    'soldIndividually'  => $product->get_sold_individually(),
                    'weight'            => $product->get_weight(),
                    'length'            => $product->get_length(),
                    'width'             => $product->get_width(),
                    'height'            => $product->get_height(),
                    'reviewsAllowed'    => $product->get_reviews_allowed(),
                    'purchaseNote'      => $product->get_purchase_note(),
                    'menuOrder'         => $product->get_menu_order(),
                    'virtual'           => $product->get_virtual(),
                    'downloadable'      => $product->get_downloadable(),
                    'shippingClassId'   => $product->get_shipping_class_id(),
                    'downloads'         => $product->get_downloads(),
                    'downloadLimit'     => $product->get_download_limit(),
                    'downloadExpiry'    => $product->get_download_expiry(),
                    'ratingCount'       => $product->get_rating_count(),
                    'averageRating'     => $product->get_average_rating(),
                    'reviewCount'       => $product->get_review_count(),
                ]
            ]
        ];

        /**
         * use --debug flag to view
         */
        \Codeception\Util\Debug::debug( [ 
            'actual'    => $actual,
            'expected'  => $expected,
        ] );

        $this->assertEquals( $expected, $actual );
    }

    public function testProductsQuery()
    {
        $product = new WC_Product();
        $product->set_name( 'Test Product' );
        $product->set_slug( 'test-product' );
        $product->set_description( 'lorem ipsum dolor' );
        $product->set_sku( 'wp-pennant' );
        $product->set_price( 11.05 );
        $product->set_weight( .2 );
        $product->save();

        $query = "
            query {
                products {
                    nodes {
                        productId
                        name
                        slug
                    }
                }
            }
        ";

        $actual = do_graphql_request( $query );

        $expected = [
            'data' => [
                'products' => [
                    'nodes' => [
                        [
                            'productId' => $product->get_id(),
                            'name'      => $product->get_name(),
                            'slug'      => $product->get_slug(),
                        ]
                    ]
                ]
            ] 
        ];


        /**
         * use --debug flag to view
         */
        \Codeception\Util\Debug::debug( [ 
            'actual'    => $actual,
            'expected'  => $expected,
        ] );

        $this->assertEquals( $expected, $actual );
    }

}