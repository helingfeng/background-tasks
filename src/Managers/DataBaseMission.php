<?php
/**
 * User: helingfeng
 */

namespace Chester\BackgroundMission\Managers;

use Chester\BackgroundMission\MissionInterface;

class DataBaseMission implements MissionInterface
{
    public function __construct()
    {

    }

    public function getLastInitTasks($limit = 5)
    {
        // TODO: Implement getLastInitTasks() method.
    }

    public function getLastTasksByType($type = 'system', $limit = 10)
    {
        // TODO: Implement getLastTasksByType() method.
    }

    public function hasInitTask()
    {
        // TODO: Implement hasInitTask() method.
    }

    public function addTask($task)
    {
        // TODO: Implement addTask() method.
    }

    public function changeTaskStateByIds($task_id, $state, $content = '')
    {
        // TODO: Implement changeTaskStateById() method.
    }

    public function getTaskById($task_id)
    {
        // TODO: Implement getTaskById() method.
    }

    public function getLastTasks($limit = 5)
    {
        // TODO: Implement getLastTasks() method.
    }
//    /**
//     * @return string
//     */
//    public function getTableName()
//    {
//        return $this->table_name;
//    }
//
//    public function get($condition, $limit = 10)
//    {
//        // $condition = ['type' => 'system']
//        return DB::table($this->table_name)->where($condition)->limit($limit)->get()->toArray();
//    }
//
//    public function insert($method, $params, $type = 'system')
//    {
//        $task['unique_id'] = cbb_create_nonce_str(15);
//        $task['method'] = $method;
//        $task['params'] = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
//        $task['created_date'] = date('Y-m-d H:i:s');
//        $task['modified_date'] = date('Y-m-d H:i:s');
//        $task['type'] = $type;
//        $result = DB::table($this->table_name)->insert($task);
//        return $result ? $task['unique_id'] : null;
//    }
//
//    public function updateTask($unique_id, $data)
//    {
//        $result = DB::table($this->table_name)->where(['unique_id' => $unique_id])->update($data);
//        return $result !== false;
//    }
//
//    public function updateTasks($ids, $data)
//    {
//        $result = DB::table($this->table_name)->whereIn('unique_id', $ids)->update($data);
//        return $result !== false;
//    }
}