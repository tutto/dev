<?php

namespace Tutto\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author fluke.kuczwa@gmail.com
 */
class HomeController extends Controller {
    /**
     * @Route("/")
     */
    public function home() {
        return new Response("@TuttoFrontentBundle:home:home");
    }
}
