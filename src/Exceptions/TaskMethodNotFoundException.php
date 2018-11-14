<?php
/**
 * User: helingfeng
 */

namespace Chester\BackgroundMission\Exceptions;


class TaskMethodNotFoundException extends \Exception
{
    protected $code = 500;
    protected $message = '任务不存在';
}