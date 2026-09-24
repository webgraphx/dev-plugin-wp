<?php
/**
 * Notification integrations (Telegram / email / SMS hooks).
 *
 * @package FPS\Integrations
 */

namespace FPS\Integrations;

class Notifier {

	public static function init(): void {
		// Hook into price update events if needed.
	}

	public static function send( string $channel, string $message, array $context = array() ): bool {
		switch ( $channel ) {
			case 'telegram':
				return self::telegram( $message );
			case 'email':
				return self::email( $message );
			default:
				return false;
		}
	}

	private static function telegram( string $message ): bool {
		$token = get_option( 'fps_telegram_bot_token', '' );
		$chat  = get_option( 'fps_telegram_chat_id', '' );
		if ( ! $token || ! $chat ) {
			return false;
		}
		$url = "https://api.telegram.org/bot{$token}/sendMessage";
		$response = wp_remote_post( $url, array(
			'body' => array(
				'chat_id' => $chat,
				'text'    => $message,
			),
			'timeout' => 15,
		) );
		return ! is_wp_error( $response );
	}

	private static function email( string $message ): bool {
		$to = get_option( 'admin_email' );
		return (bool) wp_mail( $to, 'FPS Notification', $message );
	}
}
