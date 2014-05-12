<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\AbstractTagCollector;

/**
 * Description of Head
 *
 * @author janek
 */
class Head extends AbstractTagCollector {
    public function getTagName() {
        return 'thead';
    }
}
