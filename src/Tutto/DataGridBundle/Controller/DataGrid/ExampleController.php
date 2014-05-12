<?php

namespace Tutto\DataGridBundle\Controller\DataGrid;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author fluke.kuczwa@gmail.com
 */
class ExampleController extends Controller {
    /**
     * @Route(
     *      "/data-grid/example"
     * )
     * @Template()
     */
    public function exampleAction() {
        return array();
    }
}
