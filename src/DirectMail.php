<?php

namespace Draguo\DirectMail;

class DirectMail
{
    use HttpRequest, Helpers;

    const FORMAT = 'JSON';
    const REGION = 'cn-hangzhou';
    const SIGNATURE_VERSION = '1.0';
    const SIGNATURE_METHOD = 'HMAC-SHA1';

    protected $key;
    protected $secret;
    protected $message = [];
    private $params = [];

    public function __construct($key = null, $secret = null)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function send(array $message)
    {
        $mail = new SingleSendMail($message);

        $this->setParams($mail->getParams());

        return $this->post($this->getRequestUrl(), $this->getParams());
    }

    private function getParams()
    {
        $baseParams = [
            'Format' => self::FORMAT,
            'Version' => $this->getVersion(),
            'AccessKeyId' => $this->key,
            'SignatureMethod' => self::SIGNATURE_METHOD,
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => self::SIGNATURE_VERSION,
            'SignatureNonce' => md5(uniqid(mt_rand(), true)), // 唯一随机数
            'RegionId' => self::REGION // 机房信息
        ];

        $this->setParams([
            'Signature' => $this->getSignature(array_merge($baseParams, $this->params))
        ]);

        return $this->params;
    }

    protected function setParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
    }
}