<?php

namespace Tutto\SecurityBundle\Schedule\Provider\Cron;

use Tutto\SecurityBundle\Schedule\DateTime\DateTimeInterface;

/**
 * Class DateTime
 * @package Tutto\SecurityBundle\Schedule\Provider\Cron
 */
class CronDateTime implements DateTimeInterface {
    /**
     * @var string
     */
    protected $minute = '*';

    /**
     * @var string
     */
    protected $hour = '*';

    /**
     * @var string
     */
    protected $day = '*';

    /**
     * @var string
     */
    protected $month = '*';

    /**
     * @var string
     */
    protected $week = '*';

    /**
     * @param string $minute
     * @param string $hour
     * @param string $day
     * @param string $month
     * @param string $week
     */
    public function __construct($minute = '*', $hour = '*', $day = '*', $month = '*', $week = '*') {
        $this->setMinute($minute);
        $this->setHour($hour);
        $this->setDay($day);
        $this->setMinute($month);
        $this->setWeek($week);
    }

    /**
     * @return string
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @param string $day
     */
    public function setDay($day) {
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     * @param string $hour
     */
    public function setHour($hour) {
        $this->hour = $hour;
    }

    /**
     * @return string
     */
    public function getMinute() {
        return $this->minute;
    }

    /**
     * @param string $minute
     */
    public function setMinute($minute) {
        $this->minute = $minute;
    }

    /**
     * @return string
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * @param string $month
     */
    public function setMonth($month) {
        $this->month = $month;
    }

    /**
     * @return string
     */
    public function getWeek() {
        return $this->week;
    }

    /**
     * @param string $week
     */
    public function setWeek($week) {
        $this->week = $week;
    }

    /**
     * @return string
     */
    public function parse() {
        return $this->getMinute().' '.
               $this->getHour().' '.
               $this->getDay().' '.
               $this->getMonth().' '.
               $this->getWeek().' ';
    }
}