<div align="center">

![Logo](https://raw.githubusercontent.com/webui-dev/webui-logo/14fd595844f57ce751dfc751297b1468b10de77a/webui_120.svg)

# WebUI for PHP

[build-status]: https://img.shields.io/github/actions/workflow/status/webui-dev/webui/ci.yml?branch=main&style=for-the-badge&logo=githubactions&labelColor=414868&logoColor=C0CAF5
[last-commit]: https://img.shields.io/github/last-commit/webui-dev/webui?style=for-the-badge&logo=github&logoColor=C0CAF5&labelColor=414868
[release-version]: https://img.shields.io/github/v/tag/webui-dev/webui?style=for-the-badge&logo=webtrees&logoColor=C0CAF5&labelColor=414868&color=7664C6
[license]: https://img.shields.io/github/license/webui-dev/webui?style=for-the-badge&logo=opensourcehardware&label=License&logoColor=C0CAF5&labelColor=414868&color=8c73cc

[![][build-status]](https://github.com/webui-dev/webui/actions?query=branch%3Amain)
[![][last-commit]](https://github.com/webui-dev/webui/pulse)
[![][release-version]](https://github.com/webui-dev/webui/releases/latest)
[![][license]](https://github.com/webui-dev/webui/blob/main/LICENSE)

>Use any web browser or WebView as GUI, with your preferred language in the backend and modern web technologies in the frontend, all in a lightweight portable library.

![Screenshot](https://raw.githubusercontent.com/webui-dev/webui-logo/main/screenshot.png)

</div>

[中文自述](/README-zh-CN.md)

> WebView may not work in win32

# composer

```shell
composer require kingbes/webui
```

|  要求   | 状态 |
|  ----  | ----  |
|  PHP   | 8.1+  |
|  FFI   | *     |
|  Windows   | true  |
|  Linux   | To be tested     |
|  MacOs   | To be tested     |


# 示例

1. 示例一

index.html

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- You must add webu.js; otherwise, the interaction cannot be performed -->
    <script src="webui.js"></script>
</head>

<body>
    <button onclick="btn()">asd</button>
    <script>
        function btn() {
            hello('hello').then(function (res) {
                console.log(res)
            })
        }
    </script>
</body>

</html>
```

index.php

```php
require "./vendor/autoload.php";

use Kingbes\Webui;
use Kingbes\JavaScript;

$Webui = new Webui;
$html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "index.html");
$window = $Webui->newWindow();
$bind = $Webui->bind($window, "hello", function ($event, JavaScript $js) {
    // Gets the first argument as a string
    $arg_one = $js->getString($event);
    var_dump($arg_one);

    // return string
    $js->returnString($event, "nihao");
});
$Webui->show($window, $html);
$Webui->wait();
$Webui->clean();
```

## 各类用法说明

1. `Webui` Webui class
2. `JavaScript` Used to interact with js bindings
3. `Wrapper` Wrappers that wrap the entire interaction, etc
4. `Cobj` Wrappers, which wrap the entire interaction with other C object classes, some functions may be required

# MORE

[website](https://webui.me/)
