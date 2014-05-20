<?php

namespace Tutto\SecurityBundle\Schedule\Command;

/**
 * Class CustomCommand
 * @package Tutto\SecurityBundle\Schedule\Command
 */
class CustomCommand implements CommandInterface {
    /**
     * @var string
     */
    protected $command;

    /**
     * @var array
     */
    protected $arguments = array();

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @param $command
     * @param array $arguments
     * @param array $attributes
     */
    public function __construct($command, array $arguments = array(), array $attributes = array()) {
        $this->setCommand($command);
        $this->setArguments($arguments);
        $this->setAttributes($attributes);
    }

    /**
     * @param string $command
     * @return CustomCommand
     */
    public function setCommand($command) {
        $this->command = (string) $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand() {
        return $this->command;
    }

    /**
     * @param array $arguments
     * @return CustomCommand
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @param $argument
     * @return CustomCommand
     */
    public function addArgument($argument) {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return CustomCommand
     */
    public function setAttributes(array $attributes) {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->build();
    }

    /**
     * @return string
     */
    public function build() {
        return $this->buildCommand().
               $this->buildArguments().
               $this->buildAttributes();
    }

    /**
     * @return string
     */
    protected function buildCommand() {
        return $this->getCommand();
    }

    /**
     * @return string
     */
    protected function buildArguments() {
        return !empty($this->getArguments())
               ? implode(' -', array_merge(array(''), $this->getArguments()))
               : '';
    }

    /**
     * @return string
     */
    protected function buildAttributes() {
        return !empty($this->getAttributes())
               ? implode(' ', array_merge(array(''), $this->getAttributes()))
               : '';
    }
}