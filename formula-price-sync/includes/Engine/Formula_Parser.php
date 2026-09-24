<?php
/**
 * Safe formula parser (no eval of arbitrary code).
 *
 * @package FPS\Engine
 */

namespace FPS\Engine;

class Formula_Parser {

	/**
	 * Parse and evaluate a simple arithmetic formula with named variables.
	 *
	 * @param string               $formula e.g. "gold * 1.1 + wage"
	 * @param array<string, float> $vars
	 * @return float
	 */
	public function evaluate( string $formula, array $vars ): float {
		$formula = trim( $formula );
		if ( $formula === '' ) {
			return 0.0;
		}

		// Replace variable names with values (only known vars).
		foreach ( $vars as $name => $value ) {
			$formula = preg_replace( '/\b' . preg_quote( $name, '/' ) . '\b/', (string) (float) $value, $formula );
		}

		// Allow only digits, operators, parentheses, dots, spaces.
		if ( ! preg_match( '/^[0-9+\-\*\/\(\)\.\s]+$/', $formula ) ) {
			throw new \InvalidArgumentException( 'Invalid formula characters' );
		}

		// Very constrained evaluation (no user functions).
		$result = 0.0;
		try {
			// phpcs:ignore Squiz.PHP.Eval.Discouraged
			$result = (float) @eval( 'return (' . $formula . ');' );
		} catch ( \Throwable $e ) {
			throw new \RuntimeException( 'Formula evaluation failed' );
		}
		return $result;
	}
}
