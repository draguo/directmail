<?php

namespace Draguo\DirectMail\Tests;


use Draguo\DirectMail\DirectMail;

class MailTest extends TestCase
{
    public function testSingle()
    {
        $body = "<h1>这是标题</h1>";
        $mail = new DirectMail('', '');
        $result = $mail->send([
            'from' => '', // 发信地址 AccountName
            'to' => '', // 多个地址可用逗号分隔，最多100个
            'name' => '', // 发件人昵称  FromAlias
            'subject' => '这个是邮件的主题', // Subject
            'body' => $body, // html or text
            'trace' => '' // 是否开启数据追踪功能, boolean
        ]);
        $this->assertArrayHasKey('RequestId', json_decode($result, true));
    }
}