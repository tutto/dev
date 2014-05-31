<?php

namespace Tutto\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Schedule\ScheduleCollector;
use Tutto\SecurityBundle\Entity\Role;


/**
 * @author fluke.kuczwa@gmail.com
 * @PrivilegeCheck(roles={Role::GUEST})
 */
class HomeController extends AbstractDataGridController {
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
