<?php
/**
 * User: Chester-He
 */

namespace Chester\BackgroundMission;


class Logic
{
    public function HelloWorld()
    {
        return $this->response(1, 'hello world.');
    }

    protected function response($state = 1, $content = '')
    {
        return ['state' => $state, 'content' => $content];
    }
}