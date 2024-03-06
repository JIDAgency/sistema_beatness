<?php defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'third_party/vendor/openpay/sdk/Openpay.php';

class Openpagos
{
    private $openpay;

    private $comprador_nombre; // Obligatorio
    private $comprador_apellidos;
    private $comprador_correo; // Obligatorio
    private $comprador_telefono;

    public function __construct()
    {
        $this->load->config('openpagos');
        
        $this->openpay = Openpay::getInstance($this->config->item('comercio_id'), $this->config->item('llave_privada'));

        Openpay::setProductionMode($this->config->item('establecer_modo_produccion'));

    }

    /**
     * Función que se encarga de poblar los datos del comprador
     *
     * @param string $comprador_nombre
     * @param string $comprador_correo
     * @param string $comprador_apellidos
     * @param string $comprador_telefono
     * @return void
     */
    public function cargar_datos_comprador($comprador_nombre, $comprador_correo, $comprador_apellidos = null, $comprador_telefono = null)
    {
        $this->comprador_nombre = $comprador_nombre;
        $this->comprador_correo = $comprador_correo;
        $this->comprador_apellidos = $comprador_apellidos;
        $this->comprador_telefono = $comprador_telefono;

    }

    /** Métodos del sistema de suscripciones [Inicio]*/

        /** Administración de clientes en OpenPay [Inicio] */
            /**
             * @param string $external_id
             * @param string $name
             * @param string $last_name
             * @param string $email
             * @param string $phone_number
             * @return array
             */
            public function crear_un_nuevo_cliente_en_openpay($external_id, $name, $last_name, $email, $phone_number)
            {
                try {
                    $customerData = array(
                        'external_id' => $external_id,
                        'name' => $name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'requires_account' => false,
                    );
        
                    $customer = $this->openpay->customers->add($customerData);

                    return $customer;

                } catch (Exception $e) {
                    return 'ERROR: '.$e->getMessage();
                }
                
            }

            public function obtener_un_cliente_existente_en_openpay($openpay_cliente_id)
            {
                try {
                    $customer = $this->openpay->customers->get($openpay_cliente_id);

                    return $customer;
                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return array(
                        'error' => true,
                        'mensaje' => $e->getMessage(),
                    );
                }
            }

            public function eliminar_un_cliente_en_openpay($openpay_cliente_id)
            {
                $customer = $this->openpay->customers->get($openpay_cliente_id);
                $customer->delete();

                return TRUE;
            }

        /** Administración de clientes en OpenPay [Fin] */

        /** Administración de tarjetas de clientes en OpenPay [Inicio] */
            public function crear_una_tarjeta_de_cliente_en_openpay($openpay_cliente_id, $holder_name, $card_number, $cvv2, $expiration_month, $expiration_year)
            {
                try {
                    $cardDataRequest = array(
                        'holder_name' => $holder_name,
                        'card_number' => $card_number,
                        'cvv2' => $cvv2,
                        'expiration_month' => $expiration_month,
                        'expiration_year' => $expiration_year,
                    );
                    
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $card = $customer->cards->add($cardDataRequest);

                    return $card;

                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return array(
                        'error' => true,
                        'mensaje' => $e->getMessage(),
                    );
                }
            }

            public function crear_una_tarjeta_con_token_de_cliente_en_openpay($openpay_cliente_id, $token_id, $device_session_id)
            {
                try {
                    $cardDataRequest = array(
                        'token_id' => $token_id,
                        'device_session_id' => $device_session_id
                    );
                    
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $card = $customer->cards->add($cardDataRequest);

                    return $card;

                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return 'ERROR: '.$e->getMessage();
                }
            }


            public function eliminar_una_tarjeta_en_openpay($openpay_cliente_id, $openpay_tarjeta_id)
            {
                try {

                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $card = $customer->cards->get($openpay_tarjeta_id);
                    $card->delete();

                    return true;

                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return array(
                        'error' => true,
                        'mensaje' => $e->getMessage(),
                    );
                }
            }

        /** Administración de tarjetas de clientes en OpenPay [Fin] */

        /** Administración de suscripciones en OpenPay [Inicio] */

            public function obtener_una_suscripcion_en_openpay($openpay_cliente_id, $openpay_suscripcion_id)
            {
                try {
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $subscription = $customer->subscriptions->get($openpay_suscripcion_id);

                    return $subscription;
                    
                } catch (Exception $e) {
                    return 'ERROR: '.$e->getMessage();
                }

            }

            public function crear_una_nueva_suscripcion_mensual_sin_prueba_en_openpay($openpay_cliente_id, $openpay_card_id, $openpay_plan_id)
            {
                try {
                    $subscriptionDataRequest = array(
                        "trial_end_date" => date('Y-m-d'),
                        'plan_id' => $openpay_plan_id,
                        'card_id' => $openpay_card_id
                    );
                    
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $subscription = $customer->subscriptions->add($subscriptionDataRequest);

                    return $subscription;
                    
                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return 'ERROR: '.$e->getMessage();
                }
                
            }

            public function cancelar_suscripcion_en_openpay($openpay_cliente_id, $openpay_suscripcion_id)
            {
                try {
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $subscription = $customer->subscriptions->get($openpay_suscripcion_id);
                    $subscription->delete();

                    return true;
                    
                } catch (Exception $e) {
                    return 'ERROR: '.$e->getMessage();
                }

            }

            public function crear_una_nueva_suscripcion_en_openpay($openpay_plan_id, $openpay_card_id, $openpay_cliente_id)
            {
                try {
                    $subscriptionDataRequest = array(
                        "trial_end_date" => date('Y-m-d', strtotime('+7 days')),
                        'plan_id' => $openpay_plan_id,
                        'card_id' => $openpay_card_id);
                    
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $subscription = $customer->subscriptions->add($subscriptionDataRequest);

                    return $subscription;
                    
                } catch (Exception $e) {
                    /**
                     * Falta desarrollar la traducción de los mensajes de error de “Almacenamiento”.
                     * https://www.openpay.mx/docs/api/#c-digos-de-error
                     */
                    return 'ERROR: '.$e->getMessage();
                }
                
            }

            public function actualizar_una_suscripcion($openpay_tarjeta_id, $openpay_suscripcion_id, $openpay_cliente_id)
            {
                try {
                    $customer = $this->openpay->customers->get($openpay_cliente_id);
                    $subscription = $customer->subscriptions->get($openpay_suscripcion_id);

                    $subscription->source_id = $openpay_tarjeta_id;

                    return $subscription->save();
                    //return $subscription;

                } catch (Exception $e) {
                    return 'ERROR: '.$e->getMessage();
                }

                
            }
        /** Administración de suscripciones en OpenPay [Fin] */

    /** Métodos del sistema de suscripciones [Fin]*/

    /** */

        /**
         * Función que realiza el cargo con tarjeta de débito o crédito; utiliza el método 'card' (este método es el requerido cuando se hace el cargo
         *  usando algún tipo de tarjeta) y espera la información del cargo
         *
         * @param string $fuente_id
         * @param string $cantidad
         * @param string $descripcion
         * @param string $dispositivo_id
         * @return array
         */
        public function aplicar_cargo_con_tarjeta_guardada($openpay_cliente_id, $fuente_id, $cantidad, $descripcion, $dispositivo_id)
        {
            try {

                $customer = $this->openpay->customers->get($openpay_cliente_id);
                $customer->charges->create($this->_obtener_arreglo_para_cargo_con_tarjeta_guardada('card', $fuente_id, $cantidad, $descripcion, $dispositivo_id));
                
                log_message('debug', 'El cargo se realizó correctamente');

                return array(
                    'error' => false,
                    'mensaje' => 'El cargo se realizó correctamente',
                );

            } catch (OpenpayApiTransactionError $e) {
                log_message('error', 'ERROR en la transacción: ' . $e->getMessage() .
                    ' [error code: ' . $e->getErrorCode() .
                    ', error category: ' . $e->getCategory() .
                    ', HTTP code: ' . $e->getHttpCode() .
                    ', request ID: ' . $e->getRequestId() . ']');
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
                );

            } catch (OpenpayApiRequestError $e) {
                log_message('error', 'ERROR en la solicitud: ' . $e->getMessage() .
                    ' [error code: ' . $e->getErrorCode() .
                    ', error category: ' . $e->getCategory() .
                    ', HTTP code: ' . $e->getHttpCode() .
                    ', request ID: ' . $e->getRequestId() . ']');
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
                );

            } catch (OpenpayApiConnectionError $e) {
                log_message('error', 'ERROR mientras se realizaba la conexión a la API: ' . $e->getMessage(), 0);
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
                );

            } catch (OpenpayApiAuthError $e) {
                log_message('error', 'ERROR en la autenticación: ' . $e->getMessage());
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
                );

            } catch (OpenpayApiError $e) {
                log_message('error', 'ERROR en la API: ' . $e->getMessage());
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
                );

            } catch (Exception $e) {
                log_message('error', 'Error en el script: ' . $e->getMessage());
                return array(
                    'error' => true,
                    'mensaje' => $this->_obtener_mensaje_error_por_codigo(),
                );

            }

        }

        /**
         * Función que valida que los argumentos recibidos sean correctos de acuerdo a la especificación de
         * la API de Openpay; y prepara el arreglo/objeto necesario para realizar un cargo
         *
         * @param string $metodo
         * @param string $fuente_id
         * @param string $cantidad
         * @param string $descripcion
         * @param string $dispositivo_id
         * @return array
         */
        private function _obtener_arreglo_para_cargo_con_tarjeta_guardada($metodo, $fuente_id, $cantidad, $descripcion, $dispositivo_id)
        {
            if (!$metodo) {
                throw new Exception('El método es requerido');
            }

            if (!$fuente_id || strlen($fuente_id) > 45) {
                throw new Exception('La fuente id (source_id) es requerida y no puede ser mayor a 45 caracteres');
            }

            if (!$cantidad || !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $cantidad)) {
                throw new Exception('La cantidad es requerida y no debe tener más de dos dígitos decimales');
            }

            $cantidad = floatval($cantidad);

            if ($cantidad == 0) {
                throw new Exception('La cantidad debe ser mayor a 0');
            }

            if (!$descripcion || strlen($descripcion) > 250) {
                throw new Exception('La descripción es requerdida y esta no puede ser mayor a 250 caracteres');
            }

            if (!$dispositivo_id || strlen($dispositivo_id) > 255) {
                throw new Exception('El identificador del dispositivo es requerido y debe tener una longitud menor o igual a 255 caracteres');
            }

            if (!$this->comprador_nombre || strlen($this->comprador_nombre) > 100) {
                throw new Exception('El nombre del comprador es requerido y debe tener una longitud menor o igual a 100 caracteres. Por favor verifique haber utilizado el método "cargar_datos_comprador"');
            }

            if (!$this->comprador_correo || strlen($this->comprador_correo) > 100) {
                throw new Exception('El correo del comprador es requerido y debe tener una longitud menor o igual a 100 caracteres. Por favor verifique haber utilizado el método "cargar_datos_comprador"');
            }

            if ($this->comprador_apellidos && strlen($this->comprador_apellidos) > 100) {
                throw new Exception('Los apellidos del comprador deben tener una longitud menor o igual a 100 caracteres');
            }

            if ($this->comprador_telefono && strlen($this->comprador_telefono) > 100) {
                throw new Exception('El télefono del comprador debe tener una longitud menor o igual a 100 caracteres');
            }

            $cantidad = round($cantidad, 2);
            $cantidad = strval($cantidad);

            return array(
                'method' => $metodo,
                'source_id' => $fuente_id,
                'amount' => $cantidad,
                'currency' => 'MXN',
                'description' => $descripcion,
                'device_session_id' => $dispositivo_id,
            );

        }
    /** */
    
    /**
     * Función que realiza el cargo con tarjeta de débito o crédito; utiliza el método 'card' (este método es el requerido cuando se hace el cargo
     *  usando algún tipo de tarjeta) y espera la información del cargo
     *
     * @param string $fuente_id
     * @param string $cantidad
     * @param string $descripcion
     * @param string $dispositivo_id
     * @return array
     */
    public function aplicar_cargo_con_tarjeta($fuente_id, $cantidad, $descripcion, $dispositivo_id)
    {
        try {

            $this->openpay->charges->create($this->_obtener_arreglo_para_cargo('card', $fuente_id, $cantidad, $descripcion, $dispositivo_id));
            
            log_message('debug', 'El cargo se realizó correctamente');

            return array(
                'error' => false,
                'mensaje' => 'El cargo se realizó correctamente',
            );

        } catch (OpenpayApiTransactionError $e) {
            log_message('error', 'ERROR en la transacción: ' . $e->getMessage() .
                ' [error code: ' . $e->getErrorCode() .
                ', error category: ' . $e->getCategory() .
                ', HTTP code: ' . $e->getHttpCode() .
                ', request ID: ' . $e->getRequestId() . ']');
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
            );

        } catch (OpenpayApiRequestError $e) {
            log_message('error', 'ERROR en la solicitud: ' . $e->getMessage() .
                ' [error code: ' . $e->getErrorCode() .
                ', error category: ' . $e->getCategory() .
                ', HTTP code: ' . $e->getHttpCode() .
                ', request ID: ' . $e->getRequestId() . ']');
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
            );

        } catch (OpenpayApiConnectionError $e) {
            log_message('error', 'ERROR mientras se realizaba la conexión a la API: ' . $e->getMessage(), 0);
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
            );

        } catch (OpenpayApiAuthError $e) {
            log_message('error', 'ERROR en la autenticación: ' . $e->getMessage());
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
            );

        } catch (OpenpayApiError $e) {
            log_message('error', 'ERROR en la API: ' . $e->getMessage());
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo($e->getErrorCode()),
            );

        } catch (Exception $e) {
            log_message('error', 'Error en el script: ' . $e->getMessage());
            return array(
                'error' => true,
                'mensaje' => $this->_obtener_mensaje_error_por_codigo(),
            );

        }

    }

    /**
     * Función que valida que los argumentos recibidos sean correctos de acuerdo a la especificación de
     * la API de Openpay; y prepara el arreglo/objeto necesario para realizar un cargo
     *
     * @param string $metodo
     * @param string $fuente_id
     * @param string $cantidad
     * @param string $descripcion
     * @param string $dispositivo_id
     * @return array
     */
    private function _obtener_arreglo_para_cargo($metodo, $fuente_id, $cantidad, $descripcion, $dispositivo_id)
    {
        if (!$metodo) {
            throw new Exception('El método es requerido');
        }

        if (!$fuente_id || strlen($fuente_id) > 45) {
            throw new Exception('La fuente id (source_id) es requerida y no puede ser mayor a 45 caracteres');
        }

        if (!$cantidad || !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $cantidad)) {
            throw new Exception('La cantidad es requerida y no debe tener más de dos dígitos decimales');
        }

        $cantidad = floatval($cantidad);

        if ($cantidad == 0) {
            throw new Exception('La cantidad debe ser mayor a 0');
        }

        if (!$descripcion || strlen($descripcion) > 250) {
            throw new Exception('La descripción es requerdida y esta no puede ser mayor a 250 caracteres');
        }

        if (!$dispositivo_id || strlen($dispositivo_id) > 255) {
            throw new Exception('El identificador del dispositivo es requerido y debe tener una longitud menor o igual a 255 caracteres');
        }

        if (!$this->comprador_nombre || strlen($this->comprador_nombre) > 100) {
            throw new Exception('El nombre del comprador es requerido y debe tener una longitud menor o igual a 100 caracteres. Por favor verifique haber utilizado el método "cargar_datos_comprador"');
        }

        if (!$this->comprador_correo || strlen($this->comprador_correo) > 100) {
            throw new Exception('El correo del comprador es requerido y debe tener una longitud menor o igual a 100 caracteres. Por favor verifique haber utilizado el método "cargar_datos_comprador"');
        }

        if ($this->comprador_apellidos && strlen($this->comprador_apellidos) > 100) {
            throw new Exception('Los apellidos del comprador deben tener una longitud menor o igual a 100 caracteres');
        }

        if ($this->comprador_telefono && strlen($this->comprador_telefono) > 100) {
            throw new Exception('El télefono del comprador debe tener una longitud menor o igual a 100 caracteres');
        }

        $cantidad = round($cantidad, 2);
        $cantidad = strval($cantidad);
        
        return array(
            'method' => $metodo,
            'source_id' => $fuente_id,
            'amount' => $cantidad,
            'currency' => 'MXN',
            'description' => $descripcion,
            'device_session_id' => $dispositivo_id,
            'customer' => array(
                'name' => trim($this->comprador_nombre),
                'last_name' => is_null($this->comprador_apellidos) ? 'N/D' : trim($this->comprador_apellidos),
                'phone_number' => is_null($this->comprador_telefono) ? 'N/D' : trim($this->comprador_telefono),
                'email' => trim($this->comprador_correo),
            ),
        );

    }

    /**
     * Función que con base en el código de error devuelto por el servicio de openpay devuelve un mensaje
     * de error en español (el mensaje de error devuelto por defecto está en inglés); sólo devuelve el mensaje
     * cuando los errores son debidos a problemas con las tarjetas, dado que son errores que el usuario
     * final puede entender, el resto de los errores son más específicos y el usuario final no debería 
     * poder verlos
     *
     * @param integer $codigo_error
     * @return string
     */
    private function _obtener_mensaje_error_por_codigo($codigo_error = 0)
    {
        $mensaje = 'Ha ocurrido un error al intentar realizar el cargo, por favor inténtelo más tarde.';

        switch ($codigo_error) {
            case 3001:
                $mensaje = 'La tarjeta fue declinada.';
                break;
            case 3002:
                $mensaje = 'La tarjeta ha expirado.';
                break;
            case 3003:
                $mensaje = 'La tarjeta no tiene fondos suficientes.';
                break;
            case 3004:
                $mensaje = 'La tarjeta ha sido identificada como una tarjeta robada.';
                break;
            case 3005:
                $mensaje = 'La tarjeta ha sido rechazada por el sistema antifraudes.';
                break;
            case 3006:
                $mensaje = 'La operación no esta permitida para este cliente o esta transacción.';
                break;
            case 3007:
                $mensaje = 'Deprecado. La tarjeta fue declinada.';
                break;
            case 3008:
                $mensaje = 'La tarjeta no es soportada en transacciones en línea.';
                break;
            case 3009:
                $mensaje = 'La tarjeta fue reportada como perdida.';
                break;
            case 3010:
                $mensaje = 'El banco ha restringido la tarjeta.';
                break;
            case 3011:
                $mensaje = 'El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.';
                break;
            case 3012:
                $mensaje = 'Se requiere solicitar al banco autorización para realizar este pago.';
                break;
        }

        return $mensaje;
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }
}
