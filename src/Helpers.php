<?php

namespace Draguo\DirectMail;

trait Helpers
{
    // 不同区域访问地址不同
    private function getRequestUrl()
    {
        $regions = [
            'cn-hangzhou' => 'dm.aliyuncs.com',
            'ap-southeast-1' => 'dm.ap-southeast-1.aliyuncs.com',
            'ap-southeast-2' => 'dm.ap-southeast-2.aliyuncs.com'
        ];

        return 'https://'.$regions[self::REGION];
    }

    /**
     * API 版本号，为日期形式：YYYY-MM-DD。
     * 如果参数 RegionID 是 cn-hangzhou，则版本对应为2015-11-23；
     * 如参数 RegionID 是cn-hangzhou 以外其他 Region，比如 ap-southeast-1，则版本对应为2017-06-22
     * 来自官方文档
     */
    private function getVersion()
    {
        return self::REGION == 'cn-hangzhou' ? '2015-11-23' : '2017-06-22';
    }

    private function generateSignature(array $params)
    {
        ksort($params);
        $queryString = '';
        foreach ($params as $key => $value) {
            $queryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
        }

        $stringToSign = 'GET&%2F&'. $this->percentencode(substr($queryString, 1));

        return base64_encode(hash_hmac('sha1', $stringToSign, $this->secret."&", true));

    }

    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }
}
