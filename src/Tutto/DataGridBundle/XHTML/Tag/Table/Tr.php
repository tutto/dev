<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\AbstractTagCollector;

/**
 * Description of Tr
 *
 * @author janek
 */
class Tr extends AbstractTagCollector {
    public function getTagName() {
        return 'tr';
    }
}
