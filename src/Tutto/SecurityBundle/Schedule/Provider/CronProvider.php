<?php

namespace Tutto\SecurityBundle\Schedule\Provider;

use Tutto\SecurityBundle\Schedule\Provider\Cron\CronSchedule;

/**
 * Class CronProvider
 * @package Tutto\SecurityBundle\Schedule\Provider
 */
class CronProvider extends AbstractProvider {
    public static $cronTabFile = 'D:\xampp\php\cron\crontab';

    /**
     * @var array
     */
    protected $schedule = array();

    /**
     * @return bool
     * @throws ProviderException
     */
    public function save() {
        $handler = $this->loadFile(self::$cronTabFile);

        if($handler === null) {
            return false;
        }

        foreach($this->all() as $schedule) {
            $str =
                $schedule->getDatetime()->parse(). ' '.
                $schedule->getCommand()->build()."\n\n";

            fwrite($handler, $str);
        }

        fclose($handler);
        return true;
    }
}