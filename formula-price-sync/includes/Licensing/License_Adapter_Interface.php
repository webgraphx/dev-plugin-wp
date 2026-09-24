<?php
/**
 * License adapter interface.
 *
 * @package FPS\Licensing
 */

namespace FPS\Licensing;

interface License_Adapter_Interface {
	public function is_valid(): bool;
	public function get_status(): string;
	public function activate( string $key ): bool;
}
