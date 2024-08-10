<?php

declare(strict_types=1);

namespace Kingbes;

use Closure;

class Webui extends Base
{
    /**
     * 创建一个新的web窗口对象。 function
     *
     * @return int
     */
    public function newWindow(): int
    {
        return $this->ffi->webui_new_window();
    }

    /**
     * 使用指定的窗口号创建新的web窗口对象。
     *
     * @param integer $windows web窗口对象
     * @return integer
     */
    public function newWindowId(int $windows): int
    {
        return $this->ffi->webui_new_window_id($windows);
    }

    /**
     * 获得一个可以使用的免费窗口对象
     *
     * @return integer
     */
    public function getNewWindowId(): int
    {
        return $this->ffi->webui_get_new_window_id();
    }

    /**
     * 用后端函数绑定一个HTML元素和一个JavaScript对象。空元素名称表示所有事件。 function
     *
     * @param integer $windows 窗口对象
     * @param string $element 绑定js函数名
     * @param Closure $func php函数
     * @return boolean
     */
    public function bind(
        int $windows,
        string $element,
        Closure $func
    ): mixed {
        $callback = $this->ffi->new('void (*)(webui_event_t *)');
        $then = $this;
        $callback = function ($event) use ($func, $then) {
            return $func((object)$event[0], $then);
        };
        return $this->ffi->webui_bind($windows, $element, $callback);
    }

    public function getString(Event $e): string
    {
        return $this->ffi->webui_get_string($e);
    }

    /**
     * 使用嵌入的HTML或文件显示窗口。如果窗口已经打开，它将被刷新。这将刷新多客户端模式下的所有窗口。
     *
     * @param integer $windows web窗口对象
     * @param string $content html内容
     * @example 示例 show($myWindow,"<html>...</html>"); | show($myWindow, "index.html"); | show($myWindow, "http://...");
     * @return boolean
     */
    public function show(int $windows, string $content): bool
    {
        return $this->ffi->webui_show($windows, $content);
    }

    public function showWv(int $windows, string $content): bool
    {
        return $this->ffi->webui_show_wv($windows, $content);
    }

    /**
     * 等到所有开着的窗户都关上了。
     *
     * @return void
     */
    public function wait(): void
    {
        $this->ffi->webui_wait();
    }
}
