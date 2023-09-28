<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = config_item('payments_table');
        $this->primary_key  = 'payment_id';
        $this->result_class = 'results/payment_result';
    }


}
