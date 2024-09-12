<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('db_activa')) {
    function db_activa()
    {
        return get_instance()->config->item('db_activa');
    }
}

if (!function_exists('branding')) {

    function branding()
    {
        return get_instance()->config->item('branding', 'b3studio');
    }
}

if (!function_exists('titulo')) {
    function titulo()
    {
        return get_instance()->config->item('titulo');
    }
}


if (!function_exists('lema')) {

    function lema()
    {
        return get_instance()->config->item('lema', 'b3studio');
    }
}

if (!function_exists('pagina')) {

    function pagina()
    {
        return get_instance()->config->item('pagina', 'b3studio');
    }
}

if (!function_exists('sistema_id')) {
    function sistema_id()
    {
        return get_instance()->config->item('sistema_id');
    }
}

if (!function_exists('nombre_comercial')) {
    function nombre_comercial()
    {
        return get_instance()->config->item('nombre_comercial');
    }
}

if (!function_exists('nombre_fiscal')) {
    function nombre_fiscal()
    {
        return get_instance()->config->item('nombre_fiscal');
    }
}

if (!function_exists('descripcion')) {
    function descripcion()
    {
        return get_instance()->config->item('descripcion');
    }
}

if (!function_exists('palabras_clave')) {
    function palabras_clave()
    {
        return get_instance()->config->item('palabras_clave');
    }
}

if (!function_exists('autor')) {
    function autor()
    {
        return get_instance()->config->item('autor');
    }
}

if (!function_exists('whatsapp')) {
    function whatsapp()
    {
        return get_instance()->config->item('whatsapp');
    }
}

if (!function_exists('facebook')) {
    function facebook()
    {
        return get_instance()->config->item('facebook');
    }
}

if (!function_exists('instagram')) {
    function instagram()
    {
        return get_instance()->config->item('instagram');
    }
}

if (!function_exists('linkedin')) {
    function linkedin()
    {
        return get_instance()->config->item('linkedin');
    }
}

if (!function_exists('twitter')) {
    function twitter()
    {
        return get_instance()->config->item('twitter');
    }
}

if (!function_exists('contacto_soporte_numero')) {

    function contacto_soporte_numero()
    {
        return get_instance()->config->item('contacto_soporte_numero', 'b3studio');
    }
}

if (!function_exists('nombre_comercial')) {
    function nombre_comercial()
    {
        return get_instance()->config->item('nombre_comercial');
    }
}

if (!function_exists('nombre_fiscal')) {
    function nombre_fiscal()
    {
        return get_instance()->config->item('nombre_fiscal');
    }
}

if (!function_exists('terminos_del_servicio')) {

    function terminos_del_servicio()
    {
        return get_instance()->config->item('terminos_del_servicio', 'b3studio');
    }
}

if (!function_exists('terminos_y_condiciones')) {

    function terminos_y_condiciones()
    {
        return get_instance()->config->item('terminos_y_condiciones', 'b3studio');
    }
}



if (!function_exists('description')) {

    function description()
    {
        return get_instance()->config->item('description', 'b3studio');
    }
}

if (!function_exists('keywords')) {

    function keywords()
    {
        return get_instance()->config->item('keywords', 'b3studio');
    }
}

if (!function_exists('author')) {

    function author()
    {
        return get_instance()->config->item('author', 'b3studio');
    }
}

if (!function_exists('whatsapp')) {
    function whatsapp()
    {
        return get_instance()->config->item('whatsapp');
    }
}

if (!function_exists('facebook')) {
    function facebook()
    {
        return get_instance()->config->item('facebook');
    }
}

if (!function_exists('instagram')) {
    function instagram()
    {
        return get_instance()->config->item('instagram');
    }
}

if (!function_exists('linkedin')) {
    function linkedin()
    {
        return get_instance()->config->item('linkedin');
    }
}

if (!function_exists('twitter')) {
    function twitter()
    {
        return get_instance()->config->item('twitter');
    }
}

if (!function_exists('select_disciplina')) {
    function select_disciplina()
    {
        return get_instance()->config->item('select_disciplina');
    }
}

if (!function_exists('select_instructor')) {
    function select_instructor()
    {
        return get_instance()->config->item('select_instructor');
    }
}

if (!function_exists('select_dificultad')) {
    function select_dificultad()
    {
        return get_instance()->config->item('select_dificultad');
    }
}

if (!function_exists('select_mostrar')) {
    function select_mostrar()
    {
        return get_instance()->config->item('select_mostrar');
    }
}

if (!function_exists('select_activo')) {
    function select_activo()
    {
        return get_instance()->config->item('select_activo');
    }
}

if (!function_exists('select_es_estudiante')) {
    function select_es_estudiante()
    {
        return get_instance()->config->item('select_es_estudiante');
    }
}

if (!function_exists('select_es_empresarial')) {
    function select_es_empresarial()
    {
        return get_instance()->config->item('select_es_empresarial');
    }
}

if (!function_exists('select_mostrar_clase')) {
    function select_mostrar_clase() {
        return get_instance()->config->item('select_mostrar_clase');
    }
}

if (!function_exists('select_pagar_en')) {
    function select_pagar_en() {
        return get_instance()->config->item('select_pagar_en');
    }
}