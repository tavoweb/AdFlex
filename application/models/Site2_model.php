<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site2_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('sites_table');
        $this->primary_key = 'site_id';
        $this->status_key = 'status';
        $this->result_class = 'results/site_result';
    }


    public function ban($site_ids, $ban_message)
    {
        $this->db->where_in('site_id', (array) $site_ids);
        $this->db->set('status', -2);
        $this->db->set('status_message', $ban_message);

        return (bool) $this->db->update($this->table);
    }


    public function unban($site_ids)
    {
        $this->db->where_in('site_id', (array) $site_ids);
        $this->db->set('status', 1);
        $this->db->set('status_message', '');

        return (bool) $this->db->update($this->table);
    }


    public function moderate($data, $where)
    {
        $this->db->where($where);

        return (bool) $this->db->update($this->table, $data);
    }


    public function isolate($site_ids, $where = null)
    {
        $this->db->where_in('site_id', (array) $site_ids);
        $this->db->where($where);
        $this->db->set('isolate', 1);

        return (bool) $this->db->update($this->table);
    }


    public function unisolate($site_ids, $where = null)
    {
        $this->db->where_in('site_id', (array) $site_ids);
        $this->db->where($where);
        $this->db->set('isolate', 0);

        return (bool) $this->db->update($this->table);
    }


}
