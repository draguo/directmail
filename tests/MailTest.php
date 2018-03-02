<?php

namespace Draguo\DirectMail\Tests;


use Draguo\DirectMail\DirectMail;

class MailTest extends TestCase
{
    public function testSingle()
    {
        $serve = new DirectMail();
        $serve->send([
            'from' => 'draguo@sina.com',
            'to' => 'test@sina.com',
            'subject' => '这个是邮件的主题',
            'body' => '邮件的主题内容'
        ]);
    }
}