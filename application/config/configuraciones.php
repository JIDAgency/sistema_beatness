<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuraciones generales para el sistema 
|--------------------------------------------------------------------------
| En este archivo se van a definir algunas configuaciones generales y
| específicas en algunos casos, para el sistema; esto para no
| modificar el archivo config.php que trae configuraciones específicase de CI.
|
*/

/** v3.1.13 */

/*
|--------------------------------------------------------------------------
| Configuracion del sistema
|--------------------------------------------------------------------------
|
*/

/*
|--------------------------------------------------------------------------
| Base de datos, ¿El sistema o web llevará base de datos?
|--------------------------------------------------------------------------
| En caso de que el sistema o web requiera declarar la variable como TRUE, 
| en caso contrario usar FALSE.
|
*/

$config['db_activa'] = true;

/*
|--------------------------------------------------------------------------
| Identificadores del sistema
|--------------------------------------------------------------------------
| Aquí se configura todo lo que identifica al sistema y branding.
|
*/

$config['sistema_id'] = 'sistema_beatnes';
$config['titulo'] = 'Beatness | Fitness Studio';
$config['nombre_comercial'] = 'Beatness Studio';
$config['nombre_fiscal'] = 'Beatness Studio';
$config['descripcion'] = 'Descubre Beatness | Fitness Studio: tu destino de bienestar y ejercicio en Ciudad de México y Puebla. Experimenta nuestras emocionantes clases de bootcamp e indoor cycling y accede a nuestra aplicación exclusiva para llevar tu fitness al siguiente nivel.';
$config['palabras_clave'] = 'Fitness, Studio, Ejercicio, Bootcamp, Indoor Cycling, Ciudad de México, Puebla, Bienestar, Salud, App, Entrenamiento, Comunidad.';
$config['autor'] = 'Beatness Team';

/*
|--------------------------------------------------------------------------
| GymPass
|--------------------------------------------------------------------------
| Configuración de GymPass
|
*/

$config['gympass_base_url'] = 'https://apitesting.partners.gympass.com';
$config['gympass_api_key'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNjYzNGFmYy1kZjE4LTQ1MzctYjEzMC1hM2VlZjY2ODVhN2IiLCJpc3MiOiJwYXJ0bmVycy10ZXN0aW5nLWlhbS51cy5zdGcuZ3ltcGFzcy5jbG91ZCIsImlhdCI6MTcxMzk3NTE3NSwianRpIjoiMjY2MzRhZmMtZGYxOC00NTM3LWIxMzAtYTNlZWY2Njg1YTdiIn0.FArt7ha1fJuNihB9Am0y_858duLbNU8ghQe0XQI78ZM';
$config['gympass_gym_id'] = 60;
$config['gympass_partner_id'] = 'b806bd77-d913-4046-a6e7-8fba7b34d277';
$config['gympass_system_id'] = 81;

/*
|--------------------------------------------------------------------------
| Redes sociales
|--------------------------------------------------------------------------
| Configurar todos los links externos de redes sociales de la marca.
|
*/

$config['whatsapp'] = null;
$config['facebook'] = null;
$config['instagram'] = null;
$config['linkedin'] = null;
$config['twitter'] = null;

/* ====== Estatus del sistema ====== */

$select_estatus = array(
    (object) array(
        'nombre'    => 'Activo',
        'valor'     => 'activo',
        'activo'    => true,
    ),
    (object) array(
        'nombre'    => 'Suspendido',
        'valor'     => 'suspendido',
        'activo'    => false,
    )
);

$config['select_estatus'] = $select_estatus;

/* ====== Mostrar en app ====== */

$select_mostrar = array(
    (object) array(
        'nombre'    => 'Si',
        'valor'     => 'si',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'No',
        'valor'     => 'no',
        'activo'    => false,
    )
);

$config['select_mostrar'] = $select_mostrar;

/* ====== Activo boolean ====== */

$select_activo = array(
    (object) array(
        'nombre'    => 'Si',
        'valor'     => '1',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'No',
        'valor'     => '0',
        'activo'    => false,
    )
);

$config['select_activo'] = $select_activo;

/* ====== disciplina ====== */

$select_disciplina = array(
    (object) array(
        'nombre'    => 'INDOOR CYCLING',
        'valor'     => '2',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'BOOTCAMP',
        'valor'     => '3',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'BOX',
        'valor'     => '4',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'JUMP',
        'valor'     => '5',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'CALISTENIA',
        'valor'     => '6',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'GYM + TALLER',
        'valor'     => '7',
        'activo'    => false,
    ),
);

$config['select_disciplina'] = $select_disciplina;

$select_instructor = array(
    (object) array(
        'nombre'    => 'Homero',
        'valor'     => '4',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'Roberto Vasquez',
        'valor'     => '34',
        'activo'    => false,
    )
);

$config['select_instructor'] = $select_instructor;
