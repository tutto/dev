<?php
/**
 * Created by PhpStorm.
 * User: janek
 * Date: 2014-05-19
 * Time: 13:15
 */

namespace Tutto\SecurityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'email',
            'email',
            array(
                'label' => 'email'
            )
        );

        $builder->add(
            'plainPassword',
            'repeated',
            array(
                'invalid_message' => 'password.not_valid',
                'type' => 'password',
                'first_options' => array(
                    'label' => 'password.first'
                ),
                'second_options' => array(
                    'label' => 'password.second'
                )
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'registration';
    }
}