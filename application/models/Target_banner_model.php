<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Target_banner_model extends CI_Model {

    public $users_table;
    public $camps_table;
    public $ads_table;
    public $bl_sites_table;
    public $selected_columns;

    public function __construct()
    {
        parent::__construct();

        $this->users_table    = config_item('users_table');
        $this->camps_table    = config_item('camps_table');
        $this->ads_table      = config_item('ads_table');
        $this->bl_sites_table = config_item('bl_sites_table');

        $this->selected_columns = [
            "{$this->ads_table}.filename",
            "{$this->ads_table}.img_width",
            "{$this->ads_table}.img_height",
            "{$this->ads_table}.hash_id"
        ];
    }


    public function get($unit_obj)
    {
        $is_isolated_site = $unit_obj->site()->isolated;


        $this->db->select($this->selected_columns);
        $this->db->from($this->ads_table);
        $this->db->join($this->camps_table, "{$this->camps_table}.id = {$this->ads_table}.camp_id");
        $this->db->join($this->users_table, "{$this->users_table}.id = {$this->camps_table}.user_id");

        //---------------------------------------------------------------------------------------------

        if (!$is_isolated_site) {
            $this->db->where("{$this->users_table}.status", 1); // только юзеры со статусом 1 (активные)
            $this->db->where("{$this->users_table}.advertiser_balance >", 0); // только юзеры с положительным балансом рекламодателя             
        }

        //---------------------------------------------------------------------------------------------
        // статус кампании 1 (активная)
        $this->db->where("{$this->camps_table}.status", 1);


        if ($unit_obj->site()->isolated) {
            // кампания изолированная или нет (указано в условии)
            $this->db->where("{$this->camps_table}.isolated", 1);
        } else {
            $this->db->where("{$this->camps_table}.isolated", 0);

            if (config_item('show_own_camps') !== true) {
                // отсекаем юзера - владельца сайта.
                // Это нужно для того что бы юзер не показывал свои рекламные кампании на своем же сайте
                $this->db->where("{$this->users_table}.id !=", $unit_obj->user_id);
            }
        }

        // Чекаем текущий сайт на наличие в БЛ кампании ---------------------------------------------------------------------------------------------

        $subquery = "SELECT DISTINCT camp_id FROM {$this->bl_sites_table} WHERE site = '{$this->db->escape_str($unit_obj->site()->domain)}'";
        $this->db->where("{$this->camps_table}.id NOT IN ({$subquery})", null, false);
        //---------------------------------------------------------------------------------------------
        $this->db->like("{$this->camps_table}.allowed_site_themes", $unit_obj->site()->theme); // тематика сайта присутствует в списке разрешенных для показа тематик кампании
        $this->db->where("INSTR('{$this->db->escape_str($unit_obj->site()->allowed_camp_themes)}', {$this->camps_table}.theme) > 0"); // тематика кампании присутствует в списке разрешенных для показа тематик сайта
        //---------------------------------------------------------------------------------------------
        $this->db->where("{$this->camps_table}.start_date <", gmdate('Y-m-d H:i:s'));
        $this->db->where("{$this->camps_table}.end_date >", gmdate('Y-m-d H:i:s'));
        $this->db->like("{$this->camps_table}.days", gmdate('N'));
        $this->db->like("{$this->camps_table}.hours", gmdate('H'));
        //---------------------------------------------------------------------------------------------
        if (config_item('enable_geotargeting') === true) {
            $this->db->like("{$this->camps_table}.geos", $this->request::allinfo()->geodata->alfa2);
        }

        $this->db->like("{$this->camps_table}.devs", $this->request::allinfo()->device_type);
        $this->db->like("{$this->camps_table}.platforms", $this->request::allinfo()->platform);
        $this->db->like("{$this->camps_table}.browsers", $this->request::allinfo()->browser);
        //---------------------------------------------------------------------------------------------


        $this->db->where("{$this->ads_table}.type", "banner");
        $this->db->where("{$this->ads_table}.status", 1); // только активные баннеры
        $this->db->where("{$this->ads_table}.img_wh", $unit_obj->banner_size); // только баннеры с размером указанным в условии
        // get only CPC banners
        if ($unit_obj->allowed_payments == "cpc") {

            $this->db->where("{$this->ads_table}.payment_mode", "cpc");
            $this->db->where("{$this->ads_table}.cpc >=", $unit_obj->min_cpc);
        }

        // get only CPV banners
        else if ($unit_obj->allowed_payments == "cpv") {

            $this->db->where("{$this->ads_table}.payment_mode", "cpv");
            $this->db->where("{$this->ads_table}.cpv >=", $unit_obj->min_cpv);
        }

        // get CPC or CPV banners
        else {

            $this->db->group_start()->group_start(); // ((

            $this->db->where([
                "{$this->ads_table}.payment_mode" => "cpc",
                "{$this->ads_table}.cpc >="       => $unit_obj->min_cpc
            ]);

            $this->db->group_end()->or_group_start(); // ) OR (

            $this->db->where([
                "{$this->ads_table}.payment_mode" => "cpv",
                "{$this->ads_table}.cpv >="       => $unit_obj->min_cpv
            ]);

            $this->db->group_end()->group_end(); // ))
        }

        $this->db->order_by("{$this->ads_table}.ad_id", 'random'); // get one random banner

        if ($result = $this->db->limit(1)->get()->row()) {
            $result->img_url = image($result->filename)->url;
            unset($result->filename);
            return $result;
        }

        return null;
    }


}
