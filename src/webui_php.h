typedef struct webui_event_t
{
    size_t window;        // 窗口对象号
    size_t event_type;    // 事件类型
    const char *element;  // HTML元素ID
    size_t event_number;  // 内部WebUI
    size_t bind_id;       // 绑定 id
    size_t client_id;     // 客户端唯一ID
    size_t connection_id; // 客户端连接ID
    const char *cookies;  // 客户的全部 cookies
} webui_event_t;

typedef enum
{
    // 控制' webui_show() '， ' webui_show_browser() '和
    // ' webui_show_wv() '应该等待窗口连接
    // before是否返回。
    //
    // 默认值:True
    show_wait_connection = 0,
    // 控制web是否应该阻塞和处理UI事件
    // 在一个线程中一次处理一个' True '，或者处理每一个
    // 一个新的非阻塞线程中的事件' False '。这个更新
    // 所有窗口。你可以使用' webui_set_event_blocking() '
    // 一个特定的单窗口更新。
    //
    // 默认值:False
    ui_event_blocking,
    // 自动刷新窗口UI
    // 根目录被更改。
    //
    // 默认值:False
    folder_monitor,
    // 允许多个客户端连接到同一个窗口
    // 这对web应用程序(非桌面软件)很有帮助，
    // 详细信息请参考文档。
    //
    // 默认值:False
    multi_client,
    // 允许多个客户端连接到同一个窗口
    // 这对web应用程序(非桌面软件)很有帮助，
    // 详细信息请参考文档。
    //
    // 默认值:False
    use_cookies,
} webui_config;

// -- 定义 ---------------------

// 创建一个新的web窗口对象。
// size_t myWindow = webui_new_window();
size_t webui_new_window(void);

// 使用指定的窗口号创建新的web窗口对象。
// size_t myWindow = webui_new_window_id(123);
size_t webui_new_window_id(size_t window_number);

// 获得一个可以使用的免费窗口对象
// size_t myWindowNumber = webui_get_new_window_id();
size_t webui_get_new_window_id(void);

// 用后端函数绑定一个HTML元素和一个JavaScript对象。空元素名称表示所有事件。
// webui_bind(myWindow, "myFunction", myFunction);
size_t webui_bind(size_t window, const char *element, void (*func)(webui_event_t *e));

// 获取要使用的推荐web浏览器ID。如果您已经使用了一个ID，则此函数将返回相同的ID。
// size_t browserID = webui_get_best_browser(myWindow);
size_t webui_get_best_browser(size_t window);

// 使用嵌入的HTML或文件显示窗口。如果窗口已经打开，它将被刷新。这将刷新多客户端模式下的所有窗口。
// webui_show(myWindow, "<html>...</html>"); | webui_show(myWindow, "index.html"); | webui_show(myWindow, "http://...");
bool webui_show(size_t window, const char *content);

// 使用嵌入的HTML或文件显示窗口。如果窗口已经打开，它将被刷新。单一的客户端。
// webui_show_client(e, "<html>...</html>"); | webui_show_client(e, "index.html"); | webui_show_client(e, "http://...");
bool webui_show_client(webui_event_t *e, const char *content);

// 与' webui_show() '相同。但是使用特定的网络浏览器。
// webui_show_browser(myWindow, "<html>...</html>", Chrome); | webui_show(myWindow, "index.html", Firefox);
bool webui_show_browser(size_t window, const char *content, size_t browser);

// 与' webui_show() '相同。但是只启动web服务器并返回URL。不会显示任何窗口。
// const char* url = webui_start_server(myWindow, "/full/root/path");
const char *webui_start_server(size_t window, const char *content);

// 使用嵌入的HTML或文件显示WebView窗口。如果窗口已经打开，它将被刷新。注意:Win32需要' WebView2Loader.dll '。
// webui_show_wv(myWindow, "<html>...</html>"); | webui_show_wv(myWindow, "index.html"); | webui_show_wv(myWindow, "http://...");
bool webui_show_wv(size_t window, const char *content);

// 将窗口设置为Kiosk模式(全屏)。
// webui_set_kiosk(myWindow, true);
void webui_set_kiosk(size_t window, bool status);

// 设置具有高对比度支持的窗口。当你想用CSS构建一个更好的高对比度主题时非常有用。
// webui_set_high_contrast(myWindow, true);
void webui_set_high_contrast(size_t window, bool status);

// 获得操作系统高对比度偏好。
// bool hc = webui_is_high_contrast();
bool webui_is_high_contrast(void);

// 检查是否安装了浏览器。
// bool status = webui_browser_exist(Chrome);
bool webui_browser_exist(size_t browser);

// 等到所有开着的窗户都关上了。
// webui_wait();
void webui_wait(void);

// 仅关闭特定窗口。窗口对象仍然存在。所有的客户。
// webui_close(myWindow);
void webui_close(size_t window);

// 关闭特定客户端。
// webui_close_client(e);
void webui_close_client(webui_event_t *e);

// 关闭特定窗口并释放所有内存资源。
// webui_destroy(myWindow);
void webui_destroy(size_t window);

// 关闭所有打开的窗口。' webui_wait() '将返回(Break)。
// webui_exit();
void webui_exit(void);

// 为特定窗口设置web服务器根文件夹路径。
// webui_set_root_folder(myWindow, "/home/Foo/Bar/");
bool webui_set_root_folder(size_t window, const char *path);

// 设置所有windows的web服务器根文件夹路径。应该使用在' webui_show() '之前。
// webui_set_default_root_folder("/home/Foo/Bar/");
bool webui_set_default_root_folder(const char *path);

// 设置一个自定义处理程序来提供文件。这个自定义处理程序应该返回完整的HTTP报头和正文。
// webui_set_file_handler(myWindow, myHandlerFunction);
void webui_set_file_handler(size_t window, const void *(*handler)(const char *filename, int *length));

// 检查指定的窗口是否仍在运行。
// webui_is_shown(myWindow);
bool webui_is_shown(size_t window);

// 设置等待窗口连接的最大时间(以秒为单位)。这个效果是' show() '和' wait() '。值“0”表示永远等待。
// webui_set_timeout(30);
void webui_set_timeout(size_t second);

// 设置默认的嵌入HTML图标。
// webui_set_icon(myWindow, "<svg>...</svg>", "image/svg+xml");
void webui_set_icon(size_t window, const char *icon, const char *icon_type);

// 将文本编码为Base64。返回的缓冲区需要被释放。
// char* base64 = webui_encode("Foo Bar");
const char *webui_encode(const char *str);

// 解码Base64编码的文本。返回的缓冲区需要被释放。
// char* str = webui_decode("SGVsbG8=");
const char *webui_decode(const char *str);

// 安全地释放由web使用' webui_malloc() '分配的缓冲区。
// webui_free(myBuffer);
void webui_free(void *ptr);

// 通过web内存管理系统安全分配内存。它可以在任何时候使用' webui_free() '安全地释放。
// char* myBuffer = (char*)webui_malloc(1024);
void *webui_malloc(size_t size);

// 安全地将原始数据发送到UI。所有的客户。
// webui_send_raw(myWindow, "myJavaScriptFunc", myBuffer, 64);
void webui_send_raw(size_t window, const char *function, const void *raw, size_t size);

// 安全地将原始数据发送到UI。单一的客户端。
// webui_send_raw_client(e, "myJavaScriptFunc", myBuffer, 64);
void webui_send_raw_client(webui_event_t *e, const char *function, const void *raw, size_t size);

// 设置窗口为隐藏模式。应该在' webui_show() '之前调用。
// webui_set_hide(myWindow, True);
void webui_set_hide(size_t window, bool status);

// 设置窗口大小。
// webui_set_size(myWindow, 800, 600);
void webui_set_size(size_t window, unsigned int width, unsigned int height);

// 设置窗口位置。
// webui_set_position(myWindow, 100, 100);
void webui_set_position(size_t window, unsigned int x, unsigned int y);

// 设置要使用的web浏览器配置文件。空的“name”和“path”表示默认的用户配置文件。需要在' webui_show() '之前调用。
// webui_set_profile(myWindow, "Bar", "/Home/Foo/Bar"); | webui_set_profile(myWindow, "", "");
void webui_set_profile(size_t window, const char *name, const char *path);

// 设置使用的web浏览器代理服务器。需要在' webui_show() '之前调用。
// webui_set_proxy(myWindow, "http://127.0.0.1:8888");
void webui_set_proxy(size_t window, const char *proxy_server);

// 获取正在运行的窗口的当前URL。
// const char* url = webui_get_url(myWindow);
const char *webui_get_url(size_t window);

// 在本机默认web浏览器中打开URL。
// webui_open_url("https://webui.me");
void webui_open_url(const char *url);

// 允许从公共网络访问特定的窗口地址。
// webui_set_public(myWindow, true);
void webui_set_public(size_t window, bool status);

// 导航到特定的URL。所有的客户。
// webui_navigate(myWindow, "http://domain.com");
void webui_navigate(size_t window, const char *url);

// 导航到特定的URL。单一的客户端。
// webui_navigate_client(e, "http://domain.com");
void webui_navigate_client(webui_event_t *e, const char *url);

// 释放所有内存资源。应该只在最后调用。
// webui_wait();
// webui_clean();
void webui_clean(void);

// 删除所有本地web浏览器配置文件文件夹。它应该在最后被调用。
// webui_wait();
// webui_delete_all_profiles();
// webui_clean();
void webui_delete_all_profiles(void);

// 删除特定窗口web-browser本地文件夹配置文件。
// webui_wait();
// webui_delete_profile(myWindow);
// webui_clean();
// 提示：如果使用相同的web浏览器，这可能会破坏其他窗口的功能。
void webui_delete_profile(size_t window);

// 获取父进程的ID (web浏览器可能会重新创建另一个新进程)。
// size_t id = webui_get_parent_process_id(myWindow);
size_t webui_get_parent_process_id(size_t window);

// 获取最后一个子进程的ID。
// size_t id = webui_get_child_process_id(myWindow);
size_t webui_get_child_process_id(size_t window);

// 获取正在运行的窗口的网口。这对于确定' webui.js '的HTTP链接很有用。
// size_t port = webui_get_port(myWindow);
size_t webui_get_port(size_t window);

// 设置web服务使用的自定义web-server/websocket网口。这可以用来确定' web .js '的HTTP链接，如果你试图使用web与外部web服务器如NGNIX。
// bool ret = webui_set_port(myWindow, 8080);
bool webui_set_port(size_t window, size_t port);

// 获取一个可用的空闲网络端口。
// size_t port = webui_get_free_port();
size_t webui_get_free_port(void);

// 控制web界面行为。建议在开始时调用。
// webui_set_config(show_wait_connection, false);
void webui_set_config(webui_config option, bool status);

// 控制来自此窗口的UI事件是否应该在单个阻塞线程中一次处理一个' True '，还是在一个新的非阻塞线程中处理每个事件' False '。此更新单窗口。你可以使用' webui_set_config(ui_event_blocking，…)'来更新所有的窗口。
// webui_set_event_blocking(myWindow, true);
void webui_set_event_blocking(size_t window, bool status);

// 获取文件的HTTP mime类型。
// const char* mime = webui_get_mime_type("foo.png");
const char *webui_get_mime_type(const char *file);

// -- JavaScript ----------------------

// 运行JavaScript而不等待响应。所有的客户。
// webui_run(myWindow, "alert('Hello');");
void webui_run(size_t window, const char *script);

// 运行JavaScript而不等待响应。单一的客户端。
// webui_run_client(e, "alert('Hello');");
void webui_run_client(webui_event_t *e, const char *script);

// 运行JavaScript并获得响应。仅在单客户端模式下工作。确保您的本地缓冲区可以保存响应。
// bool err = webui_script(myWindow, "return 4 + 6;", 0, myBuffer, myBufferSize);
bool webui_script(size_t window, const char *script, size_t timeout, char *buffer, size_t buffer_length);

// 运行JavaScript并获得响应。单一的客户端。确保您的本地缓冲区可以保存响应。
// bool err = webui_script_client(e, "return 4 + 6;", 0, myBuffer, myBufferSize);
bool webui_script_client(webui_event_t *e, const char *script, size_t timeout, char *buffer, size_t buffer_length);

// 选择Deno和Nodejs作为.js和.ts文件的运行时。
// webui_set_runtime(myWindow, Deno);
void webui_set_runtime(size_t window, size_t runtime);

// 得到事件中有多少个参数。
// size_t count = webui_get_count(e);
size_t webui_get_count(webui_event_t *e);

// 在特定索引处获取参数为整数。
// long long int myNum = webui_get_int_at(e, 0);
long long int webui_get_int_at(webui_event_t *e, size_t index);

// 获取第一个参数为整数。
// long long int myNum = webui_get_int(e);
long long int webui_get_int(webui_event_t *e);

// 在特定索引处获取float参数。
// double myNum = webui_get_float_at(e, 0);
double webui_get_float_at(webui_event_t *e, size_t index);

// 获取第一个参数为float。
// double myNum = webui_get_float(e);
double webui_get_float(webui_event_t *e);

// 在特定索引处以字符串形式获取参数。
// const char* myStr = webui_get_string_at(e, 0);
const char *webui_get_string_at(webui_event_t *e, size_t index);

// 获取第一个参数为字符串。
// const char* myStr = webui_get_string(e);
const char *webui_get_string(webui_event_t *e);

// 在特定索引处获取一个布尔参数。
// bool myBool = webui_get_bool_at(e, 0);
bool webui_get_bool_at(webui_event_t *e, size_t index);

// 获取第一个参数为布尔值。
// bool myBool = webui_get_bool(e);
bool webui_get_bool(webui_event_t *e);

// 获取特定索引处参数的大小(以字节为单位)。
// size_t argLen = webui_get_size_at(e, 0);
size_t webui_get_size_at(webui_event_t *e, size_t index);

// 获取第一个参数的字节大小。
// size_t argLen = webui_get_size(e);
size_t webui_get_size(webui_event_t *e);

// 将响应作为整数返回给JavaScript。
// webui_return_int(e, 123);
void webui_return_int(webui_event_t *e, long long int n);

// 将响应作为浮点数返回给JavaScript。
// webui_return_float(e, 123.456);
void webui_return_float(webui_event_t *e, double f);

// 将响应作为字符串返回给JavaScript。
// webui_return_string(e, "Response...");
void webui_return_string(webui_event_t *e, const char *s);

// 将响应作为布尔值返回给JavaScript。
// webui_return_bool(e, true);
void webui_return_bool(webui_event_t *e, bool b);

// -- 包装器的接口 -------------

// 将特定的HTML元素click事件与函数绑定。空元素表示所有事件。
// size_t id = webui_interface_bind(myWindow, "myID", myCallback);
size_t webui_interface_bind(size_t window, const char *element, void (*func)(size_t, size_t, char *, size_t, size_t));

// 当使用' webui_interface_bind() '时，你可能需要这个函数来方便地设置响应。
// webui_interface_set_response(myWindow, e->event_number, "Response...");
void webui_interface_set_response(size_t window, size_t event_number, const char *response);

// 检查应用程序是否仍在运行。
// bool status = webui_interface_is_app_running();
bool webui_interface_is_app_running(void);

// 获取唯一的窗口ID。
// size_t id = webui_interface_get_window_id(myWindow);
size_t webui_interface_get_window_id(size_t window);

// 在特定索引处以字符串形式获取参数。
// const char* myStr = webui_interface_get_string_at(myWindow, e->event_number, 0);
const char *webui_interface_get_string_at(size_t window, size_t event_number, size_t index);

// 在特定索引处获取参数为整数。
// long long int myNum = webui_interface_get_int_at(myWindow, e->event_number, 0);
long long int webui_interface_get_int_at(size_t window, size_t event_number, size_t index);

// 在特定索引处获取float参数。
// double myFloat = webui_interface_get_int_at(myWindow, e->event_number, 0);
double webui_interface_get_float_at(size_t window, size_t event_number, size_t index);

// 在特定索引处获取一个布尔参数。
// bool myBool = webui_interface_get_bool_at(myWindow, e->event_number, 0);
bool webui_interface_get_bool_at(size_t window, size_t event_number, size_t index);

// 获取特定索引处参数的大小(以字节为单位)。
//  size_t argLen = webui_interface_get_size_at(myWindow, e->event_number, 0);
size_t webui_interface_get_size_at(size_t window, size_t event_number, size_t index);
