<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\AbstractTagCollector;

/**
 * Description of Body
 *
 * @author janek
 */
class Body extends AbstractTagCollector {
    public function getTagName() {
        return 'tbody';
    }
}
