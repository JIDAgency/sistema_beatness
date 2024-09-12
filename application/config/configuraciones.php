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

/* ====== activo ====== */

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

/* ====== es_estudiante ====== */

$select_es_estudiante = array(
    (object) array(
        'nombre'    => 'Si',
        'valor'     => 'si',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'No',
        'valor'     => 'no',
        'activo'    => true,
    )
);

$config['select_es_estudiante'] = $select_es_estudiante;

/* ====== es_empresarial ====== */

$select_es_empresarial = array(
    (object) array(
        'nombre'    => 'Si',
        'valor'     => 'si',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'No',
        'valor'     => 'no',
        'activo'    => true,
    )
);

$config['select_es_empresarial'] = $select_es_empresarial;

/* ====== Calendario o lista ====== */

$select_mostrar_clase = array(
    (object) array(
        'nombre'    => 'Calendario',
        'valor'     => 'calendario',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'Lista',
        'valor'     => 'lista',
        'activo'    => false,
    )
);

$config['select_mostrar_clase'] = $select_mostrar_clase;

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

/* ====== dificultad ====== */

$select_dificultad = array(
    (object) array(
        'nombre'    => 'AMRAP',
        'valor'     => 'AMRAP',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'AVANZADO',
        'valor'     => 'AVANZADO',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'BACK & BICEP',
        'valor'     => 'BACK & BICEP',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'BÁSICO',
        'valor'     => 'BÁSICO',
        'activo'    => true,
    ),
    (object) array(
        'nombre'    => 'CHEST & TRICEP',
        'valor'     => 'CHEST & TRICEP',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'FULL BODY',
        'valor'     => 'FULL BODY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'INTERMEDIO',
        'valor'     => 'INTERMEDIO',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'KILLER ABS',
        'valor'     => 'KILLER ABS',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'LEG DAY',
        'valor'     => 'LEG DAY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'LEGS & BOOTY',
        'valor'     => 'LEGS & BOOTY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'PULL & PUSH',
        'valor'     => 'PULL & PUSH',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'PULL DAY',
        'valor'     => 'PULL DAY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'PUSH DAY',
        'valor'     => 'PUSH DAY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'SHOULDER & ARMS',
        'valor'     => 'SHOULDER & ARMS',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'TRX FULL BODY',
        'valor'     => 'TRX FULL BODY',
        'activo'    => false,
    ),
    (object) array(
        'nombre'    => 'UPPER BODY',
        'valor'     => 'UPPER BODY',
        'activo'    => false,
    ),
);

$config['select_dificultad'] = $select_dificultad;

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

$select_pagar_en = array(
    (object) array(
        'nombre'   => 'app',
        'valor'    => 'app',
        'activo'   => false
    ),
    (object) array(
        'nombre'   => 'url',
        'valor'    => 'url',
        'activo'   => false
    )
);
$config['select_pagar_en'] = $select_pagar_en;
