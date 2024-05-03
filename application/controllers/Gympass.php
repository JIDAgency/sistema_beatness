<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gympass extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('gympass_lib');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Gympass';
        $data['pagina_subtitulo'] = 'Gympass';
        $data['pagina_gympass'] = true;

        $data['controlador'] = 'gympass';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "gympass/index";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $list_products = json_decode($this->list_products(), true);

        $data['list_products'] = $list_products;

        $this->construir_private_site_ui('gympass/index', $data);
    }

    // ============ PRODUCTS ============

    public function list_products()
    {
        try {
            $response = $this->gympass_lib->get_list_products();
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // ============ CLASSES ============

    public function create_class()
    {
        $data = [
            'classes' => [
                [
                    'name' => 'Test Class',
                    'description' => 'Test class description',
                    'notes' => 'Test class notes',
                    'bookable' => true,
                    'visible' => true,
                    'is_virtual' => true,
                    'product_id' => 100003
                ]
            ]
        ];

        try {
            $response = $this->gympass_lib->post_create_class($data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function list_classes()
    {
        try {
            $response = $this->gympass_lib->get_list_classes();
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function class_details($class_id)
    {
        try {
            $response = $this->gympass_lib->get_class_details($class_id);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update_class($class_id)
    {
        $data = [
            'name' => 'Super Cycle',
            'description' => 'Our standard cycle classes',
            'notes' => 'Notes of our standard cycle classes',
            'bookable' => true,
            'visible' => true,
            'product_id' => 1,
        ];

        try {
            $response = $this->gympass_lib->put_update_class($class_id, $data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // ============ SLOTS ============

    public function create_slot($class_id)
    {
        $data = [
            "occur_date" => "2022-09-29T22:00:50.000Z",
            "status" => 1,
            "room" => "Virtual test",
            "length_in_minutes" => 60,
            "total_capacity" => 15,
            "total_booked" => 5,
            "product_id" => 100003,
            "booking_window" => [
                "opens_at" => "2022-09-29T09:22:50.000Z",
                "closes_at" => "2022-09-29T21:00:00.000Z"
            ],
            "cancellable_until" => "2022-09-29T18:05:00.000Z",
            "instructors" => [
                [
                    "name" => "Virtual test",
                    "substitute" => true
                ]
            ],
            "rate" => 4.0
        ];

        try {
            $response = $this->gympass_lib->post_create_slot($class_id, $data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function slot_details($class_id, $slot_id)
    {
        try {
            $response = $this->gympass_lib->get_slot_details($class_id, $slot_id);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function list_slots($class_id, $from, $to)
    {
        try {
            $response = $this->gympass_lib->get_list_slots($class_id, $from, $to);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function delete_slot($class_id, $slot_id)
    {
        try {
            $response = $this->gympass_lib->delete_slot($class_id, $slot_id);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function parcial_update_slot($class_id, $slot_id)
    {
        // Datos actualizados del slot
        $data = [
            "total_capacity" => 15,
            "total_booked" => 5,
            "virtual_class_url" => "http://your_url.com"
        ];

        try {
            $response = $this->gympass_lib->patch_update_slot($class_id, $slot_id, $data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update_slot($class_id, $slot_id)
    {
        // Datos actualizados del slot
        $data = [
            "occur_date" => "2019-07-09T10:00:00-03:00",
            "room" => "Room 1",
            "status" => 1,
            "length_in_minutes" => 60,
            "total_capacity" => 15,
            "total_booked" => 7,
            "product_id" => 1,
            "booking_window" => [
                "opens_at" => "2019-07-08T00:00:00-03:00",
                "closes_at" => "2019-07-09T09:00:00-03:00"
            ],
            "instructors" => [
                [
                    "name" => "Axel",
                    "substitute" => false
                ],
                [
                    "name" => "John",
                    "substitute" => true
                ]
            ],
            "cancellable_until" => "2019-07-09T09:00:00-03:00",
            "rate" => 4.5,
            "virtual" => true,
            "virtual_class_url" => "http://your_url.com"
        ];

        try {
            $response = $this->gympass_lib->put_update_slot($class_id, $slot_id, $data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // ============ BOOKING ============

    public function patch_validate_booking($gym_id, $booking_number)
    {
        // Datos para validar la reserva
        $data = [
            "status" => "REJECTED",
            "reason" => "Class is full",
            "reason_category" => "CLASS_IS_FULL",
            "virtual_class_url" => "http://your_url.com"
        ];

        try {
            $response = $this->gympass_lib->patch_validate_booking($gym_id, $booking_number, $data);
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
