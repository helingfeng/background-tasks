<?php
/**
 * User: helingfeng
 */

namespace Chester\BackgroundMission\Exceptions;


class MethodIsRunningException extends \Exception
{
    protected $code = 500;
    protected $message = '任务 method 正在执行中.';
}