<?php

declare(strict_types=1);

namespace Kingbes;

class Webui
{
    protected \FFI $ffi;

    protected mixed $window;

    public function __construct()
    {
        if (PHP_OS_FAMILY != "Windows") {
            throw new \Exception("The OS must be windows!");
        }
        $header = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "webui_php.h");
        $this->ffi = \FFI::cdef($header, __DIR__ . DIRECTORY_SEPARATOR . "os" . DIRECTORY_SEPARATOR  . "webui-2.dll");
    }

    public function newWindow(): self
    {
        $this->window = $this->ffi->webui_new_window();
        return $this;
    }

    public function show(string $html): self
    {
        $this->ffi->webui_show($this->window, $html);
        return $this;
    }

    public function wait(): self
    {
        $this->ffi->webui_wait();
        return $this;
    }

    public function destroy(): void
    {
        $this->ffi->webui_destroy($this->window);
    }
}
