<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Camp2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table       = config_item('camps_table');
        $this->primary_key = 'id';
        $this->status_key  = 'status';
        $this->result_class = 'results/camp_result';
    }


}
