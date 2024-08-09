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

</div>

## GITHUB [webui](https://github.com/webui-dev/webui)

## 官网 [url](https://webui.me/)

# composer

```shell
composer require kingbes/webui
```

# 示例

1. 示例一

```php
require "./vendor/autoload.php";

use Kingbes\Webui;

$html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "index.html");

$Webui = new Webui();

$Webui->newWindow()
    ->show($html)
    ->wait()
    ->destroy();
```

