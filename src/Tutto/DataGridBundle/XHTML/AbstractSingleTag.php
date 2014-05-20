<?php

namespace Tutto\DataGridBundle\XHTML;

use Tutto\DataGridBundle\XHTML\AbstractTag;

/**
 * Description of AbstractSingleTag
 *
 * @author janek
 */
abstract class AbstractSingleTag extends AbstractTag {
    protected function buildBeginName() {
        return '<'.trim(tim($this->getTagName()).$this->buildAttributes(), '<>').' />';
    }
    
    protected function buildEndName() {
        return '';
    }
}
