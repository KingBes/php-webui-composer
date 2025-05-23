<?php

declare(strict_types=1);

namespace Kingbes;

use Closure;

/**
 * 包装器
 */
class Wrapper extends Base
{

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
    {
        $callback = self::$ffi->new('void (*)(size_t, size_t, char *, size_t, size_t)');
        $callback = function ($param1, $param2, $param3, $param4, $param5) use ($func) {
            $phpParam3 = self::$ffi->string($param3);
            $func($param1, $param2, $phpParam3, $param4, $param5);
        };
        return self::$ffi->webui_interface_bind($window, $element, $callback);
    }

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
    {
        self::$ffi->webui_interface_set_response($window, $eventNumber, $response);
    }

    /**
     * 检查应用程序是否仍在运行。
     *
     * @return boolean
     */
    public function interfaceIsAppRunning(): bool
    {
        return self::$ffi->webui_interface_is_app_running();
    }

    /**
     * 获取唯一的窗口ID。
     *
     * @param integer $window 窗口对象
     * @return integer
     */
    public function interfaceGetWindowId(int $window): int
    {
        return self::$ffi->webui_interface_get_window_id($window);
    }

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
    {
        return self::webui_interface_get_string_at($window, $eventNumber, $index);
    }

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
    {
        return self::webui_interface_get_int_at($window, $eventNumber, $index);
    }

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
    {
        return self::$ffi->webui_interface_get_float_at($window, $eventNumber, $index);
    }

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
    {
        return self::$ffi->webui_interface_get_bool_at($window, $eventNumber, $index);
    }

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
    {
        return self::$ffi->webui_interface_get_size_at($window, $eventNumber, $index);
    }

    /**
     * 如果你的后端需要异步，使用这个API来设置一个文件处理程序响应
     * 响应‘ setFileHandler() ’。
     *
     * @param integer $window 窗口对象
     * @param string $response 响应缓冲区字符串
     * @param integer $length 响应长度
     * @example 示例 interfaceSetResponseFileHandler($window, $response, 1024);
     * @return void
     */
    public function interfaceSetResponseFileHandler(int $window, string $response, int $length): void
    {
        self::$ffi->webui_interface_set_response_file_handler($window, $response, $length);
    }

    /**
     * 使用嵌入的HTML或文件显示窗口。如果窗口已经
     * 打开，会刷新。单一的客户端。
     *
     * @param integer $window 窗口对象号
     * @param integer $eventNumber 事件号
     * @param string $content HTML、URL或本地文件
     * @return boolean
     */
    public function interfaceShowClient(int $window, int $eventNumber, string $content): bool
    {
        return self::$ffi->webui_interface_show_client($window, $eventNumber, $content);
    }

    /**
     * 关闭特定客户端。
     *
     * @param integer $window 窗口对象号
     * @param integer $eventNumber 事件号
     * @return void
     */
    public function interfaceCloseClient(int $window, int $eventNumber): void
    {
        self::$ffi->webui_interface_close_client($window, $eventNumber);
    }

    /**
     * 安全地将原始数据发送到UI。单一的客户端。
     *
     * @param integer $window 窗口对象
     * @param integer $eventNumber 事件号
     * @param string $data 接收原始数据的JavaScript函数
     * myFunc(myData){}`
     * @param mixed $raw 原始数据缓冲区
     * @param integer $size 原始数据大小（以字节为单位）
     * @return void
     */
    public function interfaceSendRawClient(int $window, int $eventNumber, string $data, mixed $raw, int $size): void
    {
        self::$ffi->webui_interface_send_raw_client($window, $eventNumber, $data, $raw, $size);
    }

    /**
     * 导航到特定的URL。单一的客户端。
     *
     * @param integer $window 窗口号
     * @param integer $eventNumber 事件号
     * @param string $url 完整的HTTP URL
     * @example navigateClient($e,"http://domain.com")
     * @return void
     */
    public function interfaceNavigateClient(int $window, int $eventNumber, string $url): void
    {
        self::$ffi->webui_interface_navigate_client($window, $eventNumber, $url);
    }

    /**
     * 运行JavaScript而不等待响应。单一的客户端。
     *
     * @param integer $window 窗口对象
     * @param integer $eventNumber 事件号
     * @param string $js 要运行的JavaScript
     * @example 示例 interfaceRunClient($window, $event[0]->event_number, "alert('Hello World!')");
     * @return void
     */
    public function interfaceRunClient(int $window, int $eventNumber, string $js): void
    {
        self::$ffi->webui_interface_run_client($window, $eventNumber, $js);
    }

    /**
     * 运行JavaScript并获得响应。单一的客户端。
     * 确保您的本地缓冲区可以保存响应。
     *
     * @param integer $window 窗口对象
     * @param integer $eventNumber 事件号
     * @param string $js 要运行的JavaScript
     * @param integer $timeout 等待时间
     * @param mixed $buffer 缓冲对象 C的char *类型
     * @param integer $bufferLength 缓冲长度
     * @return boolean true表示成功，false表示失败
     */
    public function interfaceScriptClient(int $window, int $eventNumber, string $js, int $timeout, mixed $buffer, int $bufferLength): bool
    {
        return self::$ffi->webui_interface_script_client($window, $eventNumber, $js, $timeout, $buffer, $bufferLength);
    }
}
