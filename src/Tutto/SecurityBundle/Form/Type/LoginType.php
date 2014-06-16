<?php

namespace Tutto\SecurityBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Tutto\CommonBundle\Form\AbstractFormType;

/**
 * Class LoginType
 * @package Tutto\SecurityBundle\Form\Type
 */
class LoginType extends AbstractFormType {

    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $csrfProvider = $this->getContainer()->get('form.csrf_provider');

        $builder->add(
            '_username',
            'email',
            array(
                'data' => $this->getSession()->get(SecurityContextInterface::LAST_USERNAME)
            )
        );
        $builder->add('_password', 'password');
        $builder->add(
            '_remember_me',
            'checkbox',
            array(
                'required' => false
            )
        );
        $builder->add(
            '_csrf_token',
            'hidden',
            array(
                'data' => $csrfProvider->generateCsrfToken('authenticate')
            )
        );

//        $builder->addEventSubscriber(new InsertsFromRequest())
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return '';
    }
}