<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model {

	/** Sistema (Inicio) |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

        /** Métodos generales (Inicio) //////////////////////////////////////////////////////////////////////////// */

            /** Método para obtener todas las filas en una lista */
            public function get_todos_los_roles()
            {
                $query = $this->db
                    ->get('roles');

                return $query;
            }

            /** Método para obtener una fila por su id */
            public function get_rol_por_id($id)
            {
                $query = $this->db
                    ->where('id', intval($id))
                    ->get('roles');
                
                return $query;
            }

            /** Método para crear una nueva fila */
            public function insert_rol($data)
            {
                $query = $this->db
                    ->insert('roles', $data);

                return $query;
            }

            /** Método para editar una fila existente */
            public function update_rol($id, $data)
            {
                $query = $this->db
                    ->where('id', $id)
                    ->update('roles', $data);

                return $query;
            }

        /** Métodos generales (Fin) //////////////////////////////////////////////////////////////////////////// */

        /** Métodos (Inicio) //////////////////////////////////////////////////////////////////////////// */
            /** Métodos - Usuarios Controller (Inicio) *****************************************************************************/

                public function get_todos_los_roles_tipo_administrador()
                {
                    $query = $this->db
                    ->where('es_admin', 1)
                    ->get('roles');

                    return $query;
                }

            /** Métodos - Usuarios Controller (Fin) *****************************************************************************/
        /** Métodos (Fin) //////////////////////////////////////////////////////////////////////////// */

	/** Sistema (Fin) |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
}