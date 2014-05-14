<?php

namespace Tutto\SecurityBundle\Repository;

use Tutto\SecurityBundle\Entity\Resource\Controller;
use Tutto\SecurityBundle\Entity\Resource\Action;
use Tutto\SecurityBundle\Entity\Resource;

use Doctrine\ORM\EntityRepository;

/**
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 */
class ResourceRepository extends EntityRepository {
    const TYPE_CONTROLLER = 'controller';
    const TYPE_ACTION     = 'action';
    
    /**
     * @param string $name
     * @return Controller
     */
    public function getController($name) {
        return $this->getEntityManager()
                    ->getRepository(Controller::class)
                    ->findOneBy(array(
                        'name' => $name
                    ));
    }

    /**
     * @param Controller $controller
     * @param string $name
     * @return array
     */
    public function getAction(Controller $controller, $name) {
        return $this->getEntityManager()
                    ->getRepository(Action::class)
                    ->findOneBy(array(
                        'name'   => $name,
                        'parent' => $controller->getId()
                    ));
    }
}