<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bl_sites_model extends CI_Model
{
    private $table;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item("bl_sites_table");
    }


    public function get_bl($camp_id)
    {
        $out = array();

        $this->db->select('site');
        $this->db->where('camp_id', $camp_id);
        $sites = $this->db->get($this->table)->result_array();

        foreach ($sites as $site) {
            $out[] = $site['site'];
        }

        return $out;
    }


    public function set_bl($camp_id, $sites)
    {
        $this->clear_bl($camp_id);
        $new_sites = $this->extract_domains($sites);

        $insert = array();

        foreach ($new_sites as $value) {
            $insert[] = array('camp_id' => $camp_id, 'site' => $value);
        }

        if ($insert) {
            $this->db->insert_batch($this->table, $insert);
            return (bool) $this->db->affected_rows();
        }

        return false;
    }


    public function clear_bl($camp_id)
    {
        $this->db->where('camp_id', $camp_id);
        $this->db->delete($this->table);

        return (bool) $this->db->affected_rows();
    }


    public function append_bl($camp_id, $sites)
    {
        $new_sites = $this->extract_domains($sites);
        $old_sites = $this->get_bl($camp_id);

        if (!$new_sites) {
            return false;
        }

        $new_unique = array_diff($new_sites, $old_sites);

        if (!$new_unique) {
            return false;
        }

        $insert = array();

        foreach ($new_unique as $value) {
            $insert[] = array('camp_id' => $camp_id, 'site' => $value);
        }

        $this->db->insert_batch($this->table, $insert);

        return $this->db->affected_rows();
    }


    public function extract_domains($raw)
    {
        $raw_sites = array();
        $domains = array();

        if (is_array($raw)) {
            $raw_sites = $raw;
        } //
        elseif (is_string($raw)) {
            $raw_sites = preg_split("/[\s,]+/", $raw);
        } //
        else {
            return array();
        }

        foreach ($raw_sites as $site) {

            $site = str_replace(['https://www.', 'http://www.', 'https://', 'http://'], '', $site);

            if (preg_match("/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/", $site)) {
                $domains[] = $site;
            }
        }

        return array_unique($domains);
    }


}
