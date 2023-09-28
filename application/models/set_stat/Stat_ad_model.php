<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat_ad_model extends CI_Model {

    private $table;
    private $money_calculate = true;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('stat_ads_table');
    }


    public function money($money_calculate = true)
    {
        $this->money_calculate = $money_calculate;
        return $this;
    }


    public function set_view($unit_obj, $ads_obj)
    {
        foreach ($ads_obj as $ad_obj) {
            $this->set_ad_view($ad_obj);
        }
    }


    private function set_ad_view($ad_obj)
    {
        $where = [
            'ad_id' => $ad_obj->ad_id,
            'date'  => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $views = $row->views + 1;
            $ctr   = calculate_ctr($views, $row->clicks);
            $costs = $this->calculate_view_costs($row->costs, $ad_obj);
            $cpm   = calculate_cpm($costs, $views);

            $this->db->where([
                'ad_id' => $ad_obj->ad_id,
                'date'  => gmdate('Y-m-d')
            ]);

            $this->db->update($this->table, [
                'views' => $views,
                'ctr'   => $ctr,
                'costs' => $costs,
                'cpm'   => $cpm,
            ]);
        }

        //
        else {

            $costs = $this->calculate_view_costs(0, $ad_obj);
            $cpm   = calculate_cpm($costs, 1);

            $this->db->insert($this->table, [
                'ad_id'   => $ad_obj->ad_id,
                'camp_id' => $ad_obj->camp()->id,
                'user_id' => $ad_obj->user()->id,
                'views'   => 1,
                'clicks'  => 0,
                'ctr'     => 0,
                'costs'   => $costs,
                'cpm'     => $cpm,
                'date'    => gmdate('Y-m-d')
            ]);
        }
    }


    public function set_click($unit_obj, $ad_obj)
    {
        $where = [
            'ad_id' => $ad_obj->ad_id,
            'date'  => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $clicks = $row->clicks + 1;
            $ctr    = calculate_ctr($row->views, $clicks);
            $costs  = $this->calculate_click_costs($row->costs, $ad_obj);
            $cpm    = calculate_cpm($costs, $row->views);

            $this->db->where([
                'ad_id' => $ad_obj->ad_id,
                'date'  => gmdate('Y-m-d')
            ]);

            $this->db->update($this->table, [
                'clicks' => $clicks,
                'ctr'    => $ctr,
                'costs'  => $costs,
                'cpm'    => $cpm,
            ]);
        }

        //
        else {

            $costs = $this->calculate_click_costs(0, $ad_obj);
            $cpm   = calculate_cpm($costs, 1);

            $this->db->insert($this->table, [
                'ad_id'   => $ad_obj->ad_id,
                'camp_id' => $ad_obj->camp()->id,
                'user_id' => $ad_obj->user()->id,
                'views'   => 0,
                'clicks'  => 1,
                'ctr'     => 0,
                'costs'   => $costs,
                'cpm'     => $cpm,
                'date'    => gmdate('Y-m-d')
            ]);
        }
    }


    private function calculate_view_costs($current_costs, $ad_obj)
    {
        if ($this->money_calculate === false) {
            return round($current_costs);
        }

        $costs = 0;

        if ($ad_obj->payment_mode == "cpv") {
            $costs = $ad_obj->cpv / 1000;
        }

        return round($current_costs + $costs, 5);
    }


    private function calculate_click_costs($current_costs, $ad_obj)
    {
        if ($this->money_calculate === false) {
            return round($current_costs);
        }

        $costs = 0;

        if ($ad_obj->payment_mode == "cpc") {
            $costs = $ad_obj->cpc;
        }

        return round($current_costs + $costs, 5);
    }


}
