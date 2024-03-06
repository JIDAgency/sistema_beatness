<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Configuración de Openpay
| -------------------------------------------------------------------
|
|  comercio_id                      string   El id de tu comercio
|  llave_privada                    string   Tu llave privada (Nunca usar del lado del cliente)
|  establecer_modo_produccion       boolean  TRUE para habilitar el modo de producción y FALSE para usar 
|                                            el sandbox
*/

//Esta es la condiguracion de OpenPay Activa

//$config['comercio_id'] = 'mwsb83jwreqy1gebwtgp';
//$config['llave_privada'] = 'sk_ef4692f94b7646b5b6af5a12815e2f98';
//$config['establecer_modo_produccion'] = FALSE;

//$config['comercio_id'] = 'mvpk3fqcwtremfqkzp5k';
//$config['llave_privada'] = 'sk_a839a9503d0a4d5cb529f1667514ddf3';
//$config['establecer_modo_produccion'] = TRUE;

/** ====== JID Agency SandBox ====== */
/*
$config['comercio_id'] = 'm8otpwxmarioccpdk4xa';
$config['llave_privada'] = 'sk_30296ed1e3124f01ae9e78af874899e8';
$config['establecer_modo_produccion'] = FALSE;
*/

/** ====== Sensoria Studio SandBox ====== */
$config['comercio_id'] = 'm5jvrxzl04j0jassunr0';
$config['llave_privada'] = 'sk_0c96876a120846c5874348e1f119de7a';
$config['establecer_modo_produccion'] = FALSE;