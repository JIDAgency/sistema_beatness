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
        $list_classes = json_decode($this->list_classes(), true);
        $list_slots = json_decode($this->list_slots('1713', '2024-01-09T00:00:00%2B03:00', '2024-09-09T23:59:59%2B03:00'), true);
        $create_slot = $this->create_slot('1713');

        $data['list_products'] = $list_products;
        $data['list_classes'] = $list_classes;
        $data['list_slots'] = $list_slots;
        $data['create_slot'] = $create_slot;

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
        // Fecha y hora del viernes a las 7 AM (hora local)
        $occur_date = "2024-06-07T07:00:00.000Z";
        // Fecha y hora de apertura de la ventana de reserva (por ejemplo, 5 días antes)
        $booking_window_opens = "2024-06-02T07:00:00.000Z";
        // Fecha y hora de cierre de la ventana de reserva (por ejemplo, 1 hora antes de la clase)
        $booking_window_closes = "2024-06-07T06:00:00.000Z";
        // Fecha y hora límite para cancelación (4 horas antes de la clase)
        $cancellable_until = "2024-06-07T03:00:00.000Z";

        $product_id = 119;

        $data = [
            "occur_date" => $occur_date,
            "status" => 1,
            "room" => "Virtual test",
            "length_in_minutes" => 60,
            "total_capacity" => 15,
            "total_booked" => 5,
            "product_id" => $product_id,
            "booking_window" => [
                "opens_at" => $booking_window_opens,
                "closes_at" => $booking_window_closes
            ],
            "cancellable_until" => $cancellable_until,
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
            return $response;  // Asegúrate de imprimir la respuesta para verla en la salida.
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();  // Asegúrate de imprimir los errores para verlos.
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
