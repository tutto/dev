<?php

/**
 * Controller
 * 
 * (c) Krzysztof Januś <fluke.kuczwa@gmail.com>
 */
namespace Tutto\SecurityBundle\Entity\Resource;

use Doctrine\ORM\Mapping as ORM;
use Tutto\SecurityBundle\Entity\Resource;
/**
 * Controller
 * 
 * Description:
 * 
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 * @copyright (c) 2013-10-23, Januś Krzysztof
 * @category \
 * @package \
 * @see
 * @version 1.0
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
