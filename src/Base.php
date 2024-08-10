<?php

declare(strict_types=1);

namespace Kingbes;

class Base
{
    public static \FFI $ffi;

    /**
     * 构造函数 function
     *
     * @param string|null $libraryFile 库文件路径（库文件在别处的时候使用）
     */
    public function __construct(
        protected ?string $libraryFile = null
    ) {
        if (!isset(self::$ffi)) {
            $header = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "webui_php.h");
            self::$ffi = \FFI::cdef($header, $this->library());
        }
    }

    /**
     * 获取ffi
     *
     * @return \FFI
     */
    public function getFfi(): \FFI
    {
        return self::$ffi;
    }

    /**
     * 库文件 function
     *
     * @return string
     */
    protected function library(): string
    {
        if ($this->libraryFile !== null) {
            return $this->libraryFile;
        }

        $this->libraryFile = match (PHP_OS_FAMILY) {
            'Linux'   => __DIR__ . DIRECTORY_SEPARATOR . "os" . DIRECTORY_SEPARATOR  . "webui-2.so",
            'Darwin'  => __DIR__ . DIRECTORY_SEPARATOR . "os" . DIRECTORY_SEPARATOR  . "webui-2.dylib",
            'Windows' => __DIR__ . DIRECTORY_SEPARATOR . "os" . DIRECTORY_SEPARATOR  . "webui-2.dll",
            default   => throw new \Exception("Os is not supported, Only Linux, MacOs and windows are only supported by default!")
        };

        return $this->libraryFile;
    }
}
