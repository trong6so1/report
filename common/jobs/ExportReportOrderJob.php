<?php

namespace common\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class ExportReportOrderJob extends BaseObject implements JobInterface
{

    /**
     * @inheritDoc
     */
    public function execute($queue)
    {
        echo 'start';
        var_dump(1);
    }
}