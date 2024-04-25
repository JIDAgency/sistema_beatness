<?php defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/vendor/autoload.php';
require  APPPATH . "third_party/vendor/stripe-php/init.php";

class Stripe_lib
{
	private $stripe;

	public function __construct()
	{
		$stripe_keys = array(
			// Stripe Keys de PRODUCCIÓN
			"secret_key"      => "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",
			"publishable_key" => "pk_live_51OtxwKHKnadmFYpOGzncEgc7m6VjjxoigX0g0CROID5tbnE6p2oWMbz6AKn5IVO7YAVAejJVUqnwEBkfGwSI9K8p00Ijdh5Mcw"

			// Stripe Keys de SANDBOX
			// "secret_key"      => "sk_test_51OtxwKHKnadmFYpOSrh5jjOnqVfOoMJWqrTjJMQ5RcmN93BXwDcIW1Sgqpp153bdMnVI6S6I9mAguInNDpryYXog00JjEIAqXZ",
			// "publishable_key" => "pk_test_51OtxwKHKnadmFYpOMWZZNJ49B4AcsXoBh9Z9pQhvXa4Hqdbhb42GiOPt2ReM6sBcKvi3JXp01j2PCdcDoW2idapV00pJ02cLtj"
		);

		$this->stripe = new \Stripe\StripeClient($stripe_keys['secret_key']);
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
