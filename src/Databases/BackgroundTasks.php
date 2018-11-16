<?php

namespace Chester\BackgroundMission\DataBases;

use Illuminate\Database\Eloquent\Model;

class BackgroundTasks extends Model
{
    /**
     * 初始化
     */
    const STATE_INIT = 'init';

    /**
     * 执行中
     */
    const STATE_EXECUTING = 'executing';

    /**
     * 执行完成
     */
    const STATE_SUCCESS = 'success';

    /**
     * 执行失败
     */
    const STATE_FAIL = 'fail';

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->setTable('admin_background_tasks');
        parent::__construct($attributes);
    }
}
