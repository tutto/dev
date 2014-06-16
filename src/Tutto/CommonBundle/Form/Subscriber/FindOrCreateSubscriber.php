<?php

namespace Tutto\CommonBundle\Form\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use ReflectionClass;

/**
 * Class FindOrCreateSubscriber
 * @package Tutto\CommonBundle\Form\Subscriber
 */
class FindOrCreateSubscriber implements EventSubscriberInterface  {
    protected $findElementName    = '_findItem';
    protected $newElementName     = '_newItem';
    protected $createCheckboxName = '_createNewItem';
    protected $propertyToChangeName;

    /**
     * @param $propertyToChangeName
     * @param string $findElementName
     * @param string $newElementName
     * @param string $createCheckboxName
     */
    public function __construct(
        $propertyToChangeName,
        $findElementName = '_findItem',
        $newElementName = '_newItem',
        $createCheckboxName = '_createNewItem'
    ) {
        $this->propertyToChangeName = $propertyToChangeName;
        $this->findElementName      = $findElementName;
        $this->newElementName       = $newElementName;
        $this->createCheckboxName   = $createCheckboxName;
    }

    /**
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    /**
     * @param FormEvent $event
     * @return void
     */
    public function postSubmit(FormEvent $event) {
        $form = $event->getForm();

        if ($form->has($this->createCheckboxName) && (boolean) $form->get($this->createCheckboxName)->getData()) {
            $this->setDataToObject($event->getData(), $form->get($this->newElementName)->getData());
        } else {
            $this->setDataToObject($event->getData(), $form->get($this->findElementName)->getData());
        }
    }

    /**
     * @param $object
     * @param $data
     * @throws SubscriberException
     */
    protected function setDataToObject($object, $data) {
        $Reflect = new ReflectionClass($object);

        $methodName = 'set' . ucfirst($this->propertyToChangeName);
        if (!$Reflect->hasMethod($methodName)) {
            throw new SubscriberException("Method: '{$methodName}' not found in class: '{$Reflect->getName()}'");
        }

        if (($method = $Reflect->getMethod($methodName)) && $method->isPublic()) {
            $object->{$method->getName()}($data);
        } else {
            throw new SubscriberException("Method: '{$methodName}' has not public accessor in object: '{$Reflect->getName()}'");
        }
    }
}