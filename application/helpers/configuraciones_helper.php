<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('branding')) {
    
    function branding()
    {
        return get_instance()->config->item('branding', 'b3studio');
    }

}

if (!function_exists('titulo')) {
    
    function titulo()
    {
        return get_instance()->config->item('titulo', 'b3studio');
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

if (!function_exists('contacto_soporte_numero')) {
    
    function contacto_soporte_numero()
    {
        return get_instance()->config->item('contacto_soporte_numero', 'b3studio');
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

