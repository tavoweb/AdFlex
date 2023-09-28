<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_result extends CI_Model {

    private $_site;
    private $_user;

    public function user()
    {
        if ($this->_user === null) {
            $this->_user = $this->db->get_where(config_item('users_table'), ['id' => $this->user_id])->row();
        }

        return $this->_user;
    }


    public function site()
    {
        if ($this->_site === null) {
            $this->_site = $this->db->get_where(config_item('sites_table'), ['site_id' => $this->site_id])->row();
        }

        return $this->_site;
    }


}
