<?php

declare(strict_types=1);

namespace Kingbes;

class Base
{
    public static \FFI $ffi;

    /**
     * 构造函数  function
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
        $this->libraryFile = $this->osFamily();
        return $this->libraryFile;
    }

    /**
     * 库文件路径 function
     *
     * @return string
     */
    protected function osFamily(): string
    {
        switch (PHP_OS_FAMILY) {
            case "Linux":
                $arch = php_uname('m');
                if ($arch === 'x86_64') {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Linux"
                        . DIRECTORY_SEPARATOR . "x64"
                        . DIRECTORY_SEPARATOR  . "webui-2.so";
                } elseif ($arch === 'arm' || $arch === 'armv7l') {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Linux"
                        . DIRECTORY_SEPARATOR . "arm"
                        . DIRECTORY_SEPARATOR  . "webui-2.so";
                } elseif ($arch === 'aarch64') {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Linux"
                        . DIRECTORY_SEPARATOR . "arm64"
                        . DIRECTORY_SEPARATOR  . "webui-2.so";
                } else {
                    throw new \Exception("linux supports only x64, arm, and arm64");
                }
                break;
            case "Darwin":
                $unameOutput = '';
                exec('uname -m', $unameOutput);
                if (in_array(trim($unameOutput[0]), ['X86_64', 'x86_64'])) {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Darwin"
                        . DIRECTORY_SEPARATOR . "x64"
                        . DIRECTORY_SEPARATOR  . "webui-2.dylib";
                } elseif (in_array(trim($unameOutput[0]), ['ARM64', 'arm64'])) {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Darwin"
                        . DIRECTORY_SEPARATOR . "arm64"
                        . DIRECTORY_SEPARATOR  . "webui-2.dylib";
                } else {
                    throw new \Exception("Only macos x64 and arm64 are supported");
                }
                break;
            case "Windows":
                if (PHP_INT_SIZE == 8) {
                    return __DIR__ . DIRECTORY_SEPARATOR . "os"
                        . DIRECTORY_SEPARATOR . "Windows"
                        . DIRECTORY_SEPARATOR . "x64"
                        . DIRECTORY_SEPARATOR  . "webui-2.dll";
                } else {
                    throw new \Exception("windows 32-bit system is not supported");
                }
                break;
            default:
                throw new \Exception("Os is not supported, Only Linux, MacOs and windows are only supported by default!");
        }
    }
}
