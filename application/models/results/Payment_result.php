<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_result extends CI_Model {

    private $_user;

    public function user()
    {
        if (!$this->_user) {
            $this->_user = $this->db->get_where(config_item('users_table'), ['id' => $this->user_id])->row();
        }

        return $this->_user;
    }


}
