<?php

namespace Tutto\SecurityBundle\Schedule\Command;

/**
 * Interface CommandInterface
 * @package Tutto\SecurityBundle\Schedule\Command
 */
interface CommandInterface {
    /**
     * @return string
     */
    public function getCommand();

    /**
     * @return array
     */
    public function getArguments();

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @return string
     */
    public function build();

    /**
     * @return string
     */
    public function __toString();
} 