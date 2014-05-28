<?php

namespace Tutto\FrontendBundle\Form\Subscriber;


use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

class InsertsFromRequest implements EventSubscriberInterface {
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var mixed
     */
    private $fieldValue;

    /**
     * @param string $fieldName
     * @param mixed  $fieldValue
     */
    public function __construct($fieldName, $fieldValue = null) {
        $this->fieldName  = $fieldName;
        $this->fieldValue = $fieldValue;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event) {
        if($event->getForm()->has($this->fieldName)) {
            $event->getForm()->get($this->fieldName)->setData($this->fieldValue);
        }
    }
}