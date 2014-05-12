<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\AbstractTagCollector;

/**
 * Description of Table
 *
 * @author janek
 */
class Table extends AbstractTagCollector {
    public function getTagName() {
        return 'table';
    }
}
