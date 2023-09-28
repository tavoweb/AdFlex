<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard_stat_model extends CI_Model {

    public $stat_advertisers_table;
    public $stat_webmasters_table;
    public $payments_table;
    public $payouts_table;
    //
    private $today;
    private $views_chart;
    private $clicks_chart;
    private $ctr_chart;
    private $payments_chart;
    private $payouts_chart;

    public function __construct()
    {
        parent::__construct();

        $this->stat_advertisers_table = config_item('stat_advertisers_table');
        $this->stat_webmasters_table  = config_item('stat_webmasters_table');
        $this->payments_table         = config_item('payments_table');
        $this->payouts_table          = config_item('payouts_table');
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


    public function views_chart($days = 30)
    {
        if (!$this->views_chart) {

            $this->db->select('date');
            $this->db->select_sum('views');
            $this->db->select_sum('clicks');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * $days)));
            $this->db->group_by('date');

            $this->views_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->views_chart;
    }


    public function clicks_chart($days = 30)
    {
        if (!$this->clicks_chart) {

            $this->db->select('date');
            $this->db->select_sum('views');
            $this->db->select_sum('clicks');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * $days)));
            $this->db->group_by('date');

            $this->clicks_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->clicks_chart;
    }


    public function ctr_chart($days = 30)
    {
        if (!$this->ctr_chart) {

            $this->db->select('date');
            $this->db->select_avg('ctr');
            $this->db->where('date >=', gmdate('Y-m-d', time() - (86400 * $days)));
            $this->db->group_by('date');

            $this->ctr_chart = $this->db->get($this->stat_advertisers_table)->result();
        }

        return $this->ctr_chart;
    }


    public function payments_chart($days = 30)
    {
        if (!$this->payments_chart) {

            $start_date = gmdate('Y-m-d', time() - (86400 * $days));
            $date_col   = "created_at";

            $payments = $this->db->query("
                    SELECT 
                        SUM(amount) AS amount,
                        DATE_FORMAT({$date_col}, '%Y-%m-%d') AS date 
                    FROM 
                        {$this->payments_table} 
                    WHERE 
                        {$date_col} >= {$start_date} 
                    GROUP BY 
                        DATE_FORMAT({$date_col}, '%Y-%m-%d')
            ");

            $this->payments_chart = $payments->result();
        }

        return $this->payments_chart;
    }


    public function payouts_chart($days = 30)
    {
        if (!$this->payouts_chart) {

            $start_date = gmdate('Y-m-d', time() - (86400 * $days));
            $date_col   = "created_at"; //TODO - изменить на completed_at

            $payouts = $this->db->query("
                    SELECT
                        SUM(amount) AS amount,
                        DATE_FORMAT({$date_col}, '%Y-%m-%d') AS date
                    FROM 
                        {$this->payouts_table}
                    WHERE 
                        {$date_col} >= {$start_date}
                    GROUP BY 
                         DATE_FORMAT({$date_col}, '%Y-%m-%d')
            ");

            $this->payouts_chart = $payouts->result();
        }

        return $this->payouts_chart;
    }


    public function fill_dates($days = 30)
    {
        $array   = range(0, $days);
        $counter = 1;

        foreach ($array as &$item) {
            $item = gmdate("Y-m-d", strtotime("-$counter day"));
            $counter++;
        }

        return $array;
    }


}
