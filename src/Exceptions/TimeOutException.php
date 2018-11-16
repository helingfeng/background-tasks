<?php
/**
 * User: helingfeng
 */

namespace Chester\BackgroundMission\Exceptions;


class TimeOutException extends \Exception
{
    protected $code = 500;
    protected $message = '任务执行时间超时.';
}