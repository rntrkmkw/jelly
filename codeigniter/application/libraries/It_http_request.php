<?php
/**
 * HTTPリクエスト実行クラス
 */
class it_http_request
{
    protected $proxy; // プロキシ情報
    protected $method; // メソッド(GET|POST)
    protected $timeout = 5.0; // タイムアウト時間

    public function __construct() {
        $this->use_get_method();
        $this->proxy = config_item('proxy_server_url');
    }

    /**
     * GETメソッド指定
     * @return it_http_request
     */
    public function use_get_method() {
        $this->method = 'GET';

        return $this;
    }

    /**
     * POSTメソッド指定
     * @return it_http_request
     */
    public function use_post_method() {
        $this->method = 'POST';

        return $this;
    }

    /**
     * Timeout設定
     * @param double $timeout 秒
     */
    public function set_timeout($timeout) {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * リクエスト実行
     * @param  string $url    URL
     * @param  string $params [GETパラメータ]
     * @return string         レスポンスボティ
     */
    public function execute($url, $params = '') {
        $context = $this->stream_context_create();
        $request = $params ? $url.'?'.$params : $url;

        return file_get_contents($request, false, $context);
    }

    /**
     * コネクションコンテキスト生成
     * @return resource
     */
    protected function stream_context_create() {
        $params = array(
            'method' => $this->method,
            'timeout' => $this->timeout,
        );

        if ($this->proxy) {
            // プロキシ設定があった場合に有効にする
            $params['proxy'] = $this->proxy;
            $params['request_fullurl'] = true;
        }

        return stream_context_create(array('http' => $params));
    }
}
