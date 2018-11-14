<?php
/**
 * User: helingfeng
 */

namespace Chester\BackgroundMission\Managers;

use Chester\BackgroundMission\DataBases\BackgroundTasks;
use Chester\BackgroundMission\MissionInterface;

class DataBaseMission implements MissionInterface
{
    public function __construct()
    {

    }

    public function getLastInitTasks($limit = 5)
    {
        return BackgroundTasks::where('state', BackgroundTasks::STATE_INIT)->orderBy('created_date', 'desc')->limit($limit)->get()->toArray();
    }

    public function getLastTasksByType($type = 'system', $limit = 10)
    {
        return BackgroundTasks::where('type', $type)->orderBy('created_date', 'desc')->limit($limit)->get()->toArray();
    }

    public function hasInitTask()
    {
        return BackgroundTasks::where('state', BackgroundTasks::STATE_INIT)->first() ? true : false;
    }

    public function addTask($param)
    {
        $task = new BackgroundTasks();
        $task->unique_id = $this->createNonceString();
        $task->method = isset($param['method']) ? $param['method'] : 'helloWorld';
        $task->params = $this->jsonEncode(isset($param['params']) ? $param['params'] : []);
        $task->type = isset($param['type']) ? $param['type'] : 'system';
        $task->created_date = date('Y-m-d H:i:s');
        $task->modified_date = date('Y-m-d H:i:s');
        $task->state = BackgroundTasks::STATE_INIT;
        return $task->save();
    }

    public function changeTaskStateByIds($task_ids, $state, $content = '')
    {
        if (is_string($task_ids)) {
            $task_ids = [$task_ids];
        }
        return BackgroundTasks::whereIn('unique_id', $task_ids)
            ->update(['state' => $state, 'content' => $content, 'modified_date' => date('Y-m-d H:i:s')]);
    }

    public function getTaskById($task_id)
    {
        return BackgroundTasks::where('unique_id', $task_id)->first()->toArray();
    }

    public function createNonceString($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function jsonEncode($param)
    {
        return json_encode($param, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }


}