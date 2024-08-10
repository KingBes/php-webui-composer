<?php

declare(strict_types=1);

namespace Kingbes;

/**
 * js交互 class
 */
class JavaScript extends Base
{
    /**
     * 关闭特定客户端。
     *
     * @param object $event
     * @example 示例 closeClient($event);
     * @return void
     */
    public function closeClient(object $event): void
    {
        self::$ffi->webui_close_client($event);
    }

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
    {
        self::$ffi->webui_send_raw_client($event, $func, $raw, $size);
    }

    /**
     * 导航到特定的URL。单一的客户端。
     *
     * @param object $event
     * @param string $url 链接
     * @example 示例 navigateClient($event,"http://domain.com");
     * @return void
     */
    public function navigateClient(object $event, string $url): void
    {
        self::$ffi->webui_navigate_client($event, $url);
    }

    /**
     * 运行JavaScript而不等待响应。单一的客户端。
     *
     * @param object $event
     * @param string $js js字符串
     * @example 示例 runClient($event,"alert('Hello');");
     * @return void
     */
    public function runClient(object $event, string $js): void
    {
        self::$ffi->webui_run_client($event, $js);
    }

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
    {
        return self::$ffi->webui_script_client($event, $js, $timeout, $buffer, $bufferLength);
    }

    /**
     * 得到事件中有多少个参数。
     *
     * @param object $event
     * @return integer
     */
    public function getCount(object $event): int
    {
        return self::$ffi->webui_get_count($event);
    }

    /**
     * 在特定索引处获取参数为整数。
     *
     * @param object $event
     * @param integer $index 索引
     * @example 示例 $myNum = getIntAt($event,0);
     * @return integer
     */
    public function getIntAt(object $event, int $index): int
    {
        return self::$ffi->webui_get_int_at($event, $index);
    }

    /**
     * 获取第一个参数为整数。
     *
     * @param object $event
     * @example 示例 $myNum = getInt($event);
     * @return integer
     */
    public function getInt(object $event): int
    {
        return self::$ffi->webui_get_int($event);
    }

    /**
     * 在特定索引处获取float参数。
     *
     * @param object $event
     * @param integer $index 索引
     * @example 示例 $myfloat = getFloatAt($event, 0);
     * @return float
     */
    public function getFloatAt(object $event, int $index): float
    {
        return self::$ffi->webui_get_float_at($event, $index);
    }

    /**
     * 获取第一个参数为float。
     *
     * @param object $event
     * @example 示例 $myfloat = getFloat($event);
     * @return float
     */
    public function getFloat(object $event): float
    {
        return self::$ffi->webui_get_float($event);
    }

    /**
     * 在特定索引处以字符串形式获取参数。
     *
     * @param object $event
     * @param integer $index 索引
     * @example 示例 $myString = getStringAt($event, 0);
     * @return string
     */
    public function getStringAt(object $event, int $index): string
    {
        return self::$ffi->webui_get_string_at($event, $index);
    }

    /**
     * 获取第一个参数为字符串。
     *
     * @param object $event
     * @example 示例 $myString = getString($event);
     * @return string
     */
    public function getString(object $event): string
    {
        return self::$ffi->webui_get_string($event);
    }

    /**
     * 在特定索引处获取一个布尔参数。
     *
     * @param object $event
     * @param integer $index 索引
     * @example 示例 $myBool = getBoolAt($event, 0);
     * @return boolean
     */
    public function getBoolAt(object $event, int $index): bool
    {
        return self::$ffi->webui_get_bool_at($event, $index);
    }

    /**
     * 获取第一个参数为布尔值。
     *
     * @param object $event
     * @example 示例 $myBool = getBool($event);
     * @return boolean
     */
    public function getBool(object $event): bool
    {
        return self::$ffi->webui_get_bool($event);
    }

    /**
     * 获取特定索引处参数的大小(以字节为单位)。
     *
     * @param object $event 
     * @param integer $index 索引
     * @example 示例 $mySzie = getSizeAt($event, 0);
     * @return integer
     */
    public function getSizeAt(object $event, int $index): int
    {
        return self::$ffi->webui_get_size_at($event, $index);
    }

    /**
     * 获取第一个参数的字节大小。
     *
     * @param object $event
     * @example 示例 $mySzie = getSizeAt($event);
     * @return integer
     */
    public function getSize(object $event): int
    {
        return self::$ffi->webui_get_size($event);
    }

    /**
     * 将响应作为整数返回给JavaScript。
     *
     * @param object $event
     * @param integer $num
     * @example 示例 returnInt($event, 123);
     * @return void
     */
    public function returnInt(object $event, int $num): void
    {
        self::$ffi->webui_return_int($event, $num);
    }

    /**
     * 将响应作为浮点数返回给JavaScript。
     *
     * @param object $event
     * @param float $double 浮点
     * @example 示例 returnFloat($event,123.456);
     * @return void
     */
    public function returnFloat(object $event, float $double): void
    {
        self::$ffi->webui_return_float($event, $double);
    }

    /**
     * 将响应作为字符串返回给JavaScript。
     *
     * @param object $event
     * @param string $str 字符串
     * @example 示例 returnString($event,"hello world");
     * @return void
     */
    public function returnString(object $event, string $str): void
    {
        self::$ffi->webui_return_string($event, $str);
    }

    /**
     * 将响应作为布尔值返回给JavaScript。
     *
     * @param object $event
     * @param boolean $bool
     * @return void
     */
    public function returnBool(object $event, bool $boolean): void
    {
        self::$ffi->webui_return_bool($event, $boolean);
    }
}
