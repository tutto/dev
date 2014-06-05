<?php

namespace Tutto\FrontendBundle\Controller;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Entity\Role;

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
}
