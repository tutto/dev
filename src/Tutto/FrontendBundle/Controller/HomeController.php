<?php

namespace Tutto\FrontendBundle\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use Tutto\SecurityBundle\Configuration\Privilege;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Schedule\Command\Curl;
use Tutto\SecurityBundle\Schedule\Command\CustomCommand;
use Tutto\SecurityBundle\Schedule\Command\Php;
use Tutto\SecurityBundle\Schedule\Provider\CronProvider;
use Tutto\SecurityBundle\Schedule\ScheduleCollector;
use Tutto\SecurityBundle\Schedule\SimpleSchedule;


/**
 * @author fluke.kuczwa@gmail.com
 * @Privilege(omit="true")
 */
class HomeController extends AbstractDataGridController {
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function homeAction() {
        $cron = new CronProvider();
        $cron->add(
            new SimpleSchedule(
                new CustomCommand('curl.exe', array('s'), array(
                    'http://crm.janek-projects.pl/account/registration'
                ))
            )
        );

        $cron->save();

        return array();
    }
}
