<?php
/**
 * User: Chester-He
 */

namespace Chester\BackgroundMission;


interface MissionInterface
{
    public function existTask($method);

    public function addTask($task);

    public function getTaskById($task_id);

    public function changeTaskStateByIds($task_ids, $state, $content = '');

    public function getLastInitTasks($limit = 5);

    public function getLastTasksByType($type = 'system', $limit = 10);

    public function hasInitTask();
}