<?php
/**
 * Action Scheduler integration for large catalog price updates.
 *
 * @package FPS\Queue
 */

namespace FPS\Queue;

use FPS\Engine\Calculator;
use FPS\Core\Logger;

class Action_Scheduler_Handler {

	const HOOK = 'fps_process_price_chunk';

	public static function init(): void {
		add_action( self::HOOK, array( __CLASS__, 'process_chunk' ), 10, 1 );
	}

	/**
	 * Schedule a chunk of product IDs for price recalculation.
	 *
	 * @param int[] $product_ids
	 */
	public static function schedule_chunk( array $product_ids ): void {
		if ( ! function_exists( 'as_enqueue_async_action' ) ) {
			return;
		}
		as_enqueue_async_action( self::HOOK, array( 'ids' => $product_ids ), 'fps' );
	}

	/**
	 * Process a chunk of products.
	 *
	 * @param array $args
	 */
	public static function process_chunk( $args ): void {
		$ids = isset( $args['ids'] ) && is_array( $args['ids'] ) ? $args['ids'] : array();
		$calc = new Calculator();
		foreach ( $ids as $id ) {
			$id = (int) $id;
			$result = $calc->calculate_for_product( $id );
			if ( $result->success ) {
				$calc->apply( $result );
			} else {
				Logger::error( 'Chunk update failed', array( 'product_id' => $id, 'msg' => $result->message ) );
			}
		}
	}
}
