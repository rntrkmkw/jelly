<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Pagination extends CI_Pagination {

    /**
     * 総件数を取得する
     *
     * @return number
     */
    public function get_total_rows() {
        return $this->total_rows;
    }

    /**
     * 管理画面用のページネーション設定を取得する
     */
    public function get_admin_config() {
        $config = array();

        // 管理画面用「Bootstrap3」のデザインを適用
        $config['full_tag_open'] = '<div class="dataTables_paginate paging_simple_numbers"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        $config['prev_tag_open'] = '<li class="paginate_button previous">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="paginate_button  next">';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="paginate_button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="paginate_button active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        return $config;
    }
}
