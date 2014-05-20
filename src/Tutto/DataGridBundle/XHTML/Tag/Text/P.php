<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Text;

use Tutto\DataGridBundle\XHTML\AbstractTagCollector;

/**
 * @author fluke.kuczwa@gmail.com
 */
class P extends AbstractTagCollector {
    private $content = '';
    
    public function __construct($content = '', $attributes = array(), array $tags = array()) {
        parent::__construct($attributes, $tags);
        $this->setContent($content);
    }
    
    public function setContent($content) {
        $this->content = $content;
    }
    
    public function getContent() {
        return $this->content;
    }
    
    public function getTagName() {
        return 'p';
    }
    
    public function createView() {
        return $this->buildBeginName().
               $this->buildContent().
               $this->buildChildrenTags().
               $this->buildEndName();
    }
    
    protected function buildContent() {
        return $this->getContent();
    }
}
