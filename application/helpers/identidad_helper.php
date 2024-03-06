<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('es_superadministrador')) {

    function es_superadministrador()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_superadministrador', 'b3studio');
    }
}

if (!function_exists('es_administrador')) {

    function es_administrador()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_administrador', 'b3studio');
    }
}

if (!function_exists('es_instructor')) {

    function es_instructor()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_instructor', 'b3studio');;
    }
}

if (!function_exists('es_cliente')) {

    function es_cliente()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_cliente', 'b3studio');;
    }
}

if (!function_exists('es_frontdesk')) {

    function es_frontdesk()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_frontdesk', 'b3studio');;
    }
}

if (!function_exists('es_operaciones')) {

    function es_operaciones()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_operaciones', 'b3studio');;
    }
}


if (!function_exists('es_corporativo')) {

    function es_corporativo()
    {
        return get_instance()->session->userdata['rol_id'] == get_instance()->config->item('id_rol_corporativo', 'b3studio');;
    }
}
