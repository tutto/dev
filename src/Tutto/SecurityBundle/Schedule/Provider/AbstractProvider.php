<?php

namespace Tutto\SecurityBundle\Schedule\Provider;

use Tutto\SecurityBundle\Schedule\ScheduleInterface;

/**
 * Class AbstractProvider
 * @package Tutto\SecurityBundle\Schedule\Provider
 */
abstract class AbstractProvider implements ProviderInterface {
    /**
     * @var array
     */
    protected $schedule = array();

    /**
     * @param ScheduleInterface $schedule
     * @return ProviderInterface
     */
    public function add(ScheduleInterface $schedule) {
        $this->schedule[] = $schedule;

        return $this;
    }

    /**
     * @return ScheduleInterface[]
     */
    public function all() {
        return $this->schedule;
    }

    /**
     * @param $file
     * @return resource
     * @throws ProviderException
     */
    protected function loadFile($file) {
        if(!realpath($file)) {
            throw new ProviderException("File: '{$file}' not found. It is needed to load crontab.");
        }

        return fopen(realpath($file), 'a+');
    }
}