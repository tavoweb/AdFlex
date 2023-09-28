<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = config_item('tickets_table');
        $this->primary_key  = 'ticket_id';
        $this->result_class = "results/ticket_result";
    }


    public function close($ids, $where = [])
    {
        $this->db->where($where);
        $this->db->where_in('ticket_id', (array) $ids);
        $this->db->set('status', 0);
        $this->db->set('closed_at', gmdate('Y-m-d H:i:s'));
        return $this->db->update($this->table);
    }


    public function open($ids, $where = [])
    {
        $this->db->where($where);
        $this->db->where_in('ticket_id', (array) $ids);
        $this->db->set('status', 1);
        $this->db->set('created_at', gmdate('Y-m-d H:i:s'));
        $this->db->set('closed_at', "");
        return $this->db->update($this->table);
    }


}
