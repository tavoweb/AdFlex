<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Определение "плохих" показов обьявления и рекламного болока
 */
class Views_filter_model extends CI_Model
{
    private $ad_views_filter_table;
    private $unit_views_filter_table;
    private $ad_views_limit;
    private $unit_views_limit;

    public function __construct()
    {
        parent::__construct();

        $this->ad_views_filter_table   = config_item('ad_views_filter_table');
        $this->unit_views_filter_table = config_item('unit_views_filter_table');

        $this->ad_views_limit   = config_item('ad_views_limit');
        $this->unit_views_limit = config_item('unit_views_limit');

        // clear stat
        if (rand(0, 10000) == 10000) {
            $this->clear_old_stat();
        }
    }

    /**
     * Определяет "плохой" показ обьявления
     * Считает общее количество показов обьявления, с определенного IP, за текущие сутки
     * Если количество показов превысило 'ad_views_limit' - то показ считается плохим
     * @param number $ad_id
     * @param null|int $long_ip
     * @return bool
     */
    public function is_bad_unit_view($unit_id, $long_ip = null)
    {
        $where = [
            'unit_id' => $unit_id,
            'long_ip' => $long_ip ? $long_ip : $this->request->client_long_ip,
            'date'    => gmdate('Y-m-d')
        ];

        $this->db->where($where);

        // это не первый показ этого рекламного блока за сегодня, для текущего IP
        if ($row = $this->db->get($this->unit_views_filter_table)->row()) {

            $this->db->where($where);
            $this->db->set('views', 'views+1', false);
            $this->db->update($this->unit_views_filter_table);

            // если количество показов за сегодня превышают порог, то показ плохой
            if (($row->views + 1) > $this->unit_views_limit) {
                return true;
            }

            return false;
        }

        // первый показ этого рекламного блока за сегодня, для текущего IP
        else {

            $this->db->insert($this->unit_views_filter_table, [
                'unit_id' => $unit_id,
                'long_ip' => $long_ip ? $long_ip : $this->request->client_long_ip,
                'views'   => 1,
                'date'    => gmdate('Y-m-d')
            ]);

            return false;
        }
    }

    /**
     * Определяет "плохой" показ обьявления
     * Считает общее количество показов обьявления, с определенного IP, за текущие сутки
     * Если количество показов превысило 'ad_views_limit' - то показ считается плохим
     * @param number $ad_id
     * @param null|int $long_ip
     * @return bool
     */
    public function is_bad_ad_view($ad_id, $long_ip = null)
    {
        $where = [
            'ad_id'   => $ad_id,
            'long_ip' => $long_ip ? $long_ip : $this->request->client_long_ip,
            'date'    => gmdate('Y-m-d')
        ];

        $this->db->where($where);

        // это не первый показ этого обьявления за сегодня, для текущего IP
        if ($row = $this->db->get($this->ad_views_filter_table)->row()) {

            $this->db->where($where);
            $this->db->set('views', 'views+1', false);
            $this->db->update($this->ad_views_filter_table);

            // если количество показов за сегодня превышают порог, то показ плохой
            if (($row->views + 1) > $this->ad_views_limit) {
                return true;
            }

            return false;
        }

        // первый показ этого обьявления за сегодня, для текущего IP
        else {

            $this->db->insert($this->ad_views_filter_table, [
                'ad_id'   => $ad_id,
                'long_ip' => $long_ip ? $long_ip : $this->request->client_long_ip,
                'views'   => 1,
                'date'    => gmdate('Y-m-d')
            ]);

            return false;
        }
    }

    /**
     * очистка всего лога показов за исключением текущих суток
     */
    private function clear_old_stat()
    {
        $this->db->delete($this->ad_views_filter_table, [
            'date !=' => gmdate('Y-m-d')
        ]);

        $this->db->delete($this->unit_views_filter_table, [
            'date !=' => gmdate('Y-m-d')
        ]);
    }


}
