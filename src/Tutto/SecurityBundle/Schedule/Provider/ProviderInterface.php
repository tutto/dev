<?php

namespace Tutto\SecurityBundle\Schedule\Provider;

use Tutto\SecurityBundle\Schedule\ScheduleInterface;

/**
 * Class ProviderInterface
 * @package Tutto\SecurityBundle\Schedule\Provider
 */
interface ProviderInterface {
    /**
     * @param ScheduleInterface $schedule
     * @return ProviderInterface
     */
    public function add(ScheduleInterface $schedule);

    /**
     * @return mixed
     */
    public function save();
} 