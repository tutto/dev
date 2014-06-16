<?php

namespace Tutto\CommonBundle\Form\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use ReflectionClass;

/**
 * Class AddSaveAndEditButtonsSubscriber
 * @package Tutto\CommonBundle\Form\Subscriber
 */
class AddSaveAndEditButtonsSubscriber implements EventSubscriberInterface {
    protected $objectDetectNewEntity = 'id';

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event) {
        $object = $event->getData();
        if(is_object($object)) {
            $Reflect = new ReflectionClass($object);

            $methodName = 'get'.ucfirst($this->objectDetectNewEntity);

            if($Reflect->hasMethod($methodName)
                && (($method = $Reflect->getMethod($methodName)) && $method->isPublic())
            ) {
                if ($object->{$method->getName()}() !== null) {
                    $event->getForm()->add(
                        'saveAndEdit',
                        'submit'
                    );
                } else {
                    $event->getForm()->add(
                        'saveAndEdit',
                        'submit',
                        [
                            'label' => 'form.save_and_edit'
                        ]
                    );

                    $event->getForm()->add(
                        'saveAndCreate',
                        'submit',
                        [
                            'label' => 'form.save_and_create'
                        ]
                    );
                }
            }
        }
    }
}