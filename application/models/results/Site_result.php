<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site_result extends CI_Model {

    private $_user;
    private $_units;
    private $_count_units;

    public function user()
    {
        if (!$this->_user) {

            $user_obj = $this->db->get_where(config_item('users_table'), ['id' => $this->user_id])->row();

            if (!empty($user_obj->meta)) {
                $user_obj->meta = (object) unserialize($user_obj->meta);
            }

            $this->_user = $user_obj;
        }

        return $this->_user;
    }


    public function units()
    {
        if (!$this->_units) {
            $this->_units = $this->db->get_where(config_item('adunits_table'), ['site_id' => $this->site_id])->result();
        }

        return $this->_units;
    }


    public function count_units()
    {
        if (!$this->_count_units) {

            $this->db->where('site_id', $this->site_id);
            $this->db->from(config_item('adunits_table'));

            $this->_count_units = $this->db->count_all_results();
        }

        return $this->_count_units;
    }


}
