<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuraciones generales para el sistema b3Studio
|--------------------------------------------------------------------------
| En este archivo se van a definir algunas configuraciones generales y
| específicas en algunos casos, para el sistema b3studio; esto para no
| modificar el archivo config.php que trae configuraciones específicase de CI
|
*/

/*
|--------------------------------------------------------------------------
| reCaptcha
|--------------------------------------------------------------------------
|
*/
$config['recaptcha_activar'] = true;
$config['recaptcha_api_url'] = 'https://www.google.com/recaptcha/api/siteverify';
$config['recaptcha_secret'] = '6LdhKWokAAAAAEztJ_68lPoIso2UdE6NxjcbQQrf';

/*
|--------------------------------------------------------------------------
| Envío de correos
|--------------------------------------------------------------------------
|
*/
$config['email_sitio_identificador'] = 'Pentha';
$config['email_admin'] = 'ventas@pentha.mx';
$config['email_config'] = array(
'mailtype' => 'html',
);

/*
|--------------------------------------------------------------------------
| Imagen que se utilizará por defecto en el perfil
|--------------------------------------------------------------------------
| Esta dato es necesario para saber si guardar o no la imagen cuando el
| usuario suba alguna imagen
|
*/
$config['imagen_perfil_por_defecto'] = 'perfil.png';

/*
|--------------------------------------------------------------------------
| Configuracion del sistema
|--------------------------------------------------------------------------
|
*/
$config['sistema_id'] = 'btresstudio';
$config['sistema_nombre'] = 'Sensoria Studio';
$config['sistema_nombre_cliente'] = 'Sensoria Studio';

/*
|--------------------------------------------------------------------------
| Autenticación/Autorización/Identidad
|--------------------------------------------------------------------------
|
*/
/** Roles administrativos */
$config['id_rol_superadministrador'] = 4;
$config['id_rol_administrador'] = 2;
$config['id_rol_instructor'] = 3;
$config['id_rol_frontdesk'] = 5;
$config['id_rol_operaciones'] = 7;

/** Roles externos */
$config['id_rol_cliente'] = 1;
$config['id_rol_corporativo'] = 6;


$config['branding'] = 'Pentha';
$config['titulo'] = 'Pentha';
$config['lema'] = 'Indoor cycling, Bootcamp Box, Jump, Calistenia, Funcional, Taller (Gym)';
$config['pagina'] = 'pentha.mx';
$config['contacto_soporte_numero'] = '2223059985';


$config['terminos_del_servicio'] = 'pentha.mx';
$config['terminos_y_condiciones'] = 'pentha.mx';


$config['description'] = 'Todos somos Pentha ¡todas tus clases en un mismo lugar! Indoor cycling, Bootcamp Box, Jump, Calistenia, Funcional, Taller (Gym).';
$config['keywords'] = 'Pentha, club fitness, Indoor cycling, Bootcamp Box, Jump, Calistenia, Funcional, Taller (Gym)';
$config['author'] = 'JID Agency';

