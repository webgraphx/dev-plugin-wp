<?php
/**
 * Value object for a single product price update result.
 *
 * @package FPS\Engine
 */

namespace FPS\Engine;

class Product_Update_Result {

	public int $product_id;
	public bool $success;
	public ?float $old_price;
	public ?float $new_price;
	public string $message;

	public function __construct( int $product_id, bool $success, ?float $old_price = null, ?float $new_price = null, string $message = '' ) {
		$this->product_id = $product_id;
		$this->success    = $success;
		$this->old_price  = $old_price;
		$this->new_price  = $new_price;
		$this->message    = $message;
	}
}
