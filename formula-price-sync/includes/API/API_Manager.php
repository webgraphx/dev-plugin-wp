<?php
/**
 * API Manager – coordinates rate providers, circuit breaker and snapshot store.
 *
 * @package FPS\API
 */

namespace FPS\API;

use FPS\API\Providers\Manual;
use FPS\API\Providers\Navasan;
use FPS\API\Providers\Nobitex;
use FPS\API\Providers\TGJU;

class API_Manager {

	/** @var array<string, Fetcher_Interface> */
	private $providers = array();

	/** @var Circuit_Breaker */
	private $breaker;

	/** @var Rate_Snapshot_Store */
	private $store;

	public function __construct() {
		$this->breaker = new Circuit_Breaker();
		$this->store   = new Rate_Snapshot_Store();
		$this->register_providers();
	}

	private function register_providers(): void {
		$this->providers['manual']  = new Manual();
		$this->providers['tgju']    = new TGJU();
		$this->providers['navasan'] = new Navasan();
		$this->providers['nobitex'] = new Nobitex();
	}

	/**
	 * Fetch rates from active providers with circuit-breaker protection.
	 *
	 * @return array<string, float>
	 */
	public function fetch_all(): array {
		$merged = array();
		foreach ( $this->providers as $id => $fetcher ) {
			if ( ! $this->breaker->is_available( $id ) ) {
				continue;
			}
			try {
				$rates = $fetcher->fetch();
				if ( is_array( $rates ) && ! empty( $rates ) ) {
					$merged = array_merge( $merged, $rates );
					$this->breaker->record_success( $id );
					$this->store->save_snapshot( $id, $rates );
				}
			} catch ( \Throwable $e ) {
				$this->breaker->record_failure( $id );
			}
		}
		return $merged;
	}

	/**
	 * Get last known good rates (from store).
	 *
	 * @return array<string, float>
	 */
	public function get_cached_rates(): array {
		return $this->store->get_latest();
	}
}
