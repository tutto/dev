<?php

namespace Tutto\DataGridBundle\DataGrid\Tag;

use Tutto\DataGridBundle\XHTML\TagInterface;
use Tutto\DataGridBundle\XHTML\Tag\Text\P;

use Symfony\Component\Intl\Exception\NotImplementedException;

/**
 * @author fluke.kuczwa@gmail.com
 */
abstract class AbstractColumn {
    private $content;
    
    public function __construct($tag = null) {
        if(is_string($tag)) {
            $tag = new P($tag);
        }
        
        if($tag instanceof TagInterface) {
            $this->setContent($tag);
        } else {
            throw new NotImplementedException("Add exception AbstractColumnException");
        }
    }
    
    public function setContent(TagInterface $tag) {
        $this->content = $tag;
        return $this;
    }
    
    public function getContent() {
        return $this->content;
    }
}
