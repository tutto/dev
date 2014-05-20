<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\Tag\Table\AbstractColumn;

/**
 * @author fluke.kuczwa@gmail.com
 */
class Th extends AbstractColumn {
    public function getTagName() {
        return 'th';
    }
}
