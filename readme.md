<h1 align="center">阿里云发送邮件</h1>

## 安装
```shell
    composer require draguo/directmail
```
## 使用
```php
$body = "<h1>这是标题</h1>";
$mail = new \Draguo\DirectMail\DirectMail($accessKey, $secret);
$result = $mail->send([
    'from' => '', // 发信地址 AccountName
    'to' => '', // 多个地址可用逗号分隔，最多100个
    'name' => '', // 发件人昵称  FromAlias
    'subject' => '这个是邮件的主题', // Subject
    'body' => $body, // html or text
    'trace' => '' // 是否开启数据追踪功能, 1 或 0
]);

echo $result;
```