<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Camp_result extends CI_Model {

    private $_user;
    private $_ads;

    public function ads()
    {
        if (!$this->_ads) {
            $this->_ads = $this->db->get_where(config_item('ads_table'), ['camp_id' => $this->id])->result();
        }

        return $this->_ads;
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
