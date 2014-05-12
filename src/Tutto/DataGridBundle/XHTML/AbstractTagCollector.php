<?php

namespace Tutto\DataGridBundle\XHTML;

use Tutto\DataGridBundle\XHTML\TagCollectorInterface;
use Tutto\DataGridBundle\XHTML\AbstractTag;
use Tutto\DataGridBundle\XHTML\TagException;

/**
 * Description of AbstractTagCollector
 *
 * @author janek
 */
abstract class AbstractTagCollector extends AbstractTag implements TagCollectorInterface {
    private $children = array();
    
    public function __construct($attributes = array(), array $tags = array()) {
        if($attributes instanceof AbstractTag) {
            $tag = $attributes;
            $this->addChild($tag);
        } elseif(is_array($attributes)) {
            parent::__construct($attributes);
            $this->setChildren($tags);
        }
    }

    public function getChild($index) {
        if($this->hasChild($index)) {
            return $this->children[$index];
        }
        
        throw new TagException("Child tag on index: '{$index}' not found.");
    }
    
    public function hasChild($index) {
        return isset($this->children[$index]);
    }
    
    public function addChild(TagInterface $tag) {
        $this->children[] = $tag;
        return $this;
    }

    public function addChildren(array $tags) {
        foreach($tags as $tag) {
            $this->addChild($tag);
        }
        return $this;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChildren(array $tags) {
        $this->clear();
        foreach($tags as $tag) {
            $this->addChild($tag);
        }
        
        return $this;
    }

    public function getIterator() {
        return $this->getChildren();
    }

    public function count() {
        return $this->getIterator()->count();
    }
    
    public function clear() {
        $this->children = array();
        return $this;
    }
    
    public function removeChild($index) {
        if($this->hasChild($index)) {
            unset($this->children[$index]);
            return $this;
        }
        
        throw new TagException("Child on index: '{$index}' not found.");
    }

    public function createView() {
        return $this->buildBeginName().
               $this->buildChildrenTags().
               $this->buildEndName();
    }
    
    protected function buildChildrenTags() {
        $xhtml = '';
        foreach($this->getChildren() as $child) {
            $xhtml.= $child->createView();
        }
        return $xhtml;
    }
}
