<?php

declare(strict_types=1);

namespace Kingbes;

class Cobj extends Base
{
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
    {
        return self::$ffi->new("struct webui_event_t");
    }

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
    {
        return self::$ffi->new("webui_config");
    }
}
