<?php

declare(strict_types=1);

namespace Kingbes;

use Kingbes\JavaScript;
use Closure;

/**
 * webui
 */
class Webui extends Base
{
    /**
     * 创建一个新的web窗口对象。 function
     *
     * @return int
     */
    public function newWindow(): int
    {
        return self::$ffi->webui_new_window();
    }

    /**
     * 使用指定的窗口号创建新的web窗口对象。
     *
     * @param integer $window web窗口对象
     * @return integer
     */
    public function newWindowId(int $window): int
    {
        return self::$ffi->webui_new_window_id($window);
    }

    /**
     * 获得一个可以使用的免费窗口对象
     *
     * @return integer
     */
    public function getNewWindowId(): int
    {
        return self::$ffi->webui_get_new_window_id();
    }

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
    ): mixed {
        $callback = self::$ffi->new('void (*)(webui_event_t *)');
        $js = new JavaScript();
        $callback = function ($event) use ($func, $js) {
            return $func((object)$event, $js);
        };
        return self::$ffi->webui_bind($window, $element, $callback);
    }

    /**
     * 获取要使用的推荐web浏览器ID。如果您已经使用了一个ID，则此函数将返回相同的ID。
     * NoBrowser = 0,  // 0. 无浏览器
     * AnyBrowser = 1, // 1. 任何浏览器
     * Chrome,         // 2. Google Chrome
     * Firefox,        // 3. Mozilla Firefox
     * Edge,           // 4. Microsoft Edge
     * Safari,         // 5. Apple Safari
     * Chromium,       // 6. The Chromium Project
     * Opera,          // 7. Opera Browser
     * Brave,          // 8. The Brave Browser
     * Vivaldi,        // 9. The Vivaldi Browser
     * Epic,           // 10. The Epic Browser
     * Yandex,         // 11. The Yandex Browser
     * ChromiumBased,  // 12. Any Chromium based browser
     * WebView,        // 13. WebView (Non-web-browser)
     * @param integer $window 窗口对象
     * @return integer
     */
    public function getBestBrowser(int $window = 1): int
    {
        return self::$ffi->webui_get_best_browser($window);
    }

    /**
     * 使用嵌入的HTML或文件显示窗口。如果窗口已经打开，它将被刷新。这将刷新多客户端模式下的所有窗口。
     *
     * @param integer $window web窗口对象
     * @param string $content html内容
     * @example 示例 show($myWindow,"<html>...</html>"); | show($myWindow, "index.html"); | show($myWindow, "http://...");
     * @return boolean
     */
    public function show(int $window, string $content): bool
    {
        return self::$ffi->webui_show($window, $content);
    }

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
    {
        return self::$ffi->webui_show_browser($window, $content, $browser);
    }

    /**
     * 与' webui_show() '相同。但是只启动web服务器并返回URL。不会显示任何窗口。
     *
     * @param integer $window 窗口对象
     * @param string $content 路径
     * @example 例子 $url = startServer($myWindow,"/full/root/path");
     * @return string
     */
    public function startServer(int $window, string $content): string
    {
        return self::$ffi->webui_start_server($window, $content);
    }

    /**
     * 使用嵌入的HTML或文件显示WebView窗口。如果窗口已经打开，它将被刷新。注意:Win32需要' WebView2Loader.dll '。(失败)
     *
     * @param integer $window 窗口对象
     * @param string $content html内容
     * @example 示例 showWv($myWindow,"<html>...</html>"); | show($myWindow, "index.html"); | show($myWindow, "http://...");
     * @return boolean
     */
    public function showWv(int $window, string $content): bool
    {
        return self::$ffi->webui_show_wv($window, $content);
    }

    /**
     * 将窗口设置为Kiosk模式(全屏)。
     * @param integer $window 窗口对象
     * @param boolean $status 状态
     * @example 示例 setKiosk($window, true);
     * @return void
     */
    public function setKiosk(int $window, bool $status): void
    {
        self::$ffi->webui_set_kiosk($window, $status);
    }

    /**
     * 设置具有高对比度支持的窗口。当你想用CSS构建一个更好的高对比度主题时非常有用。
     *
     * @param integer $window 窗口对象
     * @param boolean $status 状态
     * @example 示例 setHighContrast($window, true);
     * @return void
     */
    public function setHighContrast(int $window, bool $status): void
    {
        self::$ffi->set_high_contrast($window, $status);
    }

    /**
     * 获得操作系统高对比度偏好。
     *
     * @example 示例 isHighContrast();
     * @return boolean
     */
    public function isHighContrast(): bool
    {
        return self::$ffi->webui_is_high_contrast();
    }

    /**
     * 检查是否安装了某浏览器。
     *
     * @param integer $browser 浏览器对象
     * @example 示例 browserExist($browser);
     * @return boolean
     */
    public function browserExist(int $browser): bool
    {
        return self::$ffi->webui_browser_exist($browser);
    }

    /**
     * 等到所有开着的窗户都关上了。
     *
     * @example 示例 wait();
     * @return void
     */
    public function wait(): void
    {
        self::$ffi->webui_wait();
    }

    /**
     * 仅关闭特定窗口。窗口对象仍然存在。所有的客户。
     *
     * @param integer $window 窗口对象
     * @example 示例 close($window);
     * @return void
     */
    public function close(int $window): void
    {
        self::$ffi->webui_close($window);
    }

    /**
     * 关闭特定窗口并释放所有内存资源。
     *
     * @param integer $window 窗口对象
     * @example 示例 destroy($window);
     * @return void
     */
    public function destroy(int $window): void
    {
        self::$ffi->webui_destroy($window);
    }

    /**
     * 关闭所有打开的窗口。' wait() '将返回(Break)。
     *
     * @example 示例 exit();
     * @return void
     */
    public function exit(): void
    {
        self::$ffi->webui_exit();
    }

    /**
     * 为特定窗口设置web服务器根文件夹路径。
     *
     * @param integer $window 窗口对象
     * @param string $path 文件夹路径
     * @example 示例 setRootFolder($window,"/home/Foo/Bar/");
     * @return boolean
     */
    public function setRootFolder(int $window, string $path): bool
    {
        return self::$ffi->webui_set_root_folder($window, $path);
    }

    /**
     * 设置所有windows的web服务器根文件夹路径。应该使用在' show() '之前。
     *
     * @param string $path 文件夹路径
     * @example 示例 setDefaultRootFolder("/home/Foo/Bar/");webui_show();
     * @return boolean
     */
    public function setDefaultRootFolder(string $path): bool
    {
        return self::$ffi->webui_set_default_root_folder($path);
    }

    /**
     * 设置一个自定义处理程序来提供文件。这个自定义处理程序应该返回完整的HTTP报头和正文。
     *
     * @param integer $window 窗口对象
     * @param Closure $func 函数 参数 string $filename,int $length
     * @example 示例 setFileHandler($window,function($filename, $length){});
     * @return void
     */
    public function setFileHandler(int $window, Closure $func): void
    {
        $callback = self::$ffi->new('const void *(*)(const char *, int *)');
        $callback = function ($filename, $length) use ($func) {
            return $func($filename, $length);
        };
        self::$ffi->webui_set_file_handler($window, $callback);
    }

    /**
     * 检查指定的窗口是否仍在运行。
     *
     * @param integer $window 窗口对象
     * @example 示例 isShown($window);
     * @return boolean
     */
    public function isShown(int $window): bool
    {
        return self::$ffi->webui_is_shown($window);
    }

    /**
     * 设置等待窗口连接的最大时间(以秒为单位)。这个效果是' show() '和' wait() '。值“0”表示永远等待。
     *
     * @param integer $second 秒
     * @example 示例 setTimeout(30);
     * @return void
     */
    public function setTimeout(int $second): void
    {
        self::$ffi->webui_set_timeout($second);
    }

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
    {
        self::$ffi->webui_set_icon($window, $icon, $iconType);
    }

    /**
     * 将文本编码为Base64。返回的缓冲区需要被释放。(应该可以用PHP自带的)
     *
     * @param string $str
     * @example 示例 encode("Foo Bar");
     * @return string
     */
    public function encode(string $str): string
    {
        return self::$ffi->webui_encode($str);
    }

    /**
     * 解码Base64编码的文本。返回的缓冲区需要被释放。(应该可以用php自带的)
     *
     * @param string $str
     * @example 示例 decode("SGVsbG8=");
     * @return string
     */
    public function decode(string $str): string
    {
        return self::$ffi->webui_decode($str);
    }

    /**
     * 安全地释放由web使用' malloc() '分配的缓冲区。
     *
     * @param mixed $ptr 指针
     * @return void
     */
    public function free(mixed $ptr): void
    {
        $p = self::$ffi->new('void *');
        $p = $ptr;
        self::$ffi->webui_free($p);
    }

    /**
     * 通过web内存管理系统安全分配内存。它可以在任何时候使用' free() '安全地释放。
     *
     * @param integer $size 内存
     * @example 示例 malloc(1024);
     * @return mixed
     */
    public function malloc(int $size): mixed
    {
        return self::$ffi->webui_malloc($size);
    }

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
    {
        self::$ffi->webui_send_raw($window, $func, $raw, $size);
    }

    /**
     * 设置窗口为隐藏模式。应该在' show() '之前调用。
     *
     * @param integer $window 窗口对象
     * @param boolean $status 状态
     * @example 示例 setHide($window, true);show();
     * @return void
     */
    public function setHide(int $window, bool $status): void
    {
        self::$ffi->webui_set_hide($window, $status);
    }

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
    {
        self::$ffi->webui_set_size($window, $width, $height);
    }

    /**
     * 设置窗口位置。
     *
     * @param integer $window 窗口对象
     * @param integer $x
     * @param integer $y
     * @return void
     */
    public function setPosition(int $window, int $x, int $y): void
    {
        self::$ffi->webui_set_position($window, $x, $y);
    }

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
    {
        self::$ffi->webui_set_profile($window, $name, $path);
    }

    /**
     * 设置使用的web浏览器代理服务器。需要在' show() '之前调用。
     *
     * @param integer $window 窗口对象
     * @param string $proxyServer 链接
     * @example 示例 setProxy($window,"http://127.0.0.1:8888");show();
     * @return void
     */
    public function setProxy(int $window, string $proxyServer): void
    {
        self::$ffi->webui_set_proxy($window, $proxyServer);
    }

    /**
     * 获取正在运行的窗口的当前URL。
     *
     * @param integer $window 窗口对象
     * @return string
     */
    public function getUrl(int $window): string
    {
        return self::$ffi->webui_get_url($window);
    }

    /**
     * 在本机默认web浏览器中打开URL。
     *
     * @param string $url 链接
     * @example 示例 openUrl("https://webui.me");
     * @return void
     */
    public function openUrl(string $url): void
    {
        self::$ffi->webui_open_url($url);
    }

    /**
     * 允许从公共网络访问特定的窗口地址。
     *
     * @param integer $window 窗口对象
     * @param boolean $status 状态
     * @example 示例 setPublic($window,true);
     * @return void
     */
    public function setPublic(int $window, bool $status): void
    {
        self::$ffi->webui_set_public($window, $status);
    }

    /**
     * 导航到特定的URL。所有的客户。
     *
     * @param integer $window 窗口对象
     * @param string $url 链接
     * @example 示例 navigate($window,"http://domain.com");
     * @return void
     */
    public function navigate(int $window, string $url): void
    {
        self::$ffi->webui_navigate($window, $url);
    }

    /**
     * 释放所有内存资源。应该只在最后调用。
     *
     * @example 示例 clean();
     * @return void
     */
    public function clean(): void
    {
        self::$ffi->webui_clean();
    }

    /**
     * 删除所有本地web浏览器配置文件文件夹。它应该在最后被调用。
     *
     * @example 示例 wait();deleteAllProfiles();clean();
     * @return void
     */
    public function deleteAllProfiles(): void
    {
        self::$ffi->webui_delete_all_profiles();
    }

    /**
     * 删除特定窗口web-browser本地文件夹配置文件。
     *
     * @param integer $window 窗口对象
     * @example 示例 wait();deleteProfile();clean();
     * @return void
     */
    public function deleteProfile(int $window): void
    {
        self::$ffi->webui_delete_profile($window);
    }

    /**
     * 获取父进程的ID (web浏览器可能会重新创建另一个新进程)。
     *
     * @param integer $window 窗口对象
     * @return integer
     */
    public function getParentProcessId(int $window): int
    {
        return self::$ffi->webui_get_parent_process_id($window);
    }

    /**
     * 获取最后一个子进程的ID。
     *
     * @param integer $window 窗口对象
     * @return integer
     */
    public function getChildProcessId(int $window): int
    {
        return self::$ffi->webui_get_child_process_id($window);
    }

    /**
     * 获取正在运行的窗口的网口。这对于确定' webui.js '的HTTP链接很有用。
     *
     * @param integer $window 窗口对象
     * @return integer
     */
    public function getPort(int $window): int
    {
        return self::$ffi->webui_get_port($window);
    }

    /**
     * 设置web服务使用的自定义web-server/websocket网口。这可以用来确定' web .js '的HTTP链接，如果你试图使用web与外部web服务器如NGNIX。
     *
     * @param integer $window 窗口对象
     * @param integer $port 端口号
     * @return boolean
     */
    public function setPort(int $window, int $port): bool
    {
        return self::$ffi->webui_set_port($window, $port);
    }

    /**
     * 获取一个可用的空闲网络端口。
     *
     * @return integer
     */
    public function getFreePort(): int
    {
        return self::$ffi->webui_get_free_port();
    }

    /**
     * 控制web界面行为。建议在开始时调用。
     *
     * @param object $option C的webui_config
     * @param boolean $status 状态
     * @example 示例 setConfig($option,false);
     * @return void
     */
    public function setConfig(object $option, bool $status): void
    {
        self::$ffi->webui_set_config($option, $status);
    }

    /**
     * 控制来自此窗口的UI事件是否应该在单个阻塞线程中一次处理一个' True '，还是在一个新的非阻塞线程中处理每个事件' False '。此更新单窗口。你可以使用' setConfig(ui_event_blocking，…)'来更新所有的窗口。
     *
     * @param integer $window 窗口对象
     * @param boolean $status 状态
     * @example 示例 setEventBlocking($window, true)
     * @return void
     */
    public function setEventBlocking(int $window, bool $status): void
    {
        self::$ffi->webui_set_event_blocking($window, $status);
    }

    /**
     * 获取文件的HTTP mime类型。(应该可以用PHP自带的)
     *
     * @param string $file 文件
     * @example 示例 getMimeType("foo.png");
     * @return string
     */
    public function getMimeType(string $file): string
    {
        return self::$ffi->webui_get_mime_type($file);
    }

    /**
     * 运行JavaScript而不等待响应。所有的客户。
     *
     * @param integer $window 窗口对象
     * @param string $js js字符串
     * @example 示例 run($window,"alert('Hello');");
     * @return void
     */
    public function run(int $window, string $js): void
    {
        self::$ffi->webui_run($window, $js);
    }

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
    {
        return self::$ffi->webui_script($window, $js, $timeout, $buffer, $bufferLength);
    }

    /**
     * 选择Deno或Nodejs作为.js和.ts文件的运行时。
     *
     * @param integer $window 窗口对象
     * @param integer $runtime 运行时对象
     * @example 示例 setRuntime($window,$runtime);
     * @return void
     */
    public function setRuntime(int $window, int $runtime): void
    {
        self::$ffi->webui_set_runtime($window, $runtime);
    }

    /**
     * 设置窗口的最小大小。
     *
     * @param integer $window 窗口对象
     * @param integer $width 宽度
     * @param integer $height 高度
     * @example 示例 setMinimumSize($window, 800, 600);
     * @return void
     */
    public function setMinimumSize(int $window, int $width, int $height): void
    {
        self::$ffi->webui_set_minimum_size($window, $width, $height);
    }

    /**
     *  在使用‘ bind() ’之后使用这个API来添加任何用户数据
     * 稍后使用‘ setContext() ’读取。
     *
     * @param integer $window 窗口对象
     * @param string $element HTML元素/ JavaScript脚本
     * @param mixed $context 任何用户数据
     * @example 示例 setContext($window,"myID",$myData);
     * @return void
     */
    public function setContext(int $window, string $element, mixed $context): void
    {
        self::$ffi->webui_set_context($window, $element, $context);
    }

    /**
     * 从使用‘ setContext() ’添加的用户数据中获取数据。
     *
     * @param Closure $func 事件
     * @example 示例 $myData = getContext(function($event){});
     * @return mixed
     */
    public function getContext(Closure $func): mixed
    {
        return self::$ffi->webui_get_context($func);
    }

    /**
     * 添加自定义浏览器的CLI参数。
     *
     * @param integer $window 窗口对象
     * @param string $parameters 参数
     * @example 示例 setCustomParameters($window, "--remote-debugging-port=9222");
     * @return void
     */
    public function setCustomParameters(int $window, string $parameters): void
    {
        self::$ffi->webui_set_custom_parameters($window, $parameters);
    }

    /**
     * 设置一个自定义处理程序来提供文件。 这个自定义处理程序应该
     * 返回完整的HTTP报头和正文。
     * 这将禁用任何先前使用‘ setFileHandler ’设置的处理程序。
     *
     * @param integer $window 窗口对象号
     * @param Closure $func 函数 参数 string $filename,int $length
     * @example 示例 setFileHandlerWindow($window,function($filename, $length){});
     * @return void
     */
    public function setFileHandlerWindow(int $window, Closure $func): void
    {
        $callback = function ($window, $filename, $length) use ($func) {
            return $func($window, $filename, $length);
        };
        self::$ffi->webui_set_file_handler_window($window, $callback);
    }

    /**
     * 复制原始数据。
     *
     * @param mixed $dest 目标内存指针
     * @param mixed $src 源内存指针
     * @param integer $count 要复制的字节
     * @return void
     */
    public function memcpy(mixed $dest, mixed $src, int $count): void
    {
        self::$ffi->webui_memcpy($dest, $src, $count);
    }

    /**
     * 获取Win32窗口‘ HWND ’。使用WebView更可靠
     * 比web浏览器窗口，因为浏览器的pid可能会在启动时改变。
     *
     * @param integer $window 窗口对象
     * @example 示例 $hwnd = win32GetHwnd($window);
     * @return mixed HWND
     */
    public function win32GetHwnd(int $window): mixed
    {
        return self::$ffi->webui_win32_get_hwnd($window);
    }
}
