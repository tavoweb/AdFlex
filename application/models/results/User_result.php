<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_result extends CI_Model {

    private $_sites;
    private $_units;
    private $_camps;
    private $_ads;
    private $_tickets;
    private $_messages;

    public function sites()
    {
        if (!$this->_sites) {
            $this->_sites = $this->db->get_where(config_item('sites_table'), ['user_id' => $this->id])->result();
        }

        return $this->_sites;
    }


    public function units()
    {
        if (!$this->_units) {
            $this->_units = $this->db->get_where(config_item('adunits_table'), ['user_id' => $this->id])->result();
        }

        return $this->_units;
    }


    public function camps()
    {
        if (!$this->_camps) {
            $this->_camps = $this->db->get_where(config_item('camps_table'), ['user_id' => $this->id])->result();
        }

        return $this->_camps;
    }


    public function ads()
    {
        if (!$this->_ads) {
            $this->_ads = $this->db->get_where(config_item('ads_table'), ['user_id' => $this->id])->result();
        }

        return $this->_ads;
    }


    public function tickets()
    {
        if (!$this->_tickets) {
            $this->_tickets = $this->db->get_where(config_item('tickets_table'), ['user_id' => $this->id])->result();
        }

        return $this->_tickets;
    }


    public function messages()
    {
        if (!$this->_messages) {
            $this->_messages = $this->db->get_where(config_item('messages_table'), ['user_id' => $this->id])->result();
        }

        return $this->_messages;
    }


}
