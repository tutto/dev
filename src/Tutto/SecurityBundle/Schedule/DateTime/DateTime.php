<?php

namespace Tutto\SecurityBundle\Schedule\DateTime;

/**
 * Class DateTime
 * @package Tutto\SecurityBundle\Schedule\DateTime
 */
class DateTime implements DateTimeInterface {
    /**
     * @return string
     */
    public function parse() {
        return '* * * * *';
    }
}