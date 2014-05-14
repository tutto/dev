<?php

namespace Tutto\SecurityBundle\Entity\Resource;

use Tutto\SecurityBundle\Entity\Resource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 * 
 * @ORM\Entity()
 */
class Controller extends Resource {
    public function getAction($name) {
        foreach($this->getChildren() as $action) {
            if($action instanceof Action) {
                if(!strcmp($name, $action->getName())) {
                    return $action;
                }
            }
        }
    }
}
