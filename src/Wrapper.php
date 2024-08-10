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
}
