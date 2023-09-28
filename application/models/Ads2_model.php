<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ads2_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('image_lib');

        $this->table = config_item('ads_table');
        $this->primary_key = 'ad_id';
        $this->result_class = 'results/ad_result';
    }


    public function delete($ids, $where = [])
    {
        $this->db->where_in($this->primary_key, (array) $ids);
        $this->db->where($where);

        $ads_objects = $this->db->get($this->table)->result();

        foreach ($ads_objects as $ad_obj) {

            // remove ad image
            @unlink(image($ad_obj->filename)->path);

            // remove ad record from table
            $this->db->delete($this->table, [
                $this->primary_key => $ad_obj->{$this->primary_key}
            ]);
        }

        return (bool) $ads_objects;
    }


    public function moderation($ad_id, $status, $status_message = "")
    {
        $this->db->where('ad_id', $ad_id);
        $this->db->set('status', $status);
        $this->db->set('status_message', $status_message);

        event('ads.moderate', ['id' => $ad_id, 'status' => $status]);

        return (bool) $this->db->update($this->table);
    }


    public function upload_image($key, $resize = false)
    {
        $config = [
            'upload_path'   => './' . config_item('images_dir') . '/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size'      => '4092',
            'max_width'     => '8000',
            'max_height'    => '8000',
            'encrypt_name'  => true
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($key)) {

            $image_data = $this->upload->data();

            if ($image_data['is_image'] != 1) {
                @unlink($image_data['full_path']);
                return false;
            }

            list($width, $height) = @getimagesize($image_data['full_path']);

            $new_width = config_item('ads_image_crop_width');
            $new_height = config_item('ads_image_crop_height');

            if ($resize && ($width > $new_width || $height > $new_height)) {

                $this->image_lib->initialize([
                    'maintain_ratio' => false,
                    'source_image'   => $image_data['full_path'],
                    'width'          => $new_width,
                    'height'         => $new_height,
                    'x_axis'         => floor(($width - $new_width) / 2),
                    'y_axis'         => floor(($height - $new_height) / 2),
                ]);

                if (!$this->image_lib->resize()) {
                    return false;
                }
            }

            return [
                'wh'       => intval($width) . "x" . intval($height),
                'width'    => intval($width),
                'height'   => intval($height),
                'filename' => $image_data['file_name'],
                'path'     => $image_data['full_path'],
                'url'      => image($image_data['file_name'])->url
            ];
        }

        return false;
    }


    protected function resize_image($path, $w = 500, $h = 500)
    {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = $w;
        $config['height'] = $h;

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            return false;
        }

        return true;
    }


}
