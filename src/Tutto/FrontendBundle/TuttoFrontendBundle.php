<?php

namespace Tutto\FrontendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author fluke.kuczwa@gmail.com
 */
class TuttoFrontendBundle extends Bundle {
    public function getParent() {
        return 'FOSUserBundle';
    }
}
