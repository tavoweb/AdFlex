<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat_advertiser_model extends CI_Model {

    private $table;
    private $money_calculate = true;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('stat_advertisers_table');
    }

    
    public function money($money_calculate = true)
    {
        $this->money_calculate = $money_calculate;
        return $this;
    }
    

    public function set_view($unit_obj, $ads_obj)
    {
        foreach ($ads_obj as $ad_obj) {
            $this->set_advertiser_view($ad_obj);
        }
    }


    private function set_advertiser_view($ad_obj)
    {
        $advert_obj = $ad_obj->user();

        $where = [
            'user_id' => $advert_obj->id,
            'date'    => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $views = $row->views + 1;
            $ctr   = calculate_ctr($views, $row->clicks);
            $costs = $this->calculate_view_costs($row->costs, $ad_obj);
            $cpm   = calculate_cpm($costs, $views);

            $this->db->where([
                'user_id' => $advert_obj->id,
                'date'    => gmdate('Y-m-d')
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
                'user_id' => $advert_obj->id,
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
        $advert_obj = $ad_obj->user();

        $where = [
            'user_id' => $advert_obj->id,
            'date'    => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $clicks = $row->clicks + 1;
            $ctr    = calculate_ctr($row->views, $clicks);
            $costs  = $this->calculate_click_costs($row->costs, $ad_obj);
            $cpm    = calculate_cpm($costs, $row->views);

            $this->db->where([
                'user_id' => $advert_obj->id,
                'date'    => gmdate('Y-m-d')
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
                'user_id' => $advert_obj->id,
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
