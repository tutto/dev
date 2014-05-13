<?php

namespace Tutto\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Tutto\SecurityBundle\Configuration\Security;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Configuration\Privilege;


/**
 * @author fluke.kuczwa@gmail.com
 * @Privilege(role=Role::ROLE_ADMINISTRATOR)
 */
class HomeController extends Controller {
    /**
     * @Route("/")
     * @Privilege(role=Role::ROLE_GUEST)
     */
    public function home() {
        return new Response("@TuttoFrontentBundle:home:home");
    }
}
