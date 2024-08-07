<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{

    /* ====== Registro de usuario en la App ====== */

    public function verificar_no_telefono_existente($no_telefono)
    {
        $query = $this->db->get_where('usuarios', array('no_telefono' => $no_telefono));
        return $query->num_rows() > 0; // Devuelve true si el no_telefono existe, de lo contrario, devuelve false
    }

    public function verificar_correo_existente($correo)
    {
        $query = $this->db->get_where('usuarios', array('correo' => $correo));
        return $query->num_rows() > 0; // Devuelve true si el correo existe, de lo contrario, devuelve false
    }

    /** Clientes - Funciones de modelo (INICIO) */

    /** Obtener la lista de clientes para la lista de clientes “clientes/index” con limitaciones de información. */
    public function get_lista_de_clientes_activos_con_limitacion_de_datos()
    {

        $query = $this->db
            ->where('t1.estatus', 'activo')
            ->where('t1.rol_id', intval(1))
            ->order_by('t1.id', 'desc')
            ->select("
                    t1.id as id,
                    CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre_completo,
                    t1.correo as correo,
                    t1.no_telefono as no_telefono,
                    t1.es_estudiante as es_estudiante,
                    t1.es_estudiante_vigencia as es_estudiante_vigencia,
                    t1.es_empresarial as es_empresarial,
                    t1.dominio as dominio,
                    t1.estatus as estatus,
                    t1.fecha_registro as fecha_registro,
                    t1.sucursal_id,
                    t3.descripcion as nombre_sucursal,
                ")
            ->from('usuarios t1')
            ->join('roles t2', 't1.rol_id = t2.id')
            ->join('sucursales t3', 't1.sucursal_id = t3.id')
            ->get();

        return $query;
    }

    /** Obtener la lista de clientes para la lista de clientes “clientes/suspendidos con limitaciones de información. */
    public function get_lista_de_clientes_suspendidos_con_limitacion_de_datos()
    {

        $query = $this->db
            ->where('t1.estatus', 'suspendido')
            ->where('t1.rol_id', intval(1))
            ->order_by('t1.id', 'desc')
            ->select("
                    t1.id as id,
                    CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre_completo,
                    t1.correo as correo,
                    t1.no_telefono as no_telefono,
                    t1.es_estudiante as es_estudiante,
                    t1.dominio as dominio,
                    t1.estatus as estatus,
                    t1.fecha_registro as fecha_registro,
                ")
            ->from('usuarios t1')
            ->join('roles t2', 't1.rol_id = t2.id')
            ->get();

        return $query;
    }

    public function editar_cliente($id, $data)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->where('rol_id', intval(1))
            ->update('usuarios', $data);

        return $query;
    }

    /** Clientes - Funciones de modelo (FIN) */

    /** Funciones generales (Inicio) */
    /** Funciones generales (Fin) */

    /** Nuevos metodos */

    /** Obtener todos los registros de la tabla de usuarios */
    public function get_lista_de_todos_los_usuarios()
    {
        $query = $this->db->get('usuarios');
        return $query;
    }

    public function obtener_colaborador_por_id($id)
    {
        $query = $this->db
            ->where('t1.id', intval($id))
            ->select("
                t1.*,
                t2.sucursal_id as sucursal_id,
            ")
            ->from('usuarios t1')
            ->join('colaboradores_sucursales t2', 't1.id = t2.colaborador_id', 'left outer')
            ->get();

        return $query;
    }

    /** Obtener todos los colaboradores con el rol de cliente limitada a datos específicos*/
    public function get_lista_de_todos_los_colaboradores_limitada()
    {

        $query = $this->db
            ->where_in('t1.rol_id', array(2, 4, 5, 7))
            ->order_by('t1.id', 'desc')
            ->select("
                t1.id as listar_id,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS listar_nombre_completo,
                t1.correo as listar_correo,
                t1.no_telefono as listar_no_telefono,
                t2.tipo as listar_tipo,
                t4.locacion as listar_locacion,
            ")
            ->from('usuarios t1')
            ->join('roles t2', 't1.rol_id = t2.id')
            ->join('colaboradores_sucursales t3', 't1.id = t3.colaborador_id', 'left outer')
            ->join('sucursales t4', 't3.sucursal_id = t4.id', 'left outer')
            ->get();

        return $query;
    }

    /** Viejos metodos **********************************************************************************************/

    public function obtener_todos()
    {
        return $this->db->get('usuarios');
    }

    public function obtener_todos_ventas_frontdesk()
    {
        $query = $this->db
            ->where('estatus', 'activo')
            ->get('usuarios');

        return $query;
    }

    public function obtener_todos_administradores()
    {
        $this->db->select("t1.*,t2.tipo as rol");
        $this->db->from("usuarios t1");
        $this->db->join("roles t2", "t1.rol_id = t2.id");
        $this->db->where_in('rol_id', array(2, 4, 5));
        return $this->db->get();
    }

    public function obtener_todos_clientes()
    {
        $this->db->select("t1.*,t2.tipo as rol");
        $this->db->from("usuarios t1");
        $this->db->join("roles t2", "t1.rol_id = t2.id");
        $this->db->where_in('rol_id', 1);
        return $this->db->get();
    }

    public function obtener_reporte_de_clientes_activos()
    {

        //Usuarios con un plan y sin un plan
        /*
        $query = $this->db->select("
            t1.*,
            t2.tipo as rol,
            t3.id as asignacion_id
        ")
            ->from("usuarios t1")
            ->join("roles t2", "t1.rol_id = t2.id", 'left')
            ->join("asignaciones t3", "t1.id = t3.usuario_id", 'left')
            ->group_by('t1.id')
            ->where_in('t1.rol_id', 1)
            ->where('t3.id', null)
            ->where("DATE_FORMAT(t1.fecha_registro,'%Y-%m') =","2021-04")
        ->get();
        */

        // Usuarios registrados en tal mes...
        /*
        $query = $this->db->select("
                t1.*,
            ")
            ->from("usuarios t1")
            ->where_in('t1.rol_id', 1)
            ->where("DATE_FORMAT(t1.fecha_registro,'%Y-%m') =","2021-04")
        ->get();
        */

        // Usuarios nuevos que compraron una suscripcion...
        /*
        $query = $this->db->select("
                t1.*,
            ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id")
            ->group_by('t1.id')
            ->where_in('t1.rol_id', array(1))
            ->where("t2.nombre","B3 Online Access")
            ->where("DATE_FORMAT(t1.fecha_registro,'%Y-%m') =","2021-04")
        ->get();
        */

        /*
        $query = $this->db->select("
                t1.*,
            ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id", 'left')
            ->group_by('t1.id')
            ->where_in('t1.rol_id', array(1))
            ->where("t2.id", null)
            ->where("DATE_FORMAT(t1.fecha_registro,'%Y-%m') =","2021-04")
        ->get();
        */

        // return $query;
    }

    public function obtener_todos_instructores()
    {
        $this->db->select("t1.*, CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre, t2.tipo as rol");
        $this->db->from("usuarios t1");
        $this->db->join("roles t2", "t1.rol_id = t2.id");
        $this->db->where_in('rol_id', 3);
        $this->db->order_by('nombre_completo', "asc");
        return $this->db->get();
    }

    public function obtener_usuario_por_id($id)
    {
        return $this->db->where('t1.id', intval($id))->select('t1.*, t2.descripcion as nombre_sucursal')->from('usuarios t1')->join('sucursales t2', 't1.sucursal_id = t2.id')->get();
    }

    public function obtener_por_token_id($token, $id)
    {
        return $this->db->where(array('token' => $token, 'id' => $id))->get('usuarios');
    }

    public function obtener_usuario_para_app($token, $id)
    {
        $query = $this->db
            ->where(array('t1.token' => $token, 't1.id' => $id))
            ->select('t1.*, t2.descripcion as nombre_sucursal')
            ->from('usuarios t1')
            ->join('sucursales t2', 't1.sucursal_id = t2.id', 'left')
            ->get();

        return $query;
    }

    public function obtener_por_facebook_id($facebook_id)
    {
        return $this->db->where('facebook_id', $facebook_id)->get('usuarios');
    }

    public function crear($data)
    {
        $data['token'] = bin2hex(openssl_random_pseudo_bytes(20));
        $data['fecha_registro'] = date('Y-m-d H:i:s');
        return $this->db->insert('usuarios', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('usuarios', $data);
    }

    public function obtener_usuario_por_nombre_usuario($usuario)
    {
        return $this->db->query('SELECT *
                                 FROM `usuarios`
                                 WHERE BINARY `nombre_usuario` = ' . $this->db->escape($usuario));
    }

    public function obtener_usuario_por_correo($correo)
    {
        return $this->db->query('SELECT *
                                 FROM `usuarios`
                                 WHERE `correo` = ' . $this->db->escape($correo));
    }

    public function obtener_usuario_por_codigo($codigo)
    {
        return $this->db->query('SELECT *
                                 FROM `usuarios`
                                 WHERE `codigo_recuperar_contrasena` = ' . $this->db->escape($codigo));
    }

    public function get_usuario_por_correo_y_token($correo, $token)
    {
        $query = $this->db
            ->select("
                t1.*
            ")
            ->from("usuarios t1")
            ->where('t1.correo', $correo)
            ->where('t1.token', $token)
            ->get();

        return $query;
    }


    /** Métodos actualizados */
    /** Clientes */

    /** Usuarios Corporativos */

    public function get_usuario_corporativo_por_id($id)
    {
        $query = $this->db->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre,
                t2.tipo as rol
            ")
            ->from("usuarios t1")
            ->join("roles t2", "t1.rol_id = t2.id")
            ->where('t1.id', intval($id))
            ->where('t1.rol_id', intval(6))
            ->get();

        return $query;
    }

    public function get_todos_los_usuarios_corporativos()
    {
        $query = $this->db->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre,
                t2.tipo as rol
            ")
            ->from("usuarios t1")
            ->join("roles t2", "t1.rol_id = t2.id")
            ->where('rol_id', 6)
            ->get();

        return $query;
    }

    public function obtener_usuarios_seleccionados($usuarios_seleccionados_list)
    {
        $query = $this->db
            ->where_in('t1.id', $usuarios_seleccionados_list)
            ->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre
            ")
            ->from("usuarios t1")
            ->get();

        return $query;
    }

    public function obtener_todos_usuarios()
    {
        $query = $this->db
            ->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre,
                t2.descripcion as nombre_sucursal
            ")
            ->from("usuarios t1")
            ->join("sucursales t2", "t2.id = t1.sucursal_id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_puebla()
    {
        $query = $this->db
            ->where_in('t1.sucursal_id', '2')
            ->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre,
                t2.descripcion as nombre_sucursal
            ")
            ->from("usuarios t1")
            ->join("sucursales t2", "t2.id = t1.sucursal_id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_polanco()
    {
        $query = $this->db
            ->where_in('t1.sucursal_id', '3')
            ->select("
                t1.*,
                CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre,
                t2.descripcion as nombre_sucursal
            ")
            ->from("usuarios t1")
            ->join("sucursales t2", "t2.id = t1.sucursal_id")
            ->get();

        return $query;
    }

    public function obtener_por_nombre($nombre)
    {
        $query = $this->db
            ->where_in("CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D'))", $nombre)
            ->select("
                t1.id
            ")
            ->from("usuarios t1")
            ->get();

        return $query;
    }

    public function  obtener_instructor_por_id($id)
    {
        $query = $this->db
            ->where('t1.id', $id)
            ->select("CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS nombre")
            ->from('usuarios t1')
            ->get();

        return $query;
    }

    public function actualizar_usuario_por_identificador($identificador, $data)
    {
        $query = $this->db
            ->where('id', $identificador)
            ->update('usuarios', $data);

        return $query;
    }
}
