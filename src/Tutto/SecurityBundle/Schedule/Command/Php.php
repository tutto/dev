<?php

namespace Tutto\SecurityBundle\Schedule\Command;

/**
 * Class Php
 * @package Tutto\SecurityBundle\Schedule\Command
 */
class Php extends CustomCommand  {
    /**
     * @param array $arguments
     * @param array $attributes
     */
    public function __construct(array $arguments = array(), $attributes = array()) {
        parent::__construct('php', $arguments, $attributes);
    }

    /**
     * @return string
     */
    protected function buildArguments() {
        return !empty($this->getArguments()) ? implode(' -', array_merge(array(''), $this->getArguments())) : '';
    }
}