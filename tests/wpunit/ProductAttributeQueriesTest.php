<?php

class ProductAttributeQueriesTest extends \Codeception\TestCase\WPTestCase {
    private $shop_manager;
    private $customer;
    private $helper;
    private $variation_helper;
    private $product_id;
    private $variation_ids;

    public function setUp() {
        parent::setUp();

        $this->shop_manager     = $this->factory->user->create( array( 'role' => 'shop_manager' ) );
        $this->customer         = $this->factory->user->create( array( 'role' => 'customer' ) );
        $this->helper           = $this->getModule('\Helper\Wpunit')->product();
        $this->variation_helper = $this->getModule('\Helper\Wpunit')->product_variation();
        $this->product_id       = $this->helper->create_variable();
        $this->variation_ids    = $this->variation_helper->create( $this->product_id )['variations'];

    }

    public function tearDown() {
        parent::tearDown();
    }

    // tests
    public function testProductAttributeQuery() {
        $query = '
            query attributeQuery( $id: ID! ) {
                product( id: $id ) {
                    id
                    attributes {
                        nodes {
                            attributeId
                            name
                            options
                            position
                            visible
                            variation
                        }
                    }
                }
            }
        ';

        $variables = array( 'id' => $this->helper->to_relay_id( $this->product_id ) );
        $actual    = $actual = do_graphql_request( $query, 'attributeQuery', $variables );
		$expected = array(
            'data' => array(
                'product' => array(
                    'id'         => $this->helper->to_relay_id( $this->product_id ),
                    'attributes' => $this->helper->print_attributes( $this->product_id ),
                ),
            ),
        );

        // use --debug flag to view.
		codecept_debug( $actual );

		$this->assertEqualSets( $expected, $actual );
    }

    public function testProductAttributeToProductConnectionQuery() {
        $query = '
            query attributeConnectionQuery( $size: [String!] ) {
                paSizes( where: { name: $size } ) {
                    nodes {
                        products {
                            nodes {
                                id
                            }
                        }
                    }
                }
            }
        ';

        $variables = array( 'size' => 'small' );
        $actual    = $actual = do_graphql_request( $query, 'attributeConnectionQuery', $variables );
		$expected = array(
            'data' => array(
                'paSizes' => array (
                    'nodes' => array(
                        array(
                            'products' => array(
                                'nodes' => array(
                                    array(
                                        'id' => $this->helper->to_relay_id( $this->product_id )
                                    )
                                )
                            )
                        )
                    )
                ),
            ),
        );

        // use --debug flag to view.
		codecept_debug( $actual );

		$this->assertEqualSets( $expected, $actual );
    }

    public function testProductAttributeToVariationConnectionQuery() {
        $query = '
            query attributeConnectionQuery( $size: [String!] ) {
                paSizes( where: { name: $size } ) {
                    nodes {
                        variations {
                            nodes {
                                id
                            }
                        }
                    }
                }
            }
        ';

        $variables = array( 'size' => 'small' );
        $actual    = $actual = do_graphql_request( $query, 'attributeConnectionQuery', $variables );
		$expected = array(
            'data' => array(
                'paSizes' => array (
                    'nodes' => array(
                        array(
                            'variations' => array(
                                'nodes' => array(
                                    $this->variation_helper->print_nodes(
                                        $this->variation_ids,
                                        array(
                                            'filter' => function( $id ) {
                                                $variation = new \WC_Product_Variation( $id );
                                                $small_attribute = array_filter(
                                                    $variation->get_attributes(),
                                                    function( $attribute ) {
                                                        return 'small' === $attribute;
                                                    }
                                                );
                                                return ! empty( $small_attribute );
                                            }
                                        )
                                    )
                                )
                            )
                        )
                    )
                ),
            ),
        );

        // use --debug flag to view.
		codecept_debug( $actual );

		$this->assertEqualSets( $expected, $actual );
    }
}