<?php

namespace Tutto\SecurityBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Tutto\FrontendBundle\Form\Subscriber\InsertsFromRequest;

/**
 * Class LoginType
 * @package Tutto\SecurityBundle\Form\Type
 */
class LoginType extends AbstractType implements ContainerAwareInterface{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var CsrfTokenManagerAdapter
     */
    protected $csrfProvider;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
        $this->csrfProvider = $container->get('form.csrf_provider');
        $this->session      = $container->get('session');
        $this->request      = $container->get('request');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            '_username',
            'email',
            array(
                'data' => $this->session->get(SecurityContextInterface::LAST_USERNAME)
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
                'data' => $this->csrfProvider->generateCsrfToken('authenticate')
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

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     * @return LoginType
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;

        return $this;
    }
}