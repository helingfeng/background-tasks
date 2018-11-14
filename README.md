# Background-Tasks

**让你的 Functions 支持后台执行**

Laravel 扩展包，基于 MySQL 后台任务管理工具，负责管理和监控任务代码执行状态，让后台任务执行更简单。

## Composer 安装

添加仓库源：

```json
"repositories" : [
    {
      "type": "git",
      "url": "https://github.com/Chester-Hee/background-tasks.git"
    }
]
```

添加扩展包：

```bash
composer require chester/background-mission ^1.1
```

## MySQL Migration

创建数据表：

```bash
background-tasks/src/2018_11_14_104840_test.php
```

配置 Provider：

```php
 Chester\BackgroundMission\Providers\MissionProvider::class
```

添加 Schedule 任务，这个在 push 任务时，主动触发执行：

```php
$schedule->command('mission:execute')->daily()->runInBackground();
```

## 命令测试

添加任务：

```markdown
$ php artisan mission:test-add-task
```

查看任务列表：

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

添加配置项 config/const.php：

```php
'background_logic' => '\App\TestLogic'
```

测试任务提交：

```php
Route::get('bg-test', function () {
    app('chester.bg.queue')->push(['method' => 'myTest'])->runTask();
});
```

查看任务列表：

myTest 这个方法正在执行中。

```markdown
$ php artisan mission:records      
+------------------+--------+--------+-----------+--------+---------+
| unique_id        | method | type   | state     | params | content |
+------------------+--------+--------+-----------+--------+---------+
| rtrrvdedljvqdvcv | myTest | system | executing | []     |         |
+------------------+--------+--------+-----------+--------+---------+
```

20秒后，再次查看任务列表：

myTest 执行完成，并输出 'my test'

```markdown
$ php artisan mission:records      
+------------------+--------+--------+-----------+--------+---------+
| unique_id        | method | type   | state     | params | content |
+------------------+--------+--------+-----------+--------+---------+
| tjyfakjpdghjgvba | myTest | system | success   | []     | my test |
+------------------+--------+--------+-----------+--------+---------+
```
