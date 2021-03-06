<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\space\jobs;

use Yii;
use yii\base\Object;
use yii\queue\RetryableJob;
use yuncms\user\models\Extend;
use yuncms\space\models\Visit;

/**
 * 记录访客
 * @package yuncms\user\jobs
 */
class VisitJob extends Object implements RetryableJob
{
    public $user_id;

    public $source_id;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        if ($this->user_id != $this->source_id) {
            //记录访客
            if (($visit = Visit::findOne(['user_id' => $this->user_id, 'source_id' => $this->source_id])) == null) {
                $visit = new Visit(['user_id' => $this->user_id, 'source_id' => $this->source_id]);
                $visit->save(false);
                //更新访客计数
                Extend::updateAllCounters(['views' => 1], ['user_id' => $this->source_id]);
            } else {
                $visit->updateAttributes(['updated_at' => time()]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
