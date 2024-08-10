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

>使用任何web浏览器或WebView作为GUI，后端使用您喜欢的语言，前端使用现代web技术，所有这些都在一个轻量级的便携式库中。

![Screenshot](https://raw.githubusercontent.com/webui-dev/webui-logo/main/screenshot.png)

</div>

> [!提示]
> WebView在win32可能不能用哦

# composer

```shell
composer require kingbes/webui
```

|  要求   | 状态 |
|  ----  | ----  |
|  PHP   | 8.1+  |
|  FFI   | *     |
|  Windows   | true  |
|  Linux   | 未测试     |
|  MacOs   | 未测试     |


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
    <!-- 必须加入webui.js，否则无法交互 -->
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

// 实例
$Webui = new Webui;
// html字符串
$html = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "index.html");
// 创建一个窗口
$window = $Webui->newWindow();
// 绑定js函数
$bind = $Webui->bind($window, "hello", function ($event, JavaScript $js) {
    // 获取第一个参数为字符串
    $arg_one = $js->getString($event);
    var_dump($arg_one);

    // 返回字符串
    $js->returnString($event, "nihao");
});
// 显示窗口
$Webui->show($window, $html);
// 等待
$Webui->wait();
// 释放所有
$Webui->clean();
```

## 各类用法说明

1. `Webui` 窗口的方法类
2. `JavaScript` 用于与js绑定交互用
3. `Wrapper` 包装器，对整个交互进行包装等
4. `Cobj` C的对象类，部分功能可能需要

## 类`Kingbes\Webui`

```php
/**
 * 创建一个新的web窗口对象。 function
 *
 * @return int
 */
public function newWindow(): int
{}

/**
 * 使用指定的窗口号创建新的web窗口对象。
 *
 * @param integer $window web窗口对象
 * @return integer
 */
public function newWindowId(int $window): int
{}

/**
 * 获得一个可以使用的免费窗口对象
 *
 * @return integer
 */
public function getNewWindowId(): int
{}

/**
 * 用后端函数绑定一个HTML元素和一个JavaScript对象。空元素名称表示所有事件。 function
 *
 * @param integer $window 窗口对象
 * @param string $element 绑定js函数名
 * @param Closure $func php函数
 * @return boolean
 */
public function bind(
    int $window,
    string $element,
    Closure $func
): mixed {}

/**
 * 获取要使用的推荐web浏览器ID。如果您已经使用了一个ID，则此函数将返回相同的ID。
 *
 * @param integer $window 窗口对象
 * @return integer
 */
public function getBestBrowser(int $window): int
{}

/**
 * 使用嵌入的HTML或文件显示窗口。如果窗口已经打开，它将被刷新。这将刷新多客户端模式下的所有窗口。
 *
 * @param integer $window web窗口对象
 * @param string $content html内容
 * @example 示例 show($myWindow,"<html>...</html>"); | show($myWindow, "index.html"); | show($myWindow, "http://...");
 * @return boolean
 */
public function show(int $window, string $content): bool
{}

/**
 * 与' webui_show() '相同。但是使用特定的网络浏览器。
 *
 * @param integer $window 窗口对象
 * @param string $content html内容
 * @param integer $browser 浏览器对象
 * @example 示例 showBrowser($myWindow, "<html>...</html>", $Chrome); | showBrowser($myWindow, "index.html", $Firefox);
 * @return boolean
 */
public function showBrowser(int $window, string $content, int $browser): bool
{}

/**
 * 与' webui_show() '相同。但是只启动web服务器并返回URL。不会显示任何窗口。
 *
 * @param integer $window 窗口对象
 * @param string $content 路径
 * @example 例子 $url = startServer($myWindow,"/full/root/path");
 * @return string
 */
public function startServer(int $window, string $content): string
{}

/**
 * 使用嵌入的HTML或文件显示WebView窗口。如果窗口已经打开，它将被刷新。注意:Win32需要' WebView2Loader.dll '。(失败)
 *
 * @param integer $window 窗口对象
 * @param string $content html内容
 * @example 示例 showWv($myWindow,"<html>...</html>"); | show($myWindow, "index.html"); | show($myWindow, "http://...");
 * @return boolean
 */
public function showWv(int $window, string $content): bool
{}

/**
 * 将窗口设置为Kiosk模式(全屏)。
 * @param integer $window 窗口对象
 * @param boolean $status 状态
 * @example 示例 setKiosk($window, true);
 * @return void
 */
public function setKiosk(int $window, bool $status): void
{}

/**
 * 设置具有高对比度支持的窗口。当你想用CSS构建一个更好的高对比度主题时非常有用。
 *
 * @param integer $window 窗口对象
 * @param boolean $status 状态
 * @example 示例 setHighContrast($window, true);
 * @return void
 */
public function setHighContrast(int $window, bool $status): void
{}

/**
 * 获得操作系统高对比度偏好。
 *
 * @example 示例 isHighContrast();
 * @return boolean
 */
public function isHighContrast(): bool
{}

/**
 * 检查是否安装了某浏览器。
 *
 * @param integer $browser 浏览器对象
 * @example 示例 browserExist($browser);
 * @return boolean
 */
public function browserExist(int $browser): bool
{}

/**
 * 等到所有开着的窗户都关上了。
 *
 * @example 示例 wait();
 * @return void
 */
public function wait(): void
{}

/**
 * 仅关闭特定窗口。窗口对象仍然存在。所有的客户。
 *
 * @param integer $window 窗口对象
 * @example 示例 close($window);
 * @return void
 */
public function close(int $window): void
{}

/**
 * 关闭特定窗口并释放所有内存资源。
 *
 * @param integer $window 窗口对象
 * @example 示例 destroy($window);
 * @return void
 */
public function destroy(int $window): void
{}

/**
 * 关闭所有打开的窗口。' wait() '将返回(Break)。
 *
 * @example 示例 exit();
 * @return void
 */
public function exit(): void
{}

/**
 * 为特定窗口设置web服务器根文件夹路径。
 *
 * @param integer $window 窗口对象
 * @param string $path 文件夹路径
 * @example 示例 setRootFolder($window,"/home/Foo/Bar/");
 * @return boolean
 */
public function setRootFolder(int $window, string $path): bool
{}

/**
 * 设置所有windows的web服务器根文件夹路径。应该使用在' show() '之前。
 *
 * @param string $path 文件夹路径
 * @example 示例 setDefaultRootFolder("/home/Foo/Bar/");webui_show();
 * @return boolean
 */
public function setDefaultRootFolder(string $path): bool
{}

/**
 * 设置一个自定义处理程序来提供文件。这个自定义处理程序应该返回完整的HTTP报头和正文。
 *
 * @param integer $window 窗口对象
 * @param Closure $func 函数 参数 string $filename,int $length
 * @example 示例 setFileHandler($window,function($filename, $length){});
 * @return void
 */
public function setFileHandler(int $window, Closure $func): void
{}

/**
 * 检查指定的窗口是否仍在运行。
 *
 * @param integer $window 窗口对象
 * @example 示例 isShown($window);
 * @return boolean
 */
public function isShown(int $window): bool
{}

/**
 * 设置等待窗口连接的最大时间(以秒为单位)。这个效果是' show() '和' wait() '。值“0”表示永远等待。
 *
 * @param integer $second 秒
 * @example 示例 setTimeout(30);
 * @return void
 */
public function setTimeout(int $second): void
{}

/**
 * 设置默认的嵌入HTML图标。
 *
 * @param integer $window 窗口对象
 * @param string $icon 字符串
 * @param string $iconType mine类型
 * @example 示例 setIcon($window,"<svg>...</svg>","image/svg+xml");
 * @return void
 */
public function setIcon(int $window, string $icon, string $iconType): void
{}

/**
 * 将文本编码为Base64。返回的缓冲区需要被释放。(应该可以用PHP自带的)
 *
 * @param string $str
 * @example 示例 encode("Foo Bar");
 * @return string
 */
public function encode(string $str): string
{}

/**
 * 解码Base64编码的文本。返回的缓冲区需要被释放。(应该可以用php自带的)
 *
 * @param string $str
 * @example 示例 decode("SGVsbG8=");
 * @return string
 */
public function decode(string $str): string
{}

/**
 * 安全地释放由web使用' malloc() '分配的缓冲区。
 *
 * @param mixed $ptr 指针
 * @return void
 */
public function free(mixed $ptr): void
{}

/**
 * 通过web内存管理系统安全分配内存。它可以在任何时候使用' free() '安全地释放。
 *
 * @param integer $size 内存
 * @example 示例 malloc(1024);
 * @return mixed
 */
public function malloc(int $size): mixed
{}

/**
 * 安全地将原始数据发送到UI。所有的客户。
 *
 * @param integer $window 窗口对象
 * @param string $func js字符串函数名
 * @param mixed $raw c的const void *
 * @param integer $size 大小
 * @return void
 */
public function sendRaw(int $window, string $func, mixed $raw, int $size): void
{}

/**
 * 设置窗口为隐藏模式。应该在' show() '之前调用。
 *
 * @param integer $window 窗口对象
 * @param boolean $status 状态
 * @example 示例 setHide($window, true);show();
 * @return void
 */
public function setHide(int $window, bool $status): void
{}

/**
 * 设置窗口大小。
 *
 * @param integer $window 窗口对象
 * @param integer $width 宽度
 * @param integer $height 高度
 * @example 示例 setSize($window, 800, 600);
 * @return void
 */
public function setSize(int $window, int $width, int $height): void
{}

/**
 * 设置窗口位置。
 *
 * @param integer $window 窗口对象
 * @param integer $x
 * @param integer $y
 * @return void
 */
public function setPosition(int $window, int $x, int $y): void
{}

/**
 * 设置要使用的web浏览器配置文件。空的“name”和“path”表示默认的用户配置文件。需要在'show() '之前调用。
 *
 * @param integer $window 窗口对象
 * @param string $name 名称
 * @param string $path 文件路径
 * @example 示例 setProfile($window,"Bar","/Home/Foo/Bar");show(); | setProfile($window,"","");show();
 * @return void
 */
public function setProfile(int $window, string $name, string $path): void
{}

/**
 * 设置使用的web浏览器代理服务器。需要在' show() '之前调用。
 *
 * @param integer $window 窗口对象
 * @param string $proxyServer 链接
 * @example 示例 setProxy($window,"http://127.0.0.1:8888");show();
 * @return void
 */
public function setProxy(int $window, string $proxyServer): void
{}

/**
 * 获取正在运行的窗口的当前URL。
 *
 * @param integer $window 窗口对象
 * @return string
 */
public function getUrl(int $window): string
{}

/**
 * 在本机默认web浏览器中打开URL。
 *
 * @param string $url 链接
 * @example 示例 openUrl("https://webui.me");
 * @return void
 */
public function openUrl(string $url): void
{}

/**
 * 允许从公共网络访问特定的窗口地址。
 *
 * @param integer $window 窗口对象
 * @param boolean $status 状态
 * @example 示例 setPublic($window,true);
 * @return void
 */
public function setPublic(int $window, bool $status): void
{}

/**
 * 导航到特定的URL。所有的客户。
 *
 * @param integer $window 窗口对象
 * @param string $url 链接
 * @example 示例 navigate($window,"http://domain.com");
 * @return void
 */
public function navigate(int $window, string $url): void
{}

/**
 * 释放所有内存资源。应该只在最后调用。
 *
 * @example 示例 clean();
 * @return void
 */
public function clean(): void
{}

/**
 * 删除所有本地web浏览器配置文件文件夹。它应该在最后被调用。
 *
 * @example 示例 wait();deleteAllProfiles();clean();
 * @return void
 */
public function deleteAllProfiles(): void
{}

/**
 * 删除特定窗口web-browser本地文件夹配置文件。
 *
 * @param integer $window 窗口对象
 * @example 示例 wait();deleteProfile();clean();
 * @return void
 */
public function deleteProfile(int $window): void
{}

/**
 * 获取父进程的ID (web浏览器可能会重新创建另一个新进程)。
 *
 * @param integer $window 窗口对象
 * @return integer
 */
public function getParentProcessId(int $window): int
{}

/**
 * 获取最后一个子进程的ID。
 *
 * @param integer $window 窗口对象
 * @return integer
 */
public function getChildProcessId(int $window): int
{}

/**
 * 获取正在运行的窗口的网口。这对于确定' webui.js '的HTTP链接很有用。
 *
 * @param integer $window 窗口对象
 * @return integer
 */
public function getPort(int $window): int
{}

/**
 * 设置web服务使用的自定义web-server/websocket网口。这可以用来确定' web .js '的HTTP链接，如果你试图使用web与外部web服务器如NGNIX。
 *
 * @param integer $window 窗口对象
 * @param integer $port 端口号
 * @return boolean
 */
public function setPort(int $window, int $port): bool
{}

/**
 * 获取一个可用的空闲网络端口。
 *
 * @return integer
 */
public function getFreePort(): int
{}

/**
 * 控制web界面行为。建议在开始时调用。
 *
 * @param object $option C的webui_config
 * @param boolean $status 状态
 * @example 示例 setConfig($option,false);
 * @return void
 */
public function setConfig(object $option, bool $status): void
{}

/**
 * 控制来自此窗口的UI事件是否应该在单个阻塞线程中一次处理一个' True '，还是在一个新的非阻塞线程中处理每个事件' False '。此更新单窗口。你可以使用' setConfig(ui_event_blocking，…)'来更新所有的窗口。
 *
 * @param integer $window 窗口对象
 * @param boolean $status 状态
 * @example 示例 setEventBlocking($window, true)
 * @return void
 */
public function setEventBlocking(int $window, bool $status): void
{}

/**
 * 获取文件的HTTP mime类型。(应该可以用PHP自带的)
 *
 * @param string $file 文件
 * @example 示例 getMimeType("foo.png");
 * @return string
 */
public function getMimeType(string $file): string
{}

/**
 * 运行JavaScript而不等待响应。所有的客户。
 *
 * @param integer $window 窗口对象
 * @param string $js js字符串
 * @example 示例 run($window,"alert('Hello');");
 * @return void
 */
public function run(int $window, string $js): void
{}

/**
 * 运行JavaScript并获得响应。仅在单客户端模式下工作。确保您的本地缓冲区可以保存响应。
 *
 * @param integer $window 窗口对象
 * @param string $js js字符串
 * @param integer $timeout 等待时间
 * @param mixed $buffer 缓冲对象 C的char *类型
 * @param integer $bufferLength 缓冲长度
 * @example 示例 script($window,"return 4 + 6;",$buffer,$bufferLength);
 * @return boolean
 */
public function script(int $window, string $js, int $timeout, mixed $buffer, int $bufferLength): bool
{}

/**
 * 选择Deno或Nodejs作为.js和.ts文件的运行时。
 *
 * @param integer $window 窗口对象
 * @param integer $runtime 运行时对象
 * @example 示例 setRuntime($window,$runtime);
 * @return void
 */
public function setRuntime(int $window, int $runtime): void
{}
```

## 类`Kingbes\JavaScript`

```php
/**
 * 关闭特定客户端。
 *
 * @param object $event
 * @example 示例 closeClient($event);
 * @return void
 */
public function closeClient(object $event): void
{}

/**
 * 安全地将原始数据发送到UI。单一的客户端。
 *
 * @param object $event 
 * @param string $func js函数名
 * @param mixed $raw C的const void *
 * @param integer $size 大小
 * @return void
 */
public function sendRawClient(object $event, string $func, mixed $raw, int $size): void
{}

/**
 * 导航到特定的URL。单一的客户端。
 *
 * @param object $event
 * @param string $url 链接
 * @example 示例 navigateClient($event,"http://domain.com");
 * @return void
 */
public function navigateClient(object $event, string $url): void
{}

/**
 * 运行JavaScript而不等待响应。单一的客户端。
 *
 * @param object $event
 * @param string $js js字符串
 * @example 示例 runClient($event,"alert('Hello');");
 * @return void
 */
public function runClient(object $event, string $js): void
{}

/**
 * 运行JavaScript并获得响应。单一的客户端。确保您的本地缓冲区可以保存响应。
 *
 * @param object $event
 * @param string $js js字符串
 * @param integer $timeout 等待时间
 * @param mixed $buffer 缓冲对象 C的char *类型
 * @param integer $bufferLength 缓冲长度
 * @example 示例 scriptClient($window,"return 4 + 6;",$buffer,$bufferLength);
 * @return boolean
 */
public function scriptClient(object $event, string $js, int $timeout, mixed $buffer, int $bufferLength): bool
{}

/**
 * 得到事件中有多少个参数。
 *
 * @param object $event
 * @return integer
 */
public function getCount(object $event): int
{}

/**
 * 在特定索引处获取参数为整数。
 *
 * @param object $event
 * @param integer $index 索引
 * @example 示例 $myNum = getIntAt($event,0);
 * @return integer
 */
public function getIntAt(object $event, int $index): int
{}

/**
 * 获取第一个参数为整数。
 *
 * @param object $event
 * @example 示例 $myNum = getInt($event);
 * @return integer
 */
public function getInt(object $event): int
{}

/**
 * 在特定索引处获取float参数。
 *
 * @param object $event
 * @param integer $index 索引
 * @example 示例 $myfloat = getFloatAt($event, 0);
 * @return float
 */
public function getFloatAt(object $event, int $index): float
{}

/**
 * 获取第一个参数为float。
 *
 * @param object $event
 * @example 示例 $myfloat = getFloat($event);
 * @return float
 */
public function getFloat(object $event): float
{}

/**
 * 在特定索引处以字符串形式获取参数。
 *
 * @param object $event
 * @param integer $index 索引
 * @example 示例 $myString = getStringAt($event, 0);
 * @return string
 */
public function getStringAt(object $event, int $index): string
{}

/**
 * 获取第一个参数为字符串。
 *
 * @param object $event
 * @example 示例 $myString = getString($event);
 * @return string
 */
public function getString(object $event): string
{}

/**
 * 在特定索引处获取一个布尔参数。
 *
 * @param object $event
 * @param integer $index 索引
 * @example 示例 $myBool = getBoolAt($event, 0);
 * @return boolean
 */
public function getBoolAt(object $event, int $index): bool
{}

/**
 * 获取第一个参数为布尔值。
 *
 * @param object $event
 * @example 示例 $myBool = getBool($event);
 * @return boolean
 */
public function getBool(object $event): bool
{}

/**
 * 获取特定索引处参数的大小(以字节为单位)。
 *
 * @param object $event 
 * @param integer $index 索引
 * @example 示例 $mySzie = getSizeAt($event, 0);
 * @return integer
 */
public function getSizeAt(object $event, int $index): int
{}

/**
 * 获取第一个参数的字节大小。
 *
 * @param object $event
 * @example 示例 $mySzie = getSizeAt($event);
 * @return integer
 */
public function getSize(object $event): int
{}

/**
 * 将响应作为整数返回给JavaScript。
 *
 * @param object $event
 * @param integer $num
 * @example 示例 returnInt($event, 123);
 * @return void
 */
public function returnInt(object $event, int $num): void
{}

/**
 * 将响应作为浮点数返回给JavaScript。
 *
 * @param object $event
 * @param float $double 浮点
 * @example 示例 returnFloat($event,123.456);
 * @return void
 */
public function returnFloat(object $event, float $double): void
{}

/**
 * 将响应作为字符串返回给JavaScript。
 *
 * @param object $event
 * @param string $str 字符串
 * @example 示例 returnString($event,"hello world");
 * @return void
 */
public function returnString(object $event, string $str): void
{}

/**
 * 将响应作为布尔值返回给JavaScript。
 *
 * @param object $event
 * @param boolean $bool
 * @return void
 */
public function returnBool(object $event, bool $boolean): void
{}
```

## 类`Kingbes\Wrapper`

```php
/**
 * 将特定的HTML元素click事件与函数绑定。空元素表示所有事件。
 *
 * @param integer $window 窗口对象
 * @param string $element html元素
 * @param Closure $func 函数 参数 int $param1, int $param2, string $phpParam3, int $param4, int $param5
 * @example 示例 interfaceBind($window,"myID",function($param1, $param2, $phpParam3, $param4, $param5){});
 * @return integer
 */
public function interfaceBind(int $window, string $element, Closure $func): int
{}

/**
 * 当使用' interfaceBind() '时，你可能需要这个函数来方便地设置响应。
 *
 * @param integer $window 窗口对象
 * @param integer $eventNumber $event对象的event_number
 * @param string $response 字符串
 * @example 示例 interfaceSetResponse($window,$event[0]->event_number,"Response...");
 * @return void
 */
public function interfaceSetResponse(int $window, int $eventNumber, string $response): void
{}

/**
 * 检查应用程序是否仍在运行。
 *
 * @return boolean
 */
public function interfaceIsAppRunning(): bool
{}

/**
 * 获取唯一的窗口ID。
 *
 * @param integer $window 窗口对象
 * @return integer
 */
public function interfaceGetWindowId(int $window): int
{}

/**
 * 在特定索引处以字符串形式获取参数。
 *
 * @param integer $window 窗口对象
 * @param integer $eventNumber $event对象的event_number
 * @param integer $index 索引
 * @example 示例 $myStr = interfaceGetStringAt($window, $event[0]->event_number, 0);
 * @return string
 */
public function interfaceGetStringAt(int $window, int $eventNumber, int $index): string
{}

/**
 * 在特定索引处获取参数为整数。
 *
 * @param integer $window 窗口对象
 * @param integer $eventNumber $event对象的event_number
 * @param integer $index 索引
 * @example 示例 $myNum = interfaceGetIntAt($window, $event[0]->event_number, 0);
 * @return integer
 */
public function interfaceGetIntAt(int $window, int $eventNumber, int $index): int
{}

/**
 * 在特定索引处获取float参数。
 *
 * @param integer $window 窗口对象  
 * @param integer $eventNumber $event对象的event_number
 * @param integer $index 索引
 * @example 示例 $myFloat = interfaceGetFloatAt($window, $event[0]->event_number, 0);
 * @return float
 */
public function interfaceGetFloatAt(int $window, int $eventNumber, int $index): float
{}

/**
 * 在特定索引处获取一个布尔参数。
 *
 * @param integer $window 窗口对象
 * @param integer $eventNumber $event对象的event_number
 * @param integer $index 索引
 * @example 示例 $myBool = interfaceGetBoolAt($window, $event[0]->event_number, 0);
 * @return boolean
 */
public function interfaceGetBoolAt(int $window, int $eventNumber, int $index): bool
{}

/**
 * 获取特定索引处参数的大小(以字节为单位)。
 *
 * @param integer $window 窗口对象
 * @param integer $eventNumber $event对象的event_number
 * @param integer $index 索引
 * @example 示例 $mySize = interfaceGetSizeAt($window, $event[0]->event_number, 0);
 * @return integer
 */
public function interfaceGetSizeAt(int $window, int $eventNumber, int $index): int
{}
```

## 类`Kingbes\Cobj`

```php
/**
 * 获取event对象结构
 * 
 * int window         窗口对象号;
 * int event_type     事件类型;
 * char *element      HTML元素ID;
 * int event_number   内部WebUI;
 * int bind_id        绑定 id;
 * int client_id      客户端唯一ID;
 * int connection_id  客户端连接ID;
 * char *cookies      客户的全部 cookies;
 * @return object
 */
public function event(): object
{}

/**
 *  web配置
 * 
 *  控制' webui_show() '， ' webui_show_browser() '和
 *  ' webui_show_wv() '应该等待窗口连接
 *  before是否返回。
 *  默认值:True
 *  show_wait_connection = 0,
 * 
 *  控制web是否应该阻塞和处理UI事件
 *  在一个线程中一次处理一个' True '，或者处理每一个
 *  一个新的非阻塞线程中的事件' False '。这个更新
 *  所有窗口。你可以使用' webui_set_event_blocking() '
 *  一个特定的单窗口更新。
 *  默认值:False
 *  ui_event_blocking,
 * 
 *  自动刷新窗口UI
 *  根目录被更改。
 *  默认值:False
 *  folder_monitor,
 * 
 *  允许多个客户端连接到同一个窗口
 *  这对web应用程序(非桌面软件)很有帮助，
 *  详细信息请参考文档。
 *  默认值:False
 *  multi_client,
 * 
 *  允许多个客户端连接到同一个窗口
 *  这对web应用程序(非桌面软件)很有帮助，
 *  详细信息请参考文档。
 *  默认值:False
 *  use_cookies,
 *
 * @return object
 */
public function config():object
{}
```