<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table       = config_item('messages_table');
        $this->primary_key = 'message_id';
    }


    public function seen($message_id)
    {
        $this->db->where('message_id', $message_id);
        $this->db->set('read_at', gmdate('Y-m-d H:i:s'));
        $this->db->update($this->table);

        return (bool) $this->db->affected_rows();
    }


}
