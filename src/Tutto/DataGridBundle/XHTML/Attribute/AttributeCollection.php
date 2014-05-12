<?php

namespace Tutto\DataGridBundle\XHTML\Attribute;

use Tutto\DataGridBundle\XHTML\Attribute\AttributeInterface;
use Tutto\DataGridBundle\XHTML\Attribute\AttributeException;

use \ArrayIterator;

/**
 * Description of AttributeCollection
 *
 * @author janek
 */
class AttributeCollection implements AttributeInterface {
    /**
     * @var array
     */
    private $attributes = array();
    
    /**
     * @var int
     */
    private $index = 0;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        $this->setAttributes($attributes);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getAttribute($name) {
        if($this->hasAttribute($name)) {
            return $this->attributes[$name];
        }
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator($this->getAttributes());
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return AttributeCollection
     */
    public function setAttribute($name, $value) {
        $this->clearAttribute($name);
        $this->addAttribute($name, $value);
        return $this;
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * @return AttributeCollection
     * @throws AttributeException
     */
    public function addAttribute($name, $value) {
        if(!is_string($name)) {
            throw new AttributeException('Attribute name must be string type.');
        }
        
        $this->attributes[$name][] = $value;
        return $this;
    }
    
    public function addAttributes($name, $attributes) {
        foreach($attributes as $attribute) {
            $this->addAttribute($name, $attribute);
        }
        return $this;
    }

    /**
     * @param array $attributes
     * @return AttributeCollection
     */
    public function setAttributes(array $attributes) {
        foreach($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
        
        return $this;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name) {
        return !empty($this->attributes[$name]);
    }
    
    /**
     * @param string $name
     * @return AttributeCollection
     */
    public function clearAttribute($name) {
        $this->attributes[$name] = array();
        return $this;
    }
    
    /**
     * @return AttributeCollection
     */
    public function clearAttributes() {
        $this->attributes = array();
        return $this;
    }
    
    /**
     * @return int
     */
    public function count() {
        return count($this->attributes);
    }
}
