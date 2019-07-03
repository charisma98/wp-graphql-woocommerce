<?php

class OrderMutationsTest extends \Codeception\TestCase\WPTestCase {

    public function setUp() {
        // before
        parent::setUp();

        $this->shop_manager = $this->factory->user->create( array( 'role' => 'shop_manager' ) );
        $this->customer     = $this->factory->user->create( array( 'role' => 'customer' ) );

        $this->order        = $this->getModule('\Helper\Wpunit')->order();
        $this->coupon       = $this->getModule('\Helper\Wpunit')->coupon();
        $this->product      = $this->getModule('\Helper\Wpunit')->product();
        $this->variation    = $this->getModule('\Helper\Wpunit')->product_variation();
        $this->cart         = $this->getModule('\Helper\Wpunit')->cart();
        $this->order->create();
    }

    public function tearDown() {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    private function createOrder( $input ) {
        $mutation = '
            mutation createOrder( $input: CreateOrderInput! ) {
                createOrder( input: $input ) {
                    clientMutationId
                    order {
                        id
                        orderId
                        currency
                        orderVersion
                        date
                        modified
                        status
                        discountTotal
                        discountTax
                        shippingTotal
                        shippingTax
                        cartTax
                        total
                        totalTax
                        subtotal
                        orderNumber
                        orderKey
                        createdVia
                        pricesIncludeTax
                        parent {
                            id
                        }
                        customer {
                            id
                        }
                        customerIpAddress
                        customerUserAgent
                        customerNote
                        billing {
                            firstName
                            lastName
                            company
                            address1
                            address2
                            city
                            state
                            postcode
                            country
                            email
                            phone
                        }
                        shipping {
                            firstName
                            lastName
                            company
                            address1
                            address2
                            city
                            state
                            postcode
                            country
                        }
                        paymentMethod
                        paymentMethodTitle
                        transactionId
                        dateCompleted
                        datePaid
                        cartHash
                        shippingAddressMapUrl
                        hasBillingAddress
                        hasShippingAddress
                        isDownloadPermitted
                        needsShippingAddress
                        hasDownloadableItem
                        downloadableItems {
                            downloadId
                        }
                        needsPayment
                        needsProcessing
                        couponLines {
                            nodes {
                                itemId
                                orderId
                                code
                                discount
                                discountTax
                                coupon {
                                    id
                                }
                            }
                        }
                        feeLines {
                            nodes {
                                itemId
                                orderId
                                amount
                                name
                                taxStatus
                                total
                                totalTax
                                taxClass
                            }
                        }
                        shippingLines {
                            nodes {
                                itemId
                                orderId
                                methodTitle
                                total
                                totalTax
                                taxClass
                            }
                        }
                        taxLines {
                            nodes {
                                rateCode
                                label
                                taxTotal
                                shippingTaxTotal
                                isCompound
                                taxRate {
                                    rateId
                                }
                            }
                        }
                        lineItems {
                            nodes {
                                productId
                                variationId
                                quantity
                                taxClass
                                subtotal
                                subtotalTax
                                total
                                totalTax
                                itemDownloads {
                                    downloadId
                                }
                                taxStatus
                                product {
                                    id
                                }
                                variation {
                                    id
                                }
                            }
                        }
                    }
                }
            }
        ';

        $actual = graphql(
            array(
                'query'          => $mutation,
                'operation_name' => 'createOrder',
                'variables'      => array( 'input' => $input  ),
            )
        );

        return $actual;
    }

    // tests
    public function testCreateOrderMutationAndArgs() {
        $product_id = $this->product->create_simple();
        $coupon     = new WC_Coupon(
            $this->coupon->create( array( 'product_ids' => array( $product_id ) ) )
        );

        $input      = array(
            'clientMutationId'   => 'someId',
			'customerId'         => $this->customer,
			'customerNote'       => 'Customer test note',
			// 'coupons'            => array(
            //     $coupon->get_code(),
            // ),
			'paymentMethod'      => 'bacs',
            'paymentMethodTitle' => 'Direct Bank Transfer',
            'isPaid'             => true,
			'billing'            => array(
                'firstName' => 'May',
                'lastName'  => 'Parker',
                'address1'  => '20 Ingram St',
                'city'      => 'New York City',
                'state'     => 'NY',
                'postcode'  => '12345',
                'country'   => 'US',
                'email'     => 'superfreak500@gmail.com',
                'phone'     => '555-555-1234',
            ),
			'shipping'           => array(
                'firstName' => 'May',
                'lastName'  => 'Parker',
                'address1'  => '20 Ingram St',
                'city'      => 'New York City',
                'state'     => 'NY',
                'postcode'  => '12345',
                'country'   => 'US',
            ),
			'lineItems'          => array(
                array(
                    'productId' => $product_id,
                    'quantity'  => 5,
                ),
            ),
            // 'shippingLines'      => array(
            //     array(
            //         'methodId'    => 'flat_rate_shipping',
            //         'methodTitle' => 'Flat Rate shipping',
            //         'total'       => '10',
            //     ),
            // ),
			// 'feeLines'           => array(
            //     array(
            //         'name'       => 'Some Fee',
            //         'taxStatus' => 'TAXABLE',
            //         'total'      => '100',
            //         'taxClass'  => 'STANDARD',
            //     ),
            // ),
			'metaData'           => array( 
                array( 
                    'key'   => 'test_key',
                    'value' => 'test value',
                ), 
            ),
			'isPaid'             => true,
        );

        /**
		 * Assertion One
		 * 
		 * User without necessary capabilities cannot create order an order.
		 */
		wp_set_current_user( $this->customer );
        $actual = $this->createOrder( $input );

        // use --debug flag to view.
        codecept_debug( $actual );

        $this->assertArrayHasKey('errors', $actual );

        /**
		 * Assertion Two
		 * 
		 * User without necessary capabilities cannot create order an order.
		 */
		wp_set_current_user( $this->shop_manager );
        $actual = $this->createOrder( $input );

        // use --debug flag to view.
        codecept_debug( $actual );

        $this->assertArrayHasKey('data', $actual );
        $this->assertArrayHasKey('createOrder', $actual['data'] );
        $this->assertArrayHasKey('order', $actual['data']['createOrder'] );
        $this->assertArrayHasKey('id', $actual['data']['createOrder']['order'] );
        $order = new \WC_Order( $actual['data']['createOrder']['order']['orderId'] );

        $expected = array(
            'data' => array(
                'createOrder' => array(
                    'clientMutationId' => 'someId',
                    'order'            => array_merge(
                        $this->order->print_query( $order->get_id() ),
                        array(
                            'couponLines'   => array(
                                'nodes' => array_reverse(
                                    array_map(
                                        function( $item ) {
                                            return array(
                                                'itemId'      => $item->get_id(),
                                                'orderId'     => $item->get_order_id(),
                                                'code'        => $item->get_code(),
                                                'discount'    => ! empty( $item->get_discount() ) ? $item->get_discount() : null,
                                                'discountTax' => ! empty( $item->get_discount_tax() ) ? $item->get_discount_tax() : null,
                                                'coupon'      => array(
                                                    'id' => Relay::toGlobalId( 'shop_coupon', \wc_get_coupon_id_by_code( $item->get_code() ) ),
                                                ),
                                            );
                                        },
                                        $order->get_items( 'coupon' )
                                    ) 
                                ),
                            ),
                            'feeLines'      => array(
                                'nodes' => array_reverse(
                                    array_map(
                                        function( $item ) {
                                            return array(
                                                'itemId'    => $item->get_id(),
                                                'orderId'   => $item->get_order_id(),
                                                'amount'    => $item->get_amount(),
                                                'name'      => $item->get_name(),
                                                'taxStatus' => strtoupper( $item->get_tax_status() ),
                                                'total'     => $item->get_total(),
                                                'totalTax'  => ! empty( $item->get_total_tax() ) ? $item->get_total_tax() : null,
                                                'taxClass'  => ! empty( $item->get_tax_class() ) 
                                                    ? WPEnumType::get_safe_name( $item->get_tax_class() )
                                                    : 'STANDARD',
                                            );
                                        },
                                        $order->get_items( 'fee' )
                                    )
                                ),
                            ),
                            'shippingLines' => array(
                                'nodes' => array_reverse(
                                    array_map(
                                        function( $item ) {
        
                                            return array(
                                                'itemId'         => $item->get_id(),
                                                'orderId'        => $item->get_order_id(),
                                                'methodTitle'    => $item->get_method_title(),
                                                'total'          => $item->get_total(),
                                                'totalTax'       => !empty( $item->get_total_tax() )
                                                    ? $item->get_total_tax()
                                                    : null,
                                                'taxClass'       => ! empty( $item->get_tax_class() )
                                                    ? $item->get_tax_class() === 'inherit'
                                                        ? WPEnumType::get_safe_name( 'inherit cart' )
                                                        : WPEnumType::get_safe_name( $item->get_tax_class() )
                                                    : 'STANDARD'
                                            );
                                        },
                                        $order->get_items( 'shipping' )
                                    )
                                ),
                            ),
                            'taxLines'      => array(
                                'nodes' => array_reverse(
                                    array_map(
                                        function( $item ) {
                                            return array(
                                                'rateCode'         => $item->get_rate_code(),
                                                'label'            => $item->get_label(),
                                                'taxTotal'         => $item->get_tax_total(),
                                                'shippingTaxTotal' => $item->get_shipping_tax_total(),
                                                'isCompound'       => $item->is_compound(),
                                                'taxRate'          => array( 'rateId' => $item->get_rate_id() ),
                                            );
                                        },
                                        $order->get_items( 'tax' )
                                    )
                                ),
                            ),
                            'lineItems'     => array(
                                'nodes' => array_values(
                                    array_map(
                                        function( $item ) {
                                            return array(
                                                'productId'     => $item->get_product_id(),
                                                'variationId'   => ! empty( $item->get_variation_id() )
                                                    ? $item->get_variation_id()
                                                    : null,
                                                'quantity'      => $item->get_quantity(),
                                                'taxClass'      => ! empty( $item->get_tax_class() )
                                                    ? strtoupper( $item->get_tax_class() )
                                                    : 'STANDARD',
                                                'subtotal'      => ! empty( $item->get_subtotal() ) ? $item->get_subtotal() : null,
                                                'subtotalTax'   => ! empty( $item->get_subtotal_tax() ) ? $item->get_subtotal() : null,
                                                'total'         => ! empty( $item->get_total() ) ? $item->get_total() : null,
                                                'totalTax'      => ! empty( $item->get_total_tax() ) ? $item->get_total_tax() : null,
                                                'itemDownloads' => null,
                                                'taxStatus'     => strtoupper( $item->get_tax_status() ),
                                                'product'       => array( 'id' => Relay::toGlobalId( 'product', $item->get_product_id() ) ),
                                                'variation'     => ! empty( $item->get_variation_id )
                                                    ? array( 'id' => Relay::toGlobalId( 'product_variation', $item->get_variation_id() ) )
                                                    : null,
                                            );
                                        },
                                        $order->get_items()
                                    )
                                ),
                            ),
                        )
                    )
                ),
            )
        );

        $this->assertEqualSets( $expected, $actual );
    }

}