<?php

namespace Tutto\SecurityBundle\Schedule;

use Tutto\SecurityBundle\Schedule\Command\CommandInterface;
use Tutto\SecurityBundle\Schedule\DateTime\DateTimeInterface;

/**
 * Interface ScheduleInterface
 * @package Tutto\SecurityBundle\Schedule
 */
interface ScheduleInterface {
    /**
     * @return DateTimeInterface
     */
    public function getDatetime();

    /**
     * @param DateTimeInterface $datetime
     * @return mixed
     */
    public function setDatetime(DateTimeInterface $datetime);

    /**
     * @return CommandInterface
     */
    public function getCommand();
} 