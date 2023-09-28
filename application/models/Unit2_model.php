<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = config_item('adunits_table');
        $this->primary_key  = 'unit_id';
        $this->status_key   = 'status';
        $this->result_class = 'results/unit_result';
    }


}
