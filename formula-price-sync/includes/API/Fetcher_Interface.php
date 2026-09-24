<?php
/**
 * Rate fetcher interface.
 *
 * @package FPS\API
 */

namespace FPS\API;

interface Fetcher_Interface {
	/**
	 * Fetch current rates.
	 *
	 * @return array<string, float> Map of symbol => rate.
	 */
	public function fetch(): array;

	/**
	 * Provider identifier.
	 *
	 * @return string
	 */
	public function get_id(): string;
}
