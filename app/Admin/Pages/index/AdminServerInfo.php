<?php


namespace App\Admin\Pages\index;

use Illuminate\Contracts\Support\Renderable;

class AdminServerInfo implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        $data = json_encode($data);
        return view('backstage.index.server_info', ['data' => $data]);
    }

    /**
     * Notes: 服务器信息
     * User: 62726
     * Date: 2020/12/14
     * Time: 10:40
     * @return array[]
     */
    public function statement()
    {
        $server_config = [
            'IP地址' => $_SERVER['SERVER_ADDR'],
            '域名' => $_SERVER['SERVER_NAME'],
            '端口' => $_SERVER['SERVER_PORT'],
            '版本' => php_uname('s') . php_uname('r'),
            '操作系统' => php_uname(),
            'PHP版本' => PHP_VERSION,
//            '获取PHP安装路径' => DEFAULT_INCLUDE_PATH,
//            '获取当前文件绝对路径' => __FILE__,
//            '获取Http请求中Host值' => $_SERVER["HTTP_HOST"],
//            '获取Zend版本' => Zend_Version(),
            'Laravel版本' => $laravel = app()::VERSION,
//            'PHP运行方式' => php_sapi_name(),
            '当前时间' => date("Y-m-d H:i:s"),
//            '最大上传限制' => get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许",
//            '最大执行时间' => get_cfg_var("max_execution_time") . "秒 ",
            '运行占用最大内存' => get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : "无",
//            '获取服务器解译引擎' => $_SERVER['SERVER_SOFTWARE'],
            'CPU数量' => $_SERVER['PROCESSOR_IDENTIFIER'] ?? '',
//            '获取服务器系统目录' => $_SERVER['SystemRoot'],
//            '获取服务器域名（主机名）' => $_SERVER['SERVER_NAME'],// (建议使用：$_SERVER["HTTP_HOST"])
//            '获取用户域名' => $_SERVER['USERDOMAIN'] ?? '',
//            '服务器语言' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
//            '服务器Web端口' => $_SERVER['SERVER_PORT'],
//            '获取请求页面时通信协议的名称和版本' => $_SERVER['SERVER_PROTOCOL']
        ];
        return $server_config;
    }
}
