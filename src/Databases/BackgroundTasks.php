<?php

namespace Chester\BackgroundMission\DataBases;

use Illuminate\Database\Eloquent\Model;

class BackgroundTasks extends Model
{
    const STATE_INIT = 'init';
    const STATE_EXECUTING = 'executing';
    const STATE_SUCCESS = 'success';
    const STATE_FAIL = 'fail';

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->setTable('admin_background_tasks');
        parent::__construct($attributes);
    }
}
