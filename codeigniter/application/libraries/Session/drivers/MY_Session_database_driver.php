<?php

defined('BASEPATH') or exit('No direct script access allowed');
class MY_Session_database_driver extends CI_Session_database_driver {

    // ------------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @param array $params
     * @return void
     */
    public function __construct(&$params) {
        parent::__construct($params);
    }

    // ------------------------------------------------------------------------


    // ------------------------------------------------------------------------

    /**
     * Write
     *
     * Writes (create / update) session data
     *
     * @param string $session_id
     * @param string $session_data
     *            data
     * @return bool
     */
    public function write($session_id, $session_data) {
        // Was the ID regenerated?
        if ($session_id !== $this->_session_id) {
            if (! $this->_release_lock() or ! $this->_get_lock($session_id)) {
                return FALSE;
            }

            $this->_row_exists = FALSE;
            $this->_session_id = $session_id;
        } elseif ($this->_lock === FALSE) {
            return FALSE;
        }

        if ($this->_row_exists === FALSE) {
            $insert_data = array (
                    'id' => $session_id,
                    'ip_address' => $_SERVER ['REMOTE_ADDR'],
                    'timestamp' => time(),
                    'data' => ($this->_platform === 'postgre' ? base64_encode($session_data) : $session_data),
                    // ********** カスタマイズ ********** //
                    'date' => date('Y-m-d H:i:s')
            );

            if ($this->_db->insert($this->_config ['save_path'], $insert_data)) {
                $this->_fingerprint = md5($session_data);
                return $this->_row_exists = TRUE;
            }

            return FALSE;
        }

        $this->_db->where('id', $session_id);
        if ($this->_config ['match_ip']) {
            $this->_db->where('ip_address', $_SERVER ['REMOTE_ADDR']);
        }

        $update_data = array (
                'timestamp' => time(),
                'date' => date('Y-m-d H:i:s')
        );
        if ($this->_fingerprint !== md5($session_data)) {
            $update_data ['data'] = ($this->_platform === 'postgre') ? base64_encode($session_data) : $session_data;
        }

        if ($this->_db->update($this->_config ['save_path'], $update_data)) {
            $this->_fingerprint = md5($session_data);
            return TRUE;
        }

        return FALSE;
    }

    // ------------------------------------------------------------------------
}
