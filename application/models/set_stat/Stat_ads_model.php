<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat_ads_model extends CI_Model {

    private $table;
    private $money_calculate = true;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('ads_table');
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
        $views = $ad_obj->views + 1;
        $ctr   = calculate_ctr($views, $ad_obj->clicks);
        $costs = $this->calculate_view_costs($ad_obj->costs, $ad_obj);
        $cpm   = calculate_cpm($costs, $views);

        $this->db->where([
            'ad_id' => $ad_obj->ad_id
        ]);

        $this->db->update($this->table, [
            'views' => $views,
            'ctr'   => $ctr,
            'costs' => $costs,
            'cpm'   => $cpm,
        ]);
    }


    public function set_click($unit_obj, $ad_obj)
    {
        $clicks = $ad_obj->clicks + 1;
        $ctr    = calculate_ctr($ad_obj->views, $clicks);
        $costs  = $this->calculate_click_costs($ad_obj->costs, $ad_obj);
        $cpm    = calculate_cpm($costs, $ad_obj->views);

        $this->db->where([
            'ad_id' => $ad_obj->ad_id
        ]);

        $this->db->update($this->table, [
            'clicks' => $clicks,
            'ctr'    => $ctr,
            'costs'  => $costs,
            'cpm'    => $cpm,
        ]);
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
