<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payout2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = config_item('payouts_table');
        $this->primary_key  = 'id';
        $this->result_class = 'results/payout_result';
    }


}
