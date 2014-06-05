<?php

namespace Tutto\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @author fluke.kuczwa@gmail.com
 * @PrivilegeCheck(roles={Role::GUEST})
 */
class HomeController extends AbstractController {
    /**
     * @Route("/", name="_home")
     * @PrivilegeCheck(omit=true)
     * @Template()
     */
    public function homeAction() {
        return array();
    }

    /**
     * @Route("/home/secured")
     * @PrivilegeCheck(roles={Role::ADMIN})
     * @Template()
     */
    public function securedAction() {
        return new Response('Secured action');
    }
}
