<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Webhooks_model extends CI_Model
{
    public function get_todas_las_webhooks()
    {
        $query = $this->db
            ->get('openpay_webhooks');

        return $query;
    }

    public function get_webhook_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('openpay_webhooks');

        return $query;
    }

    public function insert_webhook($data)
    {
        $query = $this->db
            ->insert('openpay_webhooks', $data);

        return $query;
    }

    public function update_webhook($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('openpay_webhooks', $data);

        return $query;
    }

    public function delete_webhook($id)
    {
        $this->db->where('id', $id)->delete('openpay_webhooks');
        {return true;}
    }

    public function get_webhook_por_transaction_id($transaction_id)
    {
        $query = $this->db
            ->where('transaction_id', $transaction_id)
            ->get('openpay_webhooks');

        return $query;
    }

}