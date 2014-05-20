<?php

namespace Tutto\SecurityBundle\Schedule;

use Tutto\SecurityBundle\Schedule\DateTime\DateTime;
use Tutto\SecurityBundle\Schedule\Command\CommandInterface;
use Tutto\SecurityBundle\Schedule\DateTime\DateTimeInterface;

/**
 * Class AbstractSchedule
 * @package Tutto\SecurityBundle\Schedule
 */
abstract class AbstractSchedule implements ScheduleInterface {
    /**
     * @var DateTimeInterface
     */
    protected $datetime;

    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * @param CommandInterface $command
     * @param DateTimeInterface $datetime
     */
    public function __construct(CommandInterface $command, DateTimeInterface $datetime = null) {
        $this->setCommand($command);
        if(!$datetime instanceof DateTime) {
            $datetime = new DateTime();
        }
        $this->setDatetime($datetime);
    }

    /**
     * @param DateTimeInterface $datetime
     * @return AbstractSchedule
     */
    public function setDatetime(DateTimeInterface $datetime) {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDatetime() {
        return $this->datetime;
    }

    /**
     * @param CommandInterface $command
     * @return AbstractSchedule
     */
    public function setCommand(CommandInterface $command) {
        $this->command = $command;

        return $this;
    }

    /**
     * @return CommandInterface
     */
    public function getCommand() {
        return $this->command;
    }
}