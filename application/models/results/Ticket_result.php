<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_result extends CI_Model {

    private $_messages;
    private $_count_messages;
    private $_count_unread_messages;

    public function messages()
    {
        if (!$this->_messages) {
            $this->_messages = $this->db->get_where(config_item('messages_table'), ['ticket_id' => $this->ticket_id])->result();
        }

        return $this->_messages;
    }


    public function count_messages()
    {
        if (!$this->_count_messages) {

            $this->db->where(['ticket_id' => $this->ticket_id]);
            $this->db->from(config_item('messages_table'));
            $this->_count_messages = $this->db->count_all_results();
        }

        return $this->_count_messages;
    }


    public function count_unread_messages($user_id)
    {
        if (!$this->_count_unread_messages) {

            $this->db->where([
                'ticket_id'  => $this->ticket_id,
                'user_id !=' => $user_id,
                'read_at'    => null
            ]);

            $this->db->from(config_item('messages_table'));
            $this->_count_unread_messages = $this->db->count_all_results();
        }

        return $this->_count_unread_messages;
    }


}
