# Background-Tasks

**让你的 Functions 支持后台执行**

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

假设后台需要导出10万条数据，并下载这个文件，下面模拟导出 csv

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
        fputcsv($handle, [[$cur_page, date('Y-m-d H:i:s')]]);
        // 模拟10万条记录
        if ($cur_page >= 100000) {
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

```markdown
$ php artisan mission:records
+------------------+--------------------------+--------+---------+--------+-------------------+
| unique_id        | method                   | type   | state   | params | content           |
+------------------+--------------------------+--------+---------+--------+-------------------+
| gngkiytndfratiho | helloWorldAfter15Seconds | system | success | []     | after 15 seconds. |
+------------------+--------------------------+--------+---------+--------+-------------------+
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