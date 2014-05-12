<?php

namespace Tutto\DataGridBundle\XHTML\Attribute;

use \Countable;
use \IteratorAggregate;
/**
 * Description of AttributeInterface
 *
 * @author janek
 */
interface AttributeInterface extends Countable, IteratorAggregate {
    public function getAttributes();
    
    public function getAttribute($name);
    
    public function setAttribute($name, $value);
    
    public function setAttributes(array $attributes);
    
    public function addAttribute($name, $value);
    
    public function hasAttribute($name);
    
    public function clearAttribute($name);
    
    public function clearAttributes();
}
