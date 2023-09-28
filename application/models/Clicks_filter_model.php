<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clicks_filter_model extends CI_Model
{
    private $table;
    private $clicks_per_minute;
    private $clicks_per_hour;
    private $clicks_per_day;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('clicks_filter_table');

        $this->clicks_per_minute = config_item('clicks_per_minute');
        $this->clicks_per_hour   = config_item('clicks_per_hour');
        $this->clicks_per_day    = config_item('clicks_per_day');

        if (rand(0, 10000) == 10000) {
            $this->clear_old_stat();
        }
    }


    /**
     * Проверяет "плохой" ли это клик
     * Клик считается плохим, если с текущего IP, превышено допустимое количество кликов по
     * "паре" - рекламный блок + обьявление, за минуту, час, сутки
     * @param number $ad_id
     * @param number $unit_id
     * @return bool
     */
    public function is_bad_click($ad_id, $unit_id)
    {
        $this->set_click($ad_id, $unit_id);

        if ($this->per_minute($ad_id, $unit_id)) {
            return true;
        }

        if ($this->per_hour($ad_id, $unit_id)) {
            return true;
        }

        if ($this->per_day($ad_id, $unit_id)) {
            return true;
        }

        return false;
    }

    /**
     * Были ли клики с определенного IP, по определенному обьявлению, в определенном блоке за последние 60 секунд.
     * @param number $ad_id
     * @param number $unit_id
     * @return bool
     */
    private function per_minute($ad_id, $unit_id)
    {
        $this->db->where([
            'ad_id'   => $ad_id,
            'unit_id' => $unit_id,
            'long_ip' => $this->request->client_long_ip,
            'date >'  => time() - 60
        ]);

        $this->db->from($this->table);

        return ($this->db->count_all_results() > $this->clicks_per_minute);
    }

    /**
     * Были ли клики с определенного IP, по определенному обьявлению, в определенном блоке за последние 3600 секунд.
     * @param number $ad_id
     * @param number $unit_id
     * @return bool
     */
    private function per_hour($ad_id, $unit_id)
    {
        $this->db->where([
            'ad_id'   => $ad_id,
            'unit_id' => $unit_id,
            'long_ip' => $this->request->client_long_ip,
            'date >'  => time() - 60 * 60
        ]);

        $this->db->from($this->table);

        return ($this->db->count_all_results() > $this->clicks_per_hour);
    }

    /**
     * Были ли клики с определенного IP, по определенному обьявлению, в определенном блоке за последние 86400 секунд.
     * @param number $ad_id
     * @param number $unit_id
     * @return bool
     */
    private function per_day($ad_id, $unit_id)
    {
        $this->db->where([
            'ad_id'   => $ad_id,
            'unit_id' => $unit_id,
            'long_ip' => $this->request->client_long_ip,
            'date >'  => time() - 60 * 60 * 24
        ]);

        $this->db->from($this->table);

        return ($this->db->count_all_results() > $this->clicks_per_day);
    }

    /**
     * Записывает клик в таблицу
     * @param number $ad_id
     * @param number $unit_id
     */
    private function set_click($ad_id, $unit_id)
    {
        $this->db->insert($this->table, [
            'ad_id'   => $ad_id,
            'unit_id' => $unit_id,
            'long_ip' => $this->request->client_long_ip,
            'date'    => gmdate("Y-m-d H:i:s")
        ]);
    }


    /**
     * Очистка всего лога кликов за исключением текущих суток
     */
    private function clear_old_stat()
    {
        $this->db->delete($this->table, [
            'date <' => strtotime("midnight")
        ]);
    }


}
