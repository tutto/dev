<?php

namespace Tutto\FrontendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class Builder
 * @package Tutto\FrontendBundle\Menu
 */
class Builder extends AbstractContainerAware {
    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'menu');

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