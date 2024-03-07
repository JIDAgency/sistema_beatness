<?php defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/vendor/autoload.php';
        require  APPPATH . "third_party/vendor/stripe-php/init.php";

class Stripe_lib {
    private $stripe;

    public function __construct(){      
		//set api key
		$stripe_keys = array(

			/** Produccion Beatness by JID */
			"secret_key"      => "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",
			"publishable_key" => "pk_live_51MEydpCIMQXIudu9sjWlCJP7TgOiSq3Kbwkpd3DDzkU9Luglz4seajt8Zbs3WJvupj6c5alVJUPVcr8MlRBbPlam0084RYwwAi"

			/** SandBox Sensoria by JID */
			//"secret_key"      => "sk_test_51Lb84RHdipZkXjohCE21ppE9T44QVzV8FanMVBHTVgQDXESMl7hTgJDtId0cxu0syyu03iPFi2NSfZLrZL7yiTpB00ixzfQqpT",
			//"publishable_key" => "pk_test_51Lb84RHdipZkXjohT3Mbi0ipxStkRMJHsJ57xM7cLuAKHWC4B8CPSMR9BfYw3YvOwhOs49OfrAmiWVs3IBHndbPr00OAn4E5yK"
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
		
			} catch(\Stripe\Exception\CardException $e) {
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

	public function obtener_errores() {
		# code...
	}
}
