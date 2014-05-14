<?php

namespace Tutto\FrontendBundle\Controller;

use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Tutto\DataGridBundle\DataGrid\Example\GridSettings;
use Tutto\SecurityBundle\Configuration\Privilege;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\DataGridBundle\DataGrid\DataProvider\DoctrineProvider;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;



/**
 * @author fluke.kuczwa@gmail.com
 * @Privilege()
 */
class HomeController extends AbstractDataGridController {
    /**
     * @Route("/"))
     * @Privilege(role=Role::ROLE_GUEST)
     */
    public function home() {
        /* @var $em EntityRepository */
        $em = $this->getDoctrine()->getRepository(Role::class);
        $query = $em->createQueryBuilder('c');
                
        $result = $this->renderDataGrid(
                new GridSettings(),
                new DoctrineProvider($query));
        
        var_dump($result['grid']->createView());
        
        return new Response("@TuttoFrontentBundle:home:home");
    }
}
