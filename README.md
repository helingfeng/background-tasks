# Background-Tasks

任务参数：

参数名称|是否必填|描述
---|:--:|---:
method|是|任务执行方法 Logic
params|否|执行 Method 所需要的参数
type|否|任务分类，自定义字符串
creator|否|任务提交者，自定义字符串


> 让你的 PHP 代码异步执行起来

Laravel 扩展包，基于 MySQL 后台任务管理工具，使用 Laravel Event Console 执行任务，负责管理和监控任务代码执行状态，让后台任务执行更简单。

![demo](demo1.png)

## Composer 安装

仓库源：https://packagist.org/packages/chester/background-mission

```bash
composer require chester/background-mission
```

## MySQL Migration

创建数据表：不创建数据表是无法正常提交任务的

```bash
background-tasks/src/2018_11_14_104840_test.php
```

配置 Provider：

```php
 Chester\BackgroundMission\Providers\MissionProvider::class
```

## 测试示例

假设后台需要导出1000万条数据，并下载这个文件，下面模拟导出 csv

```php
// hello world. 测试10万条记录后台导出 csv 文件
public function helloWorld()
{
    $filename = storage_path('app') . '/' . date('YmdHis') . ".csv";
    $handle = fopen($filename, 'w');
    fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

    $cur_page = 0;
    fputcsv($handle, ['num', 'datetime']);
    do {
        $cur_page++;
        fputcsv($handle, [$cur_page, date('Y-m-d H:i:s')]);
        // 模拟10万条记录
        if ($cur_page >= 10000000) {
            break;
        }
    } while (true);
    return $this->response(1, "output target file dir: {$filename}");
}
```

运行测试示例：

```markdown
$ php artisan mission:add
```

查看执行状态：

看到任务已经进入后台执行，并显示 Executing 状态。
```markdown
➜  laravel git:(5.5) ✗ php artisan mission:records
+------------------+------------+--------+-----------+--------+--------------------+
| unique_id        | method     | type   | state     | params | content            |
+------------------+------------+--------+-----------+--------+--------------------+
| nauaxnrfnuflwcqn | helloWorld | system | executing | []     |                    |
+------------------+------------+--------+-----------+--------+--------------------+
```

经过一段时间后台，可以看到任务已经完成，并且输出 Content 包含文件 Csv 所在的路径，同时任务为 Success 状态。
```markdown
➜  laravel git:(5.5) ✗ php artisan mission:records
+------------------+------------+--------+---------+--------+---------------------------------------------------------------------+
| unique_id        | method     | type   | state   | params | content                                                             | 
+------------------+------------+--------+---------+--------+---------------------------------------------------------------------+
| nauaxnrfnuflwcqn | helloWorld | system | success | []     | output target file dir: /www/laravel/storage/app/20181117151438.csv |
+------------------+------------+--------+---------+--------+---------------------------------------------------------------------+
```

## 自定义 Logic Functions

新建类：

```php
<?php
namespace App;

use Chester\BackgroundMission\Logic;

class TestLogic extends Logic
{
    public function myTest()
    {
        sleep(20);
        return $this->response(1, 'my test');
    }
}
```

关联配置 config/const.php：

```php
'background_logic' => '\App\TestLogic'
```

请求时，提交任务：

```php
Route::get('bg-test', function () {
    app('chester.bg.queue')->push(['method' => 'myTest']);
});
```