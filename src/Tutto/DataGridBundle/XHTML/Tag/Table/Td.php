<?php

namespace Tutto\DataGridBundle\XHTML\Tag\Table;

use Tutto\DataGridBundle\XHTML\Tag\Table\AbstractColumn;

/**
 * Description of Td
 *
 * @author janek
 */
class Td extends AbstractColumn {
    public function getTagName() {
        return 'td';
    }
}
