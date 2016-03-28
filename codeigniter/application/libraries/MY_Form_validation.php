<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Form_validation extends CI_Form_validation {

    /**
     * Initialize Form_Validation class
     *
     * @param array $rules
     * @return void
     */
    public function __construct($rules = array()) {
        parent::__construct($rules);
    }

    // --------------------------------------------------------------------
    /**
     * テストバリデーション
     *
     * @return boolean
     */
    public function sample($str) {
        $this->CI->load->model('page_layout_model');
        // DBからページレイアウト情報を取得する
        $block_list = $this->CI->page_layout_model->getPageLayout($this->CI->page_layout);

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 配送先名所重複チェック
     *
     * @param unknown $address_type
     */
    public function dup_buyer_destination_address_type($address_type) {
        $buyer_id = $this->CI->login_customer_id;
        // $address_type = $this->CI->input->post('address_type');

        // モデルロード
        $this->CI->load->model('buyer_destination_model');
        if ($this->CI->buyer_destination_model->is_address_type($buyer_id, $address_type)) {
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    /**
     * メールアドレスが販売者情報に存在するかチェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function exist_seller_info_mail($mail) {

        // モデルロード
        $this->CI->load->model('seller_info_model');
        // ログインID取得
        $login_id = $this->CI->seller_info_model->get_login_id_by_email($mail);

        if (empty($login_id)) {
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    /**
     * メールアドレスがアフィリエイター情報に存在するかチェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function exist_afi_info_mail($mail) {

        // モデルロード
        $this->CI->load->model('afi_info_model');
        // ログインID取得
        $login_id = $this->CI->afi_info_model->get_login_id_by_email($mail);

        if (empty($login_id)) {
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    /**
     * 購入者のメールアドレスの存在チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function exist_buyer_mail($mail) {

        // モデルロード
        $this->CI->load->model('buyer_info_model');
        // ログインID取得
        $data = $this->CI->buyer_info_model->get_login_info($mail);

        if (empty($data)) {
            return false;
        }
        return true;
    }

        // --------------------------------------------------------------------
    /**
     * 購入者のメールアドレスの重複チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_buyer_mail($mail) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('buyer_info_model');
        // ログインID取得
        $data = $this->CI->buyer_info_model->get_login_info($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // ログインチェック
        if ($CI->it_login->check_login_status(APPLICATION_VIEW_ATTRIBUTE__BUYER)){
            // 重複があった場合は自分のメールアドレスかチェック
            if ($data['login_id'] == $CI->login_session_data['info']['login_id']){
                return true;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 購入者のメールアドレスの重複チェック(管理画面)
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_buyer_mail_admin($mail) {
        $customer_id = $this->CI->input->post('customer_id');

        // モデルロード
        $this->CI->load->model('buyer_info_model');
        // ログインID取得
        $data = $this->CI->buyer_info_model->get_id_by_email($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // 重複があった場合は自分のメールアドレスかチェック
        if ($data['customer_id'] == $customer_id){
            return true;
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 無料オファー登録のメールアドレスの存在チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_free_offer_mail($mail) {

        // モデルロード
        $this->CI->load->model('free_offer_user_model');
        // ログインID取得
        $data = $this->CI->free_offer_user_model->check_mail($mail);

        if (empty($data)) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 無料オファー登録のIPアドレスの存在チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_free_offer_ip_address($ip_address) {

        // モデルロード
        $this->CI->load->model('free_offer_user_model');
        // ログインID取得
        $data = $this->CI->free_offer_user_model->check_ip_address($ip_address);

        if (empty($data)) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 販売者のメールアドレスの重複チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_seller_mail($mail) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('seller_info_model');
        // ログインID取得
        $data = $this->CI->seller_info_model->get_login_id_by_email($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // ログインチェック
        if ($CI->it_login->check_login_status(APPLICATION_VIEW_ATTRIBUTE__SELLER)){
            // 重複があった場合は自分のメールアドレスかチェック
            if ($data['login_id'] == $CI->login_session_data['info']['login_id']){
                return true;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 販売者のメールアドレスの重複チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_seller_mail_with_tmp($mail) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('seller_info_model');
        // ログインID取得
        $data = $this->CI->seller_info_model->get_login_id_by_email_with_tmp($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // ログインチェック
        if ($CI->it_login->check_login_status(APPLICATION_VIEW_ATTRIBUTE__SELLER)){
            // 重複があった場合は自分のメールアドレスかチェック
            if ($data['login_id'] == $CI->login_session_data['info']['login_id']){
                return true;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 日付の妥当性チェック(Y-m-d H:i:s)
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_date($date) {
        return $this->valid_date_custom($date, 'Y-m-d H:i:s');
    }

    // --------------------------------------------------------------------
    /**
     * 指定した型での日付の妥当性チェック
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @param unknown $format
     * @return boolean
     */
    public function valid_date_custom($date, $format) {
        // 指定された年月日時分秒を日付型へ変換
        $date_time = DateTime::createFromFormat($format, $date);

        // エラー情報取得
        $errors = DateTime::getLastErrors();

        // エラーチェック
        if (empty($date_time) || $errors['warning_count'] != 0 || $errors['error_count'] != 0) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 日付の妥当性チェック(yyyy-mm-dd)
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_date_ymd($date) {
        // 指定された年月日を日付型へ変換
        $date_time = DateTime::createFromFormat('Y-m-d', $date);

        // エラー情報取得
        $errors = DateTime::getLastErrors();

        // エラーチェック
        if (empty($date_time) || $errors['warning_count'] != 0 || $errors['error_count'] != 0) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 日付の妥当性チェック(yyyy/mm/dd)
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_date_ymd_slash($date) {
        // 指定された年月日を日付型へ変換
        $date_time = DateTime::createFromFormat('Y/m/d', $date);

        // エラー情報取得
        $errors = DateTime::getLastErrors();

        // エラーチェック
        if (empty($date_time) || $errors['warning_count'] != 0 || $errors['error_count'] != 0) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 日付の妥当性チェック(yyyy/mm)
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_date_ym_slash($date) {
        // 指定された年月日を日付型へ変換
        $date_time = DateTime::createFromFormat('Y/m', $date);

        // エラー情報取得
        $errors = DateTime::getLastErrors();

        // エラーチェック
        if (empty($date_time) || $errors['warning_count'] != 0 || $errors['error_count'] != 0) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 年の妥当性チェック
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_date_y($date) {
        // 年以降にダミー月日を連結してチェック
        $status = $this->valid_date($date. '-01-01 00:00:00');

        return $status;
    }

    // --------------------------------------------------------------------
    /**
     * 時間の妥当性チェック
     * ※日付オブジェクトの生成に成功した場合はOK
     *
     * @param unknown $time
     * @return boolean
     */
    public function valid_time($time) {
        // 5桁（00:00しかない）時に秒をつける
        if(mb_strlen($time) == 5){
            $time_8 = $time. ':00';
        }else{
            $time_8 = $time;
        }

        // 年月日と合わせて日付に変換し、妥当性をチェックする
        $date = '2000-01-01 '.$time_8;
        $status = $this->valid_date($date);
        return $status;
    }

    // --------------------------------------------------------------------
    /**
     * 電話・FAX・携帯番号チェック
     *
     * @param unknown $tel_no
     * @return boolean
     */
    public function valid_tel_no($tel_no) {
        // 指定なしの場合はエラーにしない
        if (empty($tel_no)) {
            return true;
        }

        // ハイフンの数を取得
        $count = mb_substr_count($tel_no, '-');
        switch ($count){
            case 0:
            case 1:
            case 2:
                // 数字orハイフンのみ許容する
                if (! preg_match("/^[0-9-]+$/", $tel_no)) {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 郵便番号7桁チェック
     * ※ハイフンあり・なし対応版
     * @param unknown $post_code
     * @return boolean
     */
    public function valid_post_code_all($post_code) {
        // ハイフンの数を取得
        $count = mb_substr_count($post_code, '-');
        switch ($count){
            case 1:
                // ハイフンの位置チェック
                if (strpos($post_code, '-') != 3){
                    return false;
                }
                $post_code = str_replace('-', '', $post_code);
            case 0:
                // 文字数チェック
                if (!$this->exact_length($post_code, 7)){
                    return false;
                }
                // 使用文字チェック
                if (! preg_match("/^[0-9-]+$/", $post_code)) {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイターのメールアドレスの重複チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_afi_mail($mail) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('afi_info_model');
        // ログインID取得
        $data = $this->CI->afi_info_model->get_login_id_by_email($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // ログインチェック
        if ($CI->it_login->check_login_status(APPLICATION_VIEW_ATTRIBUTE__AFI)){
            // 重複があった場合は自分のメールアドレスかチェック
            if ($data['login_id'] == $CI->login_session_data['info']['login_id']){
                return true;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイターのメールアドレスの重複チェック
     *
     * @param unknown $mail
     * @return boolean
     */
    public function dup_afi_mail_with_tmp($mail) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('afi_info_model');
        // ログインID取得
        $data = $this->CI->afi_info_model->get_login_id_by_email_with_tmp($mail);

        // 指定メールでの重複がない場合
        if (empty($data)) {
            return true;
        }

        // ログインチェック
        if ($CI->it_login->check_login_status(APPLICATION_VIEW_ATTRIBUTE__AFI)){
            // 重複があった場合は自分のメールアドレスかチェック
            if ($data['login_id'] == $CI->login_session_data['info']['login_id']){
                return true;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 金融機関の存在チェック
     *
     * @param unknown $financial_id
     * @return boolean
     */
    public function exist_financial_id($financial_id) {

        //連結されたidを分割する
        $sliced_id = slice_bank($financial_id);

        if(empty($sliced_id['bank_id']) && empty($sliced_id['branch_id'])){
            return false;
        }else{
            // モデルロード
            $this->CI->load->model('mst_bank_branch_model');

            // 金融機関情報取得
            $data = $this->CI->mst_bank_branch_model->get_branch_data($sliced_id['branch_id']);

            if (empty($data)) {
                return false;
            }else{
                if($data['bank_id'] != $sliced_id['bank_id']){
                    return false;
                }
            }
        }
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 期間入力の妥当性チェック
     *
     * @param unknown $date
     * @return boolean
     */
    public function valid_period_date($date) {
        // エラーチェック
        if ($date === date("Y/m/d", strtotime($date))) {
            return true;
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * URL文字列チェック
     *
     * @param unknown $url_string
     * @return boolean
     */
    public function valid_url_string($url_string) {
        $match_url_regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        if (!preg_match($match_url_regex, $url_string)) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 国コードの存在チェック
     *
     * @param unknown $country_code
     * @return boolean
     */
    public function exist_country_code($country_code) {
        // モデルロード
        $this->CI->load->model('mst_country_model');

        // 国情報取得
        $data = $this->CI->mst_country_model->get_country_info_by_code($country_code);

        if (empty($data)) {
            return false;
        }
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 国IDの存在チェック
     *
     * @param unknown $mst_country_id
     * @return boolean
     */
    public function exist_country_id($mst_country_id) {
        // モデルロード
        $this->CI->load->model('mst_country_model');

        // 国情報取得
        $data = $this->CI->mst_country_model->get_country_info($mst_country_id);
        if (empty($data)) {
            return false;
        }
        return true;
    }



    // --------------------------------------------------------------------
    /**
     * 都道府県IDの存在チェック
     *
     * @param unknown $mst_state_id
     * @return boolean
     */
    public function exist_state_id($mst_state_id) {
        // モデルロード
        $this->CI->load->model('mst_state_model');

        // 国情報取得
        $data = $this->CI->mst_state_model->get_state_info($mst_state_id);

        if (empty($data)) {
            return false;
        }
        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 都道府県名の存在チェック
     *
     * @param unknown $state_name
     * @return boolean
     */
    public function exist_state_name($state_name) {
        $state_name_list = array("北海道" , "青森県" , "岩手県" , "宮城県" , "秋田県" , "山形県" , "福島県" , "茨城県" , "栃木県" , "群馬県" , "埼玉県" , "千葉県" , "東京都" , "神奈川県" , "新潟県" , "富山県" , "石川県" , "福井県" , "山梨県" , "長野県" , "岐阜県" , "静岡県" , "愛知県" , "三重県" , "滋賀県" , "京都府" , "大阪府" , "兵庫県" , "奈良県" , "和歌山県" , "鳥取県" , "島根県" , "岡山県" , "広島県" , "山口県" , "徳島県" , "香川県" , "愛媛県" , "高知県" , "福岡県" , "佐賀県" , "長崎県" , "熊本県" , "大分県" , "宮崎県" , "鹿児島県" , "沖縄県");

        if (!in_array($state_name, $state_name_list)) {
            return false;
        }
        return true;
    }



    // --------------------------------------------------------------------
    /**
     * 管理者ログインID重複チェック
     *
     * @param unknown $address_type
     */
    public function dup_admin_account_login_id($login_id) {

        // モデルロード
        $this->CI->load->model('admin_account_model');
        if ($this->CI->admin_account_model->is_login_id($login_id)) {
            return false;
        } else {
            return true;
        }
    }
    // --------------------------------------------------------------------
    /**
     * お気に入り存在チェック
     *
     * @param unknown $address_type
     */
    public function exist_item_favorite($item_id) {

        // モデルロード
        $this->CI->load->model('buyer_favorites_model');
        if ($this->CI->buyer_favorites_model->exist_item_favorite($this->CI->login_customer_id, $item_id)) {
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    /**
     * 支店新規追加の適用終了日時が妥当かチェック
     *
     * @param unknown $apply_end_ymd
     * @return boolean
     */
    public function valid_date_end_regist($apply_end_ymd) {
        $mst_bank_id     = $this->CI->input->post('mst_bank_id');
        $branch_code = $this->CI->input->post('branch_code');

        // 他に有効なデータがあればその最新データの終了日時の翌日以降、なければ過去の最新データの終了日時の翌日ならばtrueを返す
        // モデルロード
        $this->CI->load->model('mst_bank_branch_model');

        $available_data = $this->CI->mst_bank_branch_model->branch_code_exist($mst_bank_id, $branch_code);
        if(! empty($available_data)) {
            if($apply_end_ymd > date('Y-m-d', strtotime($available_data[0]['apply_end_ymd']))) {
                return true;
            } else {
                return false;
            }
        }

        $archive_data = $this->CI->mst_bank_branch_model->branch_code_archive($mst_bank_id, $branch_code);
        if(! empty($archive_data)) {
            if($apply_end_ymd == date('Y-m-d', strtotime($archive_data['apply_end_ymd'] . '+1day'))) {
                return true;
            } else {
                return false;
            }
        }

        if($apply_end_ymd > conv_date_Ymd($this->CI->current_date)) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 支店変更の適用終了日時が妥当かチェック
     *
     * @param unknown $apply_end_ymd
     * @return boolean
     */
    public function valid_date_end_update($apply_end_ymd) {
        $id              = $this->CI->input->post('id');
        $mst_bank_id     = $this->CI->input->post('mst_bank_id');
        $branch_code     = $this->CI->input->post('branch_code');
        $apply_start_ymd = $this->CI->input->post('apply_start_ymd');

        // 適用開始日時より前だったらその時点でfalseを返す
        if(! ($apply_start_ymd < $apply_end_ymd)) {
            return false;
        }

        // 自身の他に最新の有効なデータがあればその最新データの開始日時以前の日付、なければ適用開始日時以降の日付ならばtrueを返す
        // モデルロード
        $this->CI->load->model('mst_bank_branch_model');
        $available_data = $this->CI->mst_bank_branch_model->branch_code_exist_other($id, $mst_bank_id, $branch_code, $apply_start_ymd);

        if(! empty($available_data)) {
            if($apply_end_ymd < date('Y-m-d', strtotime($available_data[0]['apply_start_ymd']))) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    /**
     * 支店変更の移行先支店コードが存在するかチェック
     *
     * @param unknown $branch_destination
     * @return boolean
     */
    public function exist_branch_code($branch_destination) {
        $mst_bank_id = $this->CI->input->post('mst_bank_id');

        // モデルロード
        $this->CI->load->model('mst_bank_branch_model');
        // 適用終了日が過ぎている支店を除いた支店情報を取得する
        $data = $this->CI->mst_bank_branch_model->branch_code_exist($mst_bank_id, $branch_destination);
        // 支店が存在しない場合はエラー
        if(empty($data)) {
            return false;
        }

        // 変更する支店の適用終了日を取得
        $apply_end_ymd = $this->CI->input->post('apply_end_ymd');

        // 変更する支店の適用終了日が移行先支店の適用開始日の前日でない場合はエラー
        if ($data[0]['apply_start_ymd'] != date('Y-m-d', strtotime($apply_end_ymd . '+1day'))){
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 銀行IDが存在するかチェック
     *
     * @param unknown $bank_id
     * @return boolean
     */
    public function exist_bank_id($bank_id) {

        // モデルロード
        $this->CI->load->model('mst_bank_model');
        // 銀行情報を取得する
        $data = $this->CI->mst_bank_model->get_bank_info($bank_id);
        // 銀行が存在しない場合はエラー
        if(empty($data)) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 銀行支店IDが銀行IDと整合するかチェック
     *
     * @param unknown $branch_id
     * @return boolean
     */
    public function valid_branch_id($branch_id) {

        // モデルロード
        $this->CI->load->model('mst_bank_branch_model');
        // 支店情報を取得する
        $data = $this->CI->mst_bank_branch_model->get_branch_info($branch_id);
        // 支店が存在しない場合はエラー
        if(empty($data)) {
            return false;
        }

        // 銀行ID取得
        $bank_id = $this->CI->input->post('mst_bank_id');

        // 銀行IDとの整合性チェック
        if ($data['mst_bank_id'] != $bank_id){
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイターのID重複チェック
     *
     * @param unknown $afi_id
     * @return boolean
     */
    public function dup_afi_id_with_tmp($afi_id) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('afi_info_model');
        // ログインID取得
        $data = $this->CI->afi_info_model->get_login_id_with_tmp($afi_id);

        // 指定IDでの重複がない場合
        if (empty($data)) {
            return true;
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 販売者のID重複チェック
     *
     * @param unknown $seller_id
     * @return boolean
     */
    public function dup_seller_id_with_tmp($seller_id) {
        $CI = get_instance();

        // モデルロード
        $this->CI->load->model('seller_info_model');
        // ログインID取得
        $data = $this->CI->seller_info_model->get_login_id_with_tmp($seller_id);

        // 指定IDでの重複がない場合
        if (empty($data)) {
            return true;
        }

        return false;
    }
    // --------------------------------------------------------------------
    /**
     * アフィリエイター　ログインID重複チェック
     *
     * @param unknown $login_id
     * @return boolean
     */
    public function dup_afi_login_id($login_id) {
        $afi_id = $this->CI->login_customer_id;
        // モデルロード
        $this->CI->load->model('afi_info_model');
        $this->CI->load->model('afi_admin_check_model');
        // ログインID取得
        $afi_info = $this->CI->afi_info_model->dup_login_id($login_id);
        if(empty($afi_info)){
           return true;
        }else{
            if($afi_info['afi_id'] == $afi_id){
                return true;
            }else{
                if(str_replace('-', '', $this->CI->input->post('telephone_no')) != str_replace('-', '', $afi_info['telephone_no'])){
                    if($this->CI->input->post('branch_id') != $afi_info['mst_bank_branch_id'] && $this->CI->input->post('account_no') != $afi_info['account_no']){
                        return true;
                    }else{
                        $e_flag = $this->CI->afi_admin_check_model->get_e_flag($afi_info['afi_id']);
                        if(!empty($e_flag)){
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイター　ログインID重複チェック（名前変更有
     *
     * @param unknown $full_name
     * @return boolean
     */
    public function dup_afi_full_name($full_name) {

        // モデルロード
        $this->CI->load->model('afi_info_model');
        $this->CI->load->model('afi_admin_check_model');
        // ログインID取得
        $afi_info = $this->CI->afi_info_model->get_afi_info_by_full_name($full_name);
        if(empty($afi_info)){
            return true;
        }else{
            $e_flag = $this->CI->afi_admin_check_model->get_e_flag($afi_info[0]['afi_id']);
            if($e_flag == COMMON__FLAG__ON){
                return true;
            }else{
                if(str_replace('-', '', $this->CI->input->post('telephone_no')) != str_replace('-', '', $afi_info[0]['telephone_no'])){
                    if($this->CI->input->post('branch_id') != $afi_info[0]['mst_bank_branch_id'] && $this->CI->input->post('account_no') != $afi_info[0]['account_no']){
                        return true;
                    }
                }
                return false;
            }
        }
    }
    // --------------------------------------------------------------------
    /**
     * 販売者　ログインID重複チェック
     *
     * @param unknown $login_id
     * @return boolean
     */
    public function dup_seller_login_id($login_id) {
        $seller_id = $this->CI->login_customer_id;
        // モデルロード
        $this->CI->load->model('seller_info_model');
        $this->CI->load->model('seller_admin_check_model');
        // ログインID取得
        $seller_info = $this->CI->seller_info_model->dup_login_id($login_id);
        if(empty($seller_info)){
            return true;
        }else{
            if($seller_info['seller_id'] == $seller_id){
                return true;
            }else{
                if(str_replace('-', '', $this->CI->input->post('telephone_no')) != str_replace('-', '', $seller_info['telephone_no'])){
                    if($this->CI->input->post('branch_id') != $seller_info['mst_bank_branch_id'] && $this->CI->input->post('account_no') != $seller_info['account_no']){
                        return true;
                    }else{
                        $e_flag = $this->CI->seller_admin_check_model->get_e_flag($seller_info['seller_id']);
                        if(!empty($e_flag)){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    // --------------------------------------------------------------------
    /**
     * アフィリエイター　口座変更許可判定チェック
     *
     * @param unknown $branch_id
     * @return boolean
     */
    public function check_afi_financial_change($branch_id) {
        $afi_id = $this->CI->login_customer_id;
        // モデルロード
        $this->CI->load->model('admin_afi_billing_model');
        $this->CI->load->model('afi_bank_account_model');
        $financial_info = $this->CI->afi_bank_account_model->get_afi_bank_account($afi_id);
        if($financial_info['mst_bank_branch_id'] == $branch_id){
            return true;
        }else{
            $afi_billing_info = $this->CI->admin_afi_billing_model->get_afi_billing($afi_id);
            $count = 0;
            for ($i = 0; $i < count($afi_billing_info) - 1; $i++) {
                if ($afi_billing_info['mst_bank_branch_id'][i] != $afi_billing_info['mst_bank_branch_id'][$i + 1]) {
                    $count++;
                }
            }

            if($count == 0){
                return true;
            }
            return false;
        }

    }
    // --------------------------------------------------------------------
    /**
     * 販売者　口座変更許可判定チェック
     *
     * @param unknown $branch_id
     * @return boolean
     */
    public function check_seller_financial_change($branch_id) {
        $seller_id = $this->CI->login_customer_id;
        // モデルロード
        $this->CI->load->model('admin_seller_billing_model');
        $this->CI->load->model('seller_bank_account_model');
        $financial_info = $this->CI->seller_bank_account_model->get_seller_bank_account($seller_id);
        if($financial_info['mst_bank_branch_id'] == $branch_id){
            return true;
        }else{
            $seller_billing_info = $this->CI->admin_seller_billing_model->get_seller_billing($seller_id);
            $count = 0;
            for ($i = 0; $i < count($seller_billing_info) - 1; $i++) {
                if ($seller_billing_info['mst_bank_branch_id'][i] != $seller_billing_info['mst_bank_branch_id'][$i + 1]) {
                    $count++;
                }
            }
            if($count == 0){
                return true;
            }
            return false;
        }
    }

    // --------------------------------------------------------------------
    /**
     * アフィリエイター　ログインID重複チェック（名前変更有
     *
     * @param unknown $full_name
     * @return boolean
     */
    public function dup_seller_full_name($full_name) {

        // モデルロード
        $this->CI->load->model('seller_info_model');
        $this->CI->load->model('seller_admin_check_model');
        // ログインID取得
        $seller_info = $this->CI->seller_info_model->get_seller_info_by_full_name($full_name);
        if(empty($seller_info)){
            return true;
        }else{
            $e_flag = $this->CI->seller_admin_check_model->get_e_flag($seller_info[0]['seller_id']);
            if($e_flag == COMMON__FLAG__ON){
                return true;
            }else{
                if(str_replace('-', '', $this->CI->input->post('telephone_no')) != str_replace('-', '', $seller_info[0]['telephone_no'])){
                    if($this->CI->input->post('branch_id') != $seller_info[0]['mst_bank_branch_id'] && $this->CI->input->post('account_no') != $seller_info[0]['account_no']){
                        return true;
                    }
                }
                return false;
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * ユーザー種別を特定してIDの存在をチェックする
     *
     * @param unknown $customer_id
     * @return boolean
     */
    public function exist_user($customer_id) {

        // ユーザー種別を特定する
        $user_type = $this->CI->input->post('distribute_to');

        $data = array();

        switch($user_type) {
            case ADMIN_NOTICE__DISTRIBUTE_TO__BUYER:
                // モデルロード
                $this->CI->load->model('buyer_info_model');
                // ログインID取得
                $data = $this->CI->buyer_info_model->get_login_id($customer_id);
                break;
            case ADMIN_NOTICE__DISTRIBUTE_TO__AFI:
                // モデルロード
                $this->CI->load->model('afi_info_model');
                // ログインID取得
                $data = $this->CI->afi_info_model->get_login_id($customer_id);
                break;
            case ADMIN_NOTICE__DISTRIBUTE_TO__SELLER:
                // モデルロード
                $this->CI->load->model('seller_info_model');
                // ログインID取得
                $data = $this->CI->seller_info_model->get_login_id($customer_id);
                break;
            default:
                break;
        }

        if(empty($data)) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     * 配信対象をチェックする
     *
     * @param unknown $flag
     * @return boolean
     */
    public function valid_distribute($flag) {

        // 配信対象のチェックを取得する
        $buyer_check  = $this->CI->input->post('distribute_to_buyer');
        $afi_check    = $this->CI->input->post('distribute_to_afi');
        $seller_check = $this->CI->input->post('distribute_to_seller');
        // 個別配信指定IDを取得する
        $buyer_id  = $this->CI->input->post('distribute_to_id_buyer');
        $afi_id    = $this->CI->input->post('distribute_to_id_afi');
        $seller_id = $this->CI->input->post('distribute_to_id_seller');

        // 最低1つはチェックされいないとエラー
        if((empty($buyer_check)) && (empty($afi_check)) && (empty($seller_check))) {
            return false;
        }

        // チェックしていないのにIDが入力されていたらエラー
        if((empty($buyer_check)) && (($buyer_id != null))) {
            return false;
        }
        if((empty($afi_check)) && (($afi_id != null))) {
            return false;
        }
        if((empty($seller_check)) && (($seller_id != null))) {
            return false;
        }

        // チェックしていてIDが入力されていたら存在チェック
        $data = array();
        if((! empty($buyer_check)) && (! empty($buyer_id))) {
            // 複数指定されているIDを配列に入れてそれぞれチェック
            $buyer_id = str_replace("　", " ", $buyer_id);
            $ids = explode(" ", $buyer_id);
            foreach($ids as $id) {
                // モデルロード
                $this->CI->load->model('buyer_info_model');
                // ログインID取得
                $data = $this->CI->buyer_info_model->get_login_id($id);

                if(empty($data)) {
                    return false;
                }
            }
        }
        if((! empty($afi_check)) && (! empty($afi_id))) {
            // 複数指定されているIDを配列に入れてそれぞれチェック
            $afi_id = str_replace("　", " ", $afi_id);
            $ids = explode(" ", $afi_id);
            foreach($ids as $id) {
                // モデルロード
                $this->CI->load->model('afi_info_model');
                // ログインID取得
                $data = $this->CI->afi_info_model->get_login_id($id);

                if(empty($data)) {
                    return false;
                }
            }
        }
        if((! empty($seller_check)) && (! empty($seller_id))) {
            // 複数指定されているIDを配列に入れてそれぞれチェック
            $seller_id = str_replace("　", " ", $seller_id);
            $ids = explode(" ", $seller_id);
            foreach($ids as $id) {
                // モデルロード
                $this->CI->load->model('seller_info_model');
                // ログインID取得
                $data = $this->CI->seller_info_model->get_login_id($id);

                if(empty($data)) {
                    return false;
                }
            }
        }

        return true;
    }

    // --------------------------------------------------------------------
    /**
     *  銀振入金取込情報のファイル名重複チェック
     *
     * @param unknown $bank_trans_fnm
     * @return boolean
     */
    public function dup_bank_trans_fnm($bank_trans_fnm) {
        // モデルロード
        $this->CI->load->model('bank_trans_result_info_model');

        // 銀振入金取込情報取得
        $data = $this->CI->bank_trans_result_info_model->get_bank_trans_result_info_by_bank_trans_fnm($bank_trans_fnm);

        if (empty($data)) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
    /**
     * アップロードファイルチェック
     * ※エラー文言を個別に設定したい場合はcaseごとに関数を増やして対応すること
     * @param unknown $file_name
     * @return boolean
     */
    public function valid_upload_file($file_name) {
        $result = false;
        /* ファイルアップロードエラーチェック */
        switch ($_FILES[$file_name]['error']) {
            case UPLOAD_ERR_OK:
                // エラー無し
                $result = true;
                break;
            case UPLOAD_ERR_NO_FILE:
                // ファイル未選択
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                // 許可サイズを超過
                break;
            default:
                break;
        }
        return $result;
    }

    // --------------------------------------------------------------------
    /**
     *  無料報酬デポジット入金取込情報のファイル名重複チェック
     *
     * @param unknown $file_name
     * @return boolean
     */
     public function dup_free_offer_deposit_bank_trans_fnm($file_name) {
        // モデルロード
        $this->CI->load->model('deposit_trans_result_info_model');

        // 無料報酬デポジット入金取込情報取得
        $data = $this->CI->deposit_trans_result_info_model->get_data_by_deposit_trans_fnm($_FILES[$file_name]['name']);
        if (empty($data)) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
    /**
     * 動画リンクチェック
     * ※youtubeかどうかチェック
     * @param unknown $url
     * @return boolean
     */
    public function valid_movie_link($url) {
      $result = false;
      $type = 'youtube.com';
      if (strstr($url, $type)) {
        $result = true;
      } else {
        $result = false;
      }
      return $result;
    }

        // --------------------------------------------------------------------
    /**
     * 無料報酬デポジット入金取込情報のファイル名重複チェック
     *
     * @param unknown $file_name
     * @return boolean
     */
    public function exist_deposit_apply_no_by_not_confirm($apply_no) {
        // モデルロード
        $this->CI->load->model('seller_deposit_apply_model');

        // 無料報酬デポジット申請情報取得
        $data = $this->CI->seller_deposit_apply_model->get_data($apply_no,
                                                                SELLER_DEPOSIT_APPLY__APPLY_STATUS__NOT_CONFIRM,
                                                                SELLER_DEPOSIT_APPLY__APPLY_DIV__ADD,
                                                                SELLER_DEPOSIT_APPLY__PAY_METHOD__BANK_RECEPTION);
        if (empty($data)) {
            return false;
        }

        // モデルロード
        $this->CI->load->model('deposit_trans_unknown_model');

        // 振込不明金詳細取得
        $unknown = $this->CI->deposit_trans_unknown_model->get_data($this->CI->input->post('id'));
        if (empty($unknown)) {
            return false;
        }

        // 金額チェック
        if ($data['amount'] != $unknown['deposit_trans_confirm_amount']){
            return false;
        }

        return true;
    }

}
