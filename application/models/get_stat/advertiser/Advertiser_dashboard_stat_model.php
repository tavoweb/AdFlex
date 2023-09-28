<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertiser_dashboard_stat_model extends CI_Model {

    public $stat_advertisers_table;
    //
    private $today;
    private $views_clicks_chart;
    private $ctr_chart;
    private $costs_chart;

    public function __construct()
    {
        parent::__construct();

        $this->stat_advertisers_table = config_item('stat_advertisers_table');
    }


    public function today()
    {
        if (!$this->today) {

            $this->db->select_sum('views');
            $this->db->select_sum('clicks');
            $this->db->select_sum('costs');
            $this->db->select_avg('ctr');
            $this->db->where('user_id', userdata()->id);
            $this->db->where('date', gmdate('Y-m-d'));

            $this->today = $this->db->get($this->stat_advertisers_table)->row();
        }

        return $this->today;
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

            $this->views_clicks_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->views_clicks_chart;
    }


    public function ctr_chart()
    {
        if (!$this->ctr_chart) {

            $this->db->select('date, ctr');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * 7)));
            $this->db->where('user_id', userdata()->id);
            $this->db->group_by('date, ctr');

            $this->ctr_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->ctr_chart;
    }


    public function costs_chart()
    {
        if (!$this->costs_chart) {

            $this->db->select('costs, date');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * 7)));
            $this->db->where('user_id', userdata()->id);
            $this->db->group_by('date, costs');

            $this->costs_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->costs_chart;
    }


}
