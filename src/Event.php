<?php

declare(strict_types=1);

namespace Kingbes;

class Event extends Base
{
    public int $window;

    public int $event_type;

    public mixed $element;

    public int $event_number;

    public int $bind_id;

    public int $client_id;

    public int $connection_id;

    public mixed $cookies;

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
    public function struct(): object
    {
        return $this->ffi->new("webui_event_t");
    }

}
