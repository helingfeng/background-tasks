## Laravel 扩展包调试方法

- 准备一份 Laravel 框架代码

```bash
git clone https://github.com/laravel/laravel.git
```

- 将扩展包下载到 Laravel 框架根目录下

```bash
cd laravel 
mkdir packages
git clone https://github.com/Chester-Hee/background-tasks.git
```

- 配置 composer.json 

```json
"autoload": {
    "psr-4": {
        "Chester\\BackgroundMission\\": "packages/background-tasks/src/"
    }
}
```

- 配置依赖包 Provider

```bash
composer install 
```

config/app.php 添加

```php
Chester\BackgroundMission\Providers\MissionProvider::class
```

初始化 Laravel 框架 .env

```bash
cp .env.example .env
```

配置完成后，可以开始调试扩展包！