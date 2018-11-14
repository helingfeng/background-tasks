<?php
/**
 * User: Chester-He
 */

namespace Chester\BackgroundMission;


use Chester\BackgroundMission\DataBases\BackgroundTasks;
use Chester\BackgroundMission\Exceptions\TaskMethodNotFoundException;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Support\Str;

class Queue
{
    protected $manager;
    protected $executor;

    protected $frequency = 1;
    /**
     * @var string out put file for command.
     */
    protected $sendOutputTo;

    public function __construct(MissionInterface $manager, Logic $executor)
    {
        $this->manager = $manager;
        $this->executor = $executor;
    }

    public function records($type = 'system')
    {
        return $this->manager->getLastTasksByType($type);
    }

    public function push($params)
    {
        $this->manager->addTask($params);
        return $this;
    }

    public function runTask()
    {
        foreach ($this->getKernelEvents() as $event) {
            /** @var \Illuminate\Console\Scheduling\Event $event */
            if ($this->isBackgroundEvent($event)) {

                $event->sendOutputTo($this->getOutputTo());
                $event->run(app());

                break;
            }
        }
    }

    protected function getOutputTo()
    {
        if (!$this->sendOutputTo) {
            $this->sendOutputTo = storage_path('app/background-task.output');
        }
        return $this->sendOutputTo;
    }

    protected function isBackgroundEvent($event)
    {
        if ($event instanceof CallbackEvent) {
            return false;
        }
        $command = "mission:execute";
        return Str::contains($event->command, $command);
    }

    protected function getKernelEvents()
    {
        app()->make('Illuminate\Contracts\Console\Kernel');
        return app()->make('Illuminate\Console\Scheduling\Schedule')->events();
    }

    public function frequencyRun()
    {
        if (!$this->manager->hasInitTask()) {
            return;
        }
        $taskList = $this->manager->getLastInitTasks($this->frequency);
        $task_ids = collect($taskList)->pluck('unique_id');
        $this->manager->changeTaskStateByIds($task_ids, BackgroundTasks::STATE_EXECUTING);

        foreach ($taskList as $task) {
            $method = $task['method'];
            $params = $this->jsonDecode($task['params']);
            try {
                if (!method_exists($this->executor, $method)) {
                    throw new TaskMethodNotFoundException();
                }
            } catch (\Exception $exception) {
                $this->manager->changeTaskStateByIds($task['unique_id'], BackgroundTasks::STATE_FAIL, $exception->getMessage());
                continue;
            }
            $result = $this->executor->$method($params);
            $state = $result['state'] ? BackgroundTasks::STATE_SUCCESS : BackgroundTasks::STATE_FAIL;
            $this->manager->changeTaskStateByIds($task['unique_id'], $state, $result['content']);
        }
    }

    public function jsonDecode($string)
    {
        return json_decode($string, true);
    }
}