<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webmaster_dashboard_stat_model extends CI_Model {

    public $stat_units_table;
    //
    private $today;
    private $views_clicks_chart;
    private $ctr_chart;
    private $profit_chart;

    public function __construct()
    {
        parent::__construct();

        $this->stat_units_table = config_item('stat_adunits_table');
    }


    public function today()
    {
        if (!$this->today) {

            $this->db->select_sum('views');
            $this->db->select_sum('clicks');
            $this->db->select_sum('profit');
            $this->db->select_avg('ctr');
            $this->db->where('user_id', userdata()->id);
            $this->db->where('date', gmdate('Y-m-d'));

            $this->today = $this->db->get($this->stat_units_table)->row();
        }

        return $this->formatting($this->today);
    }


    public function views_clicks_chart()
    {
        if (!$this->views_clicks_chart) {

            $this->db->select('date');
            $this->db->select_sum('views');
            $this->db->select_sum('clicks');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * 7)));
            $this->db->where('user_id', userdata()->id);
            $this->db->group_by('date');

            $this->views_clicks_chart = $this->db->get($this->stat_units_table)->result();
        }

        return $this->views_clicks_chart;
    }


    public function ctr_chart()
    {
        if (!$this->ctr_chart) {

            $this->db->select('ctr, date');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * 7)));
            $this->db->where('user_id', userdata()->id);
            $this->db->group_by('date, ctr');

            $this->ctr_chart = $this->db->get($this->stat_units_table)->result();
        }

        return $this->ctr_chart;
    }


    public function profit_chart()
    {
        if (!$this->profit_chart) {

            $this->db->select('profit, date');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * 7)));
            $this->db->where('user_id', userdata()->id);
            $this->db->group_by('date, profit');

            $this->profit_chart = $this->db->get($this->stat_units_table)->result();
        }

        return $this->profit_chart;
    }


    private function formatting($obj)
    {
        $out = [];

        foreach ($obj as $key => $value) {
            $out[$key] = number_format($value, 2);
        }

        return (object) $out;
    }


}
