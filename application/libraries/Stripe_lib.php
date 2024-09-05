<?php defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/vendor/autoload.php';
require  APPPATH . "third_party/vendor/stripe-php/init.php";

class Stripe_lib
{
	private $stripe;
	private $error_details;

	// ===> IMPORTANTE: Cambiar al configurar
	private $motor_pago_por_defecto = 'stripe_produccion_polanco';

	public function __construct($params = array())
	{
		$sucursal_motor_pago = isset($params['sucursal_motor_pago']) ? $params['sucursal_motor_pago'] : $this->motor_pago_por_defecto;

		$stripe_keys = $this->obtener_stripe_keys_por_sucursal($sucursal_motor_pago);

		if (!$stripe_keys) {
			throw new Exception('Las claves de Stripe no están configuradas correctamente para esta sucursal.');
		}

		$this->stripe = new \Stripe\StripeClient($stripe_keys['secret_key']);
	}

	private function obtener_stripe_keys_por_sucursal($sucursal_motor_pago)
	{
		$stripe_keys = array(
			'stripe_produccion_polanco' => array(
				"secret_key"      	=> "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",
				"publishable_key" 	=> "pk_live_51OtxwKHKnadmFYpOGzncEgc7m6VjjxoigX0g0CROID5tbnE6p2oWMbz6AKn5IVO7YAVAejJVUqnwEBkfGwSI9K8p00Ijdh5Mcw"
			),
			'stripe_sandbox_polanco' => array(
				'secret_key' 		=> 'sk_test_51OtxwKHKnadmFYpOSrh5jjOnqVfOoMJWqrTjJMQ5RcmN93BXwDcIW1Sgqpp153bdMnVI6S6I9mAguInNDpryYXog00JjEIAqXZ',
				'publishable_key' 	=> 'pk_test_51OtxwKHKnadmFYpOMWZZNJ49B4AcsXoBh9Z9pQhvXa4Hqdbhb42GiOPt2ReM6sBcKvi3JXp01j2PCdcDoW2idapV00pJ02cLtj'
			),
			'stripe_produccion_puebla' => array(
				"secret_key"      	=> "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",
				"publishable_key" 	=> "pk_live_51Pq28sAZBlDqg0Npf5DCBBTP037tO0kPQMq7EjtnFLp8qMLHT9B2LWhW55sRG5YkZceUSO8XjmNvPYygCpTfGly800gTIV2SWS"
			),
			'stripe_sandbox_puebla' => array(
				'secret_key' 		=> 'sk_test_51Pq28sAZBlDqg0NpBdgKNQa0SBRY0nMChWGfxzJE03t7z7jTUNZkcEc0jkKefhtbaSEHui9NzqELY04wr124XnrN003ZW6qx4O',
				'publishable_key' 	=> 'pk_test_51Pq28sAZBlDqg0NpPHsTenPHivNvE8M7bAZ0Dj0edPHDwq6d1lgoWBk9MNmslgQnJhj6DrtfpNh15x9Ye1BcYNVS00xiP7xO3v'
			)
		);
		// '','','stripe_sandbox_polanco','stripe_sandbox_puebla'
		return isset($stripe_keys[$sucursal_motor_pago]) ? $stripe_keys[$sucursal_motor_pago] : $stripe_keys[$this->motor_pago_por_defecto];
	}

	public function cargo(
		$amount,
		$description,
		$order_id,
		$item_id,
		$receipt_email,
		$token
	) {
		if ($token) {

			try {

				$cargo = $this->stripe->charges->create([
					'amount' => $amount,
					'currency' => 'mxn',
					'description' => $description,
					'metadata' => array(
						"order_id" => $order_id,
						'item_id' => $item_id,
					),
					'receipt_email' => $receipt_email,
					'source' => $token,
				]);
			} catch (\Stripe\Exception\CardException $e) {
				// Since it's a decline, \Stripe\Exception\CardException will be caught
				//echo 'Status is:' . $e->getHttpStatus() . '\n';
				//echo 'Type is:' . $e->getError()->type . '\n';
				//echo 'Code is:' . $e->getError()->code . '\n';
				// param is '' in this case
				//echo 'Param is:' . $e->getError()->param . '\n';
				//echo 'Message is:' . $e->getError()->message . '\n';
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Stripe\Exception\RateLimitException $e) {
				// Too many requests made to the API too quickly
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Stripe\Exception\InvalidRequestException $e) {
				// Invalid parameters were supplied to Stripe's API
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Stripe\Exception\AuthenticationException $e) {
				// Authentication with Stripe's API failed
				// (maybe you changed API keys recently)
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Stripe\Exception\ApiConnectionException $e) {
				// Network communication with Stripe failed
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Stripe\Exception\ApiErrorException $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (\Exception $e) {
				// Something else happened, completely unrelated to Stripe
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			} catch (Exception $e) {
				// Ocurrió un error al intentar realizar el cargo
				return array(
					'error' => true,
					'mensaje' => $e->getMessage(),
				);
			}

			return array(
				'error' => false,
				'mensaje' => 'El cargo se realizó correctamente',
			);
		}

		return false;
	}

	public function obtener_errores()
	{
		# code...
	}
}
