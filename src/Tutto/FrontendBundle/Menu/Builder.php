<?php

namespace Tutto\FrontendBundle\Menu;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class Builder
 * @package Tutto\FrontendBundle\Menu
 */
class Builder extends ContainerAware {
    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array(
            'route' => '_home',
            'extra' => array(
                'route' => '_home'
            )
        ));
        $menu->addChild('Login', array(
            'route' => '_login'
        ));

        return $menu;
    }
} 