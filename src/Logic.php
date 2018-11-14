<?php
/**
 * User: Chester-He
 */

namespace Chester\BackgroundMission;


class Logic
{
    public function helloWorld()
    {
        return $this->response(1, 'hello world.');
    }

    public function helloWorldAfter15Seconds()
    {
        return $this->response(1, 'after 15 seconds , hello world.');
    }

    protected function response($state = 1, $content = '')
    {
        return ['state' => $state, 'content' => $content];
    }
}