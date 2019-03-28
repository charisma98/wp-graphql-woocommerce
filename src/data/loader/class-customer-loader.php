<?php
/**
 * Loader - Customer_Loader
 *
 * Loads Customer Model
 *
 * @package WPGraphQL\Extensions\WooCommerce\Data\Loader
 * @since 0.0.1
 */

namespace WPGraphQL\Extensions\WooCommerce\Data\Loader;

use WPGraphQL\Data\Loader\AbstractDataLoader;
use WPGraphQL\Extensions\WooCommerce\Model\Customer;

/**
 * Class Customer_Loader
 */
class Customer_Loader extends AbstractDataLoader {
	/**
	 * Processes given array keys and loads Model
	 *
	 * @param array $keys - array of WP User IDs.
	 *
	 * @return array
	 */
	public function loadKeys( array $keys ) {
		if ( empty( $keys ) ) {
			return $keys;
		}
		$all_customers = array();

		/**
		 * Prepare the args for the query. We're provided a specific
		 * set of IDs, so we want to query as efficiently as possible with
		 * as little overhead as possible. We don't want to return post counts,
		 * we don't want to include sticky posts, and we want to limit the query
		 * to the count of the keys provided. The query must also return results
		 * in the same order the keys were provided in.
		 */
		$args = array(
			'include'     => $keys,
			'number'      => count( $keys ),
			'orderby'     => 'include',
			'count_total' => false,
			'fields'      => 'all_with_meta',
		);

		/**
		 * Query for the users and get the results
		 */
		$query     = new \WP_User_Query( $args );
		$customers = $query->get_results();

		/**
		 * If no users are returned, return an empty array
		 */
		if ( empty( $customers ) || ! is_array( $customers ) ) {
			return array();
		}

		foreach ( $keys as $key ) {
			$customer                       = get_user_by( 'id', $key );
			$all_customers[ $customer->ID ] = new Customer( $customer );
		}
		return $all_customers;
	}
}
