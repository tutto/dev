<?php

namespace Tutto\FrontendBundle\Controller;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use \Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Repository\AccountRepository;

/**
 * @author fluke.kuczwa@gmail.com
 * @PrivilegeCheck(roles={Role::GUEST})
 */
class HomeController extends AbstractController {
    /**
     * @Route("/home", name="_home")
     * @PrivilegeCheck(omit=true)
     * @Template()
     */
    public function homeAction() {

        return array();
    }
}
