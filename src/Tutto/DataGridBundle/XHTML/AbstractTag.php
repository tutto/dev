<?php

namespace Tutto\DataGridBundle\XHTML;

use Tutto\DataGridBundle\XHTML\TagInterface;
use Tutto\DataGridBundle\XHTML\Attribute\AttributeCollection;


/**
 * Description of AbstractTag
 *
 * @author janek
 */
abstract class AbstractTag implements TagInterface {
    /**
     * @var AttributeCollection
     */
    private $attributes;
    
    public function __construct(array $attributes = array()) {
        $this->attributes = new AttributeCollection($attributes);
    }
    
    abstract public function getTagName();
    
    public function getAttrs() {
        if(!$this->attributes instanceof AttributeCollection) {
            $this->attributes = new AttributeCollection();
        }
        return $this->attributes;
    }
    
    public function createView() {
        return $this->buildBeginName().$this->buildEndName();
    }
    
    public function __toString() {
        return $this->createView();
    }
    
    protected function buildBeginName() {
        return '<'.trim(trim($this->getTagName()), '<>').$this->buildAttributes().'>';
    }
    
    protected function buildEndName() {
        return '</'.trim(trim($this->getTagName()), '<>').'>';
    }
    
    protected function buildAttributes() {
        $xhtml = '';
        foreach($this->getAttrs() as $name => $value) {
            if(!empty($value)) {
                $xhtml.= $name.'="'.implode(' ', $value).'" ';
            }
        }
        return !empty($xhtml) ? ' '.trim($xhtml) : '';
    }
}
