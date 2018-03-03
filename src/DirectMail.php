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

    /**
     * @param array $message
     * @return string
     * send single mail
     */
    public function send(array $message)
    {
        // 公共参数
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
        $this->setParams($baseParams);

        // 特殊参数
        $mail = new SingleSendMail($message);

        $this->setParams($mail->getParams());

        // 设置签名
        $this->setParams([
            'Signature' => $this->generateSignature($this->params)
        ]);

        return $this->get($this->getRequestUrl(), $this->getParams());
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
    }
}
