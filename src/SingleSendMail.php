<?php

namespace Draguo\DirectMail;


class SingleSendMail implements MailInterface
{
    const ACTION = 'SingleSendMail';
    private $params = [];

    public function __construct(array $params)
    {
        $this->params = [
            'Action' => self::ACTION,
            'AddressType' => '1',
            'ReplyToAddress' => 'true'
        ];
        foreach ($params as $key => $value) {
            $this->params[$this->transformKey($key)] = $value;
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $key
     * @return mixed
     * 参数包装的转换
     */
    private function transformKey($key)
    {
        $keyMap = [
            'from' => 'AccountName',
            'addressType' => 'AddressType',
            'to' => 'ToAddress',
            'name' => 'FromAlias',
            'subject' => 'Subject',
            'body' => 'HtmlBody',
            'trace' => 'ClickTrace'
        ];

        return isset($keyMap[$key]) ? $keyMap[$key] : $key;
    }
}