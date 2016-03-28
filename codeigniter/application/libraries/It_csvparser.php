<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CSVファイルのパースライブラリクラス
 * @author kamikawa
 *
 */
class It_csvparser {
    private $handle;
    private $file;
    private $parse_header;
    private $length;
    private $delimiter;
    private $enclosure;
    public $header;

    /**
     *
     */
    public function __construct() {
        setlocale(LC_ALL, 'ja_JP.UTF-8');
    }

    /**
     *
     */
    public function __destruct() {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     *
     * @param unknown $file
     * @param string $parse_header
     * @param number $length
     * @param string $delimiter
     * @param string $enclosure
     * @throws Exception
     * @return mixed
     */
    public function load($file, $parse_header = FALSE, $length = 50000, $delimiter = ',', $enclosure = '"') {

        $this->file = $file;
        $this->parse_header = $parse_header;
        $this->length = $length;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;

        if (! file_exists($this->file)) {
            //throw new Exception(sprintf("%sが存在しません。", basename($this->file)));
            return false;
        }

        if (($file = file_get_contents($this->file)) === FALSE) {
            //throw new Exception(sprintf("%sを読み込めません。", basename($this->file)));
            return false;
        } else {
            // テンポラリファイルを作成
            $this->handle = tmpfile();
            // 文字コード変換
            $file = mb_convert_encoding($file, mb_internal_encoding(), mb_detect_encoding($file, 'UTF-8, EUC-JP, JIS, eucjp-win, sjis-win'));
            // バイナリセーフなファイル書き込み処理
            fwrite($this->handle, $file);
            // ファイルポインタの位置を先頭へ
            rewind($this->handle);
        }

        if ($this->parse_header) {
            $this->header = fgetcsv($this->handle, $this->length, $this->delimiter, $this->enclosure);
            $this->header = array_map(function ($header) {
                return preg_replace('/\n|\r/', '', $header);
            }, $this->header);
        }

        return true;
    }

    /**
     *
     * @throws Exception
     * @return multitype:unknown multitype:
     */
    public function parse() {

        $data = array();

        if (! $this->handle) {
            //throw new Exception(sprintf("%s", "ファイルが読み込まれていません。"));
            return $data;
        }

        while ( ($row = fgetcsv($this->handle, $this->length, $this->delimiter, $this->enclosure)) !== FALSE ) {
            if ($this->header) {
                foreach ( $this->header as $i => $heading_i ) {
                    if (isset($row[$i])) {
                        $line[$heading_i] = $row[$i];
                    } else {
                        //throw new Exception(sprintf('%s', "ファイルが不正です。"));
                        return $data;
                    }
                }
                $data[] = $line;
            } else {
                $data[] = $row;
            }
        }

        fclose($this->handle);

        return $data;
    }
}
