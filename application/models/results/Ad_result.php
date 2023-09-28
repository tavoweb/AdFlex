<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_result extends CI_Model {

    private $_user;
    private $_camp;

    public function camp()
    {
        if (!$this->_camp) {
            $this->_camp = $this->db->get_where(config_item('camps_table'), ['id' => $this->camp_id])->row();
        }

        return $this->_camp;
    }


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


}
