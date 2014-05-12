<?php

namespace Tutto\DataGridBundle\XHTML;

/**
 * Description of TagInterface
 *
 * @author janek
 */
interface TagInterface {
    public function createView();
    
    public function __toString();
}
