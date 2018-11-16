<?php
/**
 * User: Chester-He
 */

namespace Chester\BackgroundMission;


class Logic
{
    public function helloWorld()
    {
        // 测试后台导出文件
        $filename = storage_path('app') . '/' . date('YmdHis') . ".csv";

        $handle = fopen($filename, 'w');
        fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        $cur_page = 0;
        fputcsv($handle, ['num', 'datetime']);
        do {
            $cur_page++;
            fputcsv($handle, [[$cur_page, date('Y-m-d H:i:s')]]);

            // 模拟10万条记录
            if ($cur_page >= 100000) {
                break;
            }
        } while (true);

        return $this->response(1, "output target file dir: {$filename}");
    }

    protected function response($state = 1, $content = '')
    {
        return ['state' => $state, 'content' => $content];
    }
}