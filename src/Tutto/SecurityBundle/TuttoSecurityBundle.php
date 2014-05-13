<?php

namespace Tutto\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author fluke.kuczwa@gmail.com
 */
class TuttoSecurityBundle extends Bundle { 
    public static $sessionNamespace = 'account_authorized';
}
