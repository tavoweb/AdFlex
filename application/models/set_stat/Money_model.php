<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Money_model extends CI_Model
{

    private $money_calculate = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user2_model', "User2");
    }


    public function money($money_calculate = true)
    {
        $this->money_calculate = $money_calculate;
        return $this;
    }


    public function set_view($unit_obj, $ads_obj)
    {
        $webmaster_id = $unit_obj->user()->id;

        foreach ($ads_obj as $ad_obj) {
            $this->set_money_view($webmaster_id, $ad_obj);
        }
    }


    public function set_click($unit_obj, $ad_obj)
    {
        $webmaster_id = $unit_obj->user()->id;
        $this->set_money_click($webmaster_id, $ad_obj);
    }


    private function set_money_view($webmaster_id, $ad_obj)
    {
        if ($this->money_calculate === false) {
            return;
        }

        // списание и зачисление происходит если тип оплаты обьявления - за показы
        if ($ad_obj->payment_mode != "cpv") {
            return;
        }

        // списываем деньги с рекламодателя
        $costs = $ad_obj->cpv / 1000;
        $this->User2->down_advertiser_balance($ad_obj->user_id, $costs);

        // зачисляем на вебмастера (с вычетом комиссии системы)
        $profit = deduct_commission($ad_obj->cpv / 1000);
        $this->User2->up_webmaster_balance($webmaster_id, $profit);
    }


    private function set_money_click($webmaster_id, $ad_obj)
    {
        if ($this->money_calculate === false) {
            return;
        }

        // списание и зачисление происходит если тип оплаты обьявления - за клики
        if ($ad_obj->payment_mode != "cpc") {
            return;
        }

        // списываем деньги с рекламодателя
        $costs = $ad_obj->cpc;
        $this->User2->down_advertiser_balance($ad_obj->user_id, $costs);

        // зачисляем на вебмастера (с вычетом комиссии системы)
        $profit = deduct_commission($ad_obj->cpc);
        $this->User2->up_webmaster_balance($webmaster_id, $profit);
    }


}
