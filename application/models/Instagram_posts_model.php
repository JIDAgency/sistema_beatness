<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instagram_posts_model extends CI_Model
{


    public function get_utlimo_instagram_post_por_id()
    {
        $query = $this->db->from('instagram_posts')
            ->order_by("id", "desc")
            ->limit(1)
            ->get();

        return $query;
    }

}
