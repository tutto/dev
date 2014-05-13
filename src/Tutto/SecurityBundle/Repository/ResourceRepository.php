<?php

/**
 * ResourceRepository
 * 
 * (c) Krzysztof Januś <fluke.kuczwa@gmail.com>
 */

namespace Tutto\SecurityBundle\Repository;

use Tutto\SecurityBundle\Entity\Resource\Controller;
use Tutto\SecurityBundle\Entity\Resource\Action;
use Tutto\SecurityBundle\Entity\Resource;
use Tutto\SecurityBundle\Entity\Role;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * ResourceRepository
 * 
 * Description:
 * 
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 * @copyright (c) 2013-10-23, Januś Krzysztof
 * @category \
 * @package \
 * @see
 * @version 1.0
 */
class ResourceRepository extends EntityRepository {
    const TYPE_CONTROLLER = 'controller';
    const TYPE_ACTION     = 'action';
    
    /**
     * @param string $name
     * @return Controller|null
     */
    public function getController($name) {
        return $this->getEntityManager()
                    ->getRepository(Controller::class)
                    ->findOneBy(array(
                        'name' => $name
                    ));
    }
    
    /**
     * @param string $name
     * @return Action|null
     */
    public function getAction(Controller $controller, $name) {
        return array(
            'type'   => self::TYPE_ACTION,
            'parent' => $controller->getId(),
            'name'   => $name
        );
    }
}