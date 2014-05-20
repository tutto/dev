<?php

namespace Tutto\SecurityBundle\Schedule\Command;

/**
 * Class Curl
 * @package Tutto\SecurityBundle\Schedule\Command
 */
class Curl extends CustomCommand {
    /**
     * @param array $arguments
     * @param array $attributes
     */
    public function __construct(array $arguments = array(), array $attributes = array()) {
        parent::__construct('curl', $arguments, $attributes);
    }
} 