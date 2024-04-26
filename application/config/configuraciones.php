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
$config['titulo'] = '';
$config['nombre_comercial'] = '';
$config['nombre_fiscal'] = '';
$config['descripcion'] = '';
$config['palabras_clave'] = '';
$config['autor'] = 'jid.agency';

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
