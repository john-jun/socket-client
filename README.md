Socket Client
=============
A simple socket client library

Install
-------
To install with composer
```sh
composer require john-jun/socket-client
```

Test
-----
```sh
composer test
```

Usage
-----
```php
use Air\SocketClient\NetAddress\TcpNetAddress;
use Air\SocketClient\Socket;

$socketClient = new Socket(new TcpNetAddress('domain or ipv4', 443, true));

//connect & get connect use time
$socketClient->connect();
$socketClient->getConnectUseTime();

//http
$http = "GET /social/poster/share/xx HTTP/1.1\r\n";
$http .= "Host: dev-restful.moftech.net\r\n";
$http .= "Accept: */*\r\n";
$http .= "User-Agent: " . PHP_VERSION . "\r\n";
$http .= "Connection: keep-alive\r\n\r\n";

//send & recv
$socketClient->send($http);
$result = $socketClient->recv();

//the $result
'HTTP/1.1 200 OK
Cache-Control: no-cache, private
Content-Type: application/json
Date: Mon, 25 May 2020 09:58:00 GMT
Server: nginx
X-Powered-By: PHP/7.3.15
Content-Length: 26
Connection: keep-alive

{"code":"0","response":[]}';
```