<?php

namespace Tutto\DataGridBundle\XHTML;

use Tutto\DataGridBundle\XHTML\TagInterface;

use \Countable;
use \IteratorAggregate;

/**
 * Description of ElementCollectorInterface
 *
 * @author janek
 */
interface TagCollectorInterface extends TagInterface, Countable, IteratorAggregate {
    public function addChild(TagInterface $tag);
    
    public function addChildren(array $tags);
    
    public function setChildren(array $tags);
    
    public function getChildren();
    
    public function getChild($index);
    
    public function hasChild($index);
    
    public function removeChild($index);
    
    public function clear();
}
