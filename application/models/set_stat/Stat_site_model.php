<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stat_site_model extends CI_Model
{

    private $table;
    private $money_calculate = true;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('stat_sites_table');
    }


    public function money($money_calculate = true)
    {
        $this->money_calculate = $money_calculate;
        return $this;
    }


    public function set_view($unit_obj, $ads_obj = null)
    {
        $site_obj = $unit_obj->site();

        $where = [
            'site_id' => $site_obj->site_id,
            'date'    => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $views  = $row->views + 1;
            $ctr    = calculate_ctr($views, $row->clicks);
            $profit = $this->calculate_view_profit($row->profit, $ads_obj);
            $cpm    = calculate_cpm($profit, $views);

            $this->db->where([
                'site_id' => $site_obj->site_id,
                'date'    => gmdate('Y-m-d')
            ]);

            $this->db->update($this->table, [
                'views'  => $views,
                'ctr'    => $ctr,
                'profit' => $profit,
                'cpm'    => $cpm,
            ]);
        } //
        else {

            $profit = $this->calculate_view_profit(0, $ads_obj);
            $cpm    = calculate_cpm($profit, 1);

            $this->db->insert($this->table, [
                'user_id' => $unit_obj->user()->id,
                'site_id' => $site_obj->site_id,
                'views'   => 1,
                'clicks'  => 0,
                'ctr'     => 0,
                'profit'  => $profit,
                'cpm'     => $cpm,
                'date'    => gmdate('Y-m-d')
            ]);
        }
    }


    public function set_click($unit_obj, $ad_obj = null)
    {
        $site_obj = $unit_obj->site();

        $where = [
            'site_id' => $site_obj->site_id,
            'date'    => gmdate('Y-m-d')
        ];

        if ($row = $this->db->get_where($this->table, $where)->row()) {

            $clicks = $row->clicks + 1;
            $ctr    = calculate_ctr($row->views, $clicks);
            $profit = $this->calculate_click_profit($row->profit, $ad_obj);
            $cpm    = calculate_cpm($profit, $row->views);

            $this->db->where([
                'site_id' => $site_obj->site_id,
                'date'    => gmdate('Y-m-d')
            ]);

            $this->db->update($this->table, [
                'clicks' => $clicks,
                'ctr'    => $ctr,
                'profit' => $profit,
                'cpm'    => $cpm,
            ]);
        } //
        else {

            $profit = $this->calculate_click_profit(0, $ad_obj);
            $cpm    = calculate_cpm($profit, 1);

            $this->db->insert($this->table, [
                'user_id' => $unit_obj->user()->id,
                'site_id' => $site_obj->site_id,
                'views'   => 0,
                'clicks'  => 1,
                'ctr'     => 0,
                'profit'  => $profit,
                'cpm'     => $cpm,
                'date'    => gmdate('Y-m-d')
            ]);
        }
    }


    private function calculate_view_profit($current_profit, $ads_obj = null)
    {
        if (!$ads_obj) {
            return 0;
        }

        if ($this->money_calculate === false) {
            return round($current_profit);
        }

        $profit = 0;

        foreach ($ads_obj as $ad_obj) {

            if ($ad_obj->payment_mode == "cpv") {
                $profit += $ad_obj->cpv / 1000;
            }
        }

        // отнимаем комиссию системы
        $profit = deduct_commission($profit);

        return round($current_profit + $profit, 5);
    }


    private function calculate_click_profit($current_profit, $ad_obj = null)
    {
        if (!$ad_obj) {
            return 0;
        }

        if ($this->money_calculate === false) {
            return round($current_profit);
        }

        $profit = 0;

        if ($ad_obj->payment_mode == "cpc") {
            $profit = deduct_commission($ad_obj->cpc);
        }

        return round($current_profit + $profit, 5);
    }


}
