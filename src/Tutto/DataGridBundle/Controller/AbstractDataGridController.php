<?php

namespace Tutto\DataGridBundle\Controller;

use Tutto\DataGridBundle\DataGrid\GridSettingsInterface;
use Tutto\DataGridBundle\DataGrid\GridBuilder\SimpleGridBuilder;
use Tutto\DataGridBundle\DataGrid\DataProviderInterface;
use Tutto\SecurityBundle\Controller\AbstractSecurityController;

/**
 * @author fluke.kuczwa@gmail.com
 */
abstract class AbstractDataGridController extends AbstractSecurityController {
    /**
     * @param GridSettingsInterface $grid
     * @param DataProviderInterface $dataProvider
     * @return array
     */
    public function renderDataGrid(GridSettingsInterface $grid, DataProviderInterface $dataProvider) {
        $builder = new SimpleGridBuilder();
        $builder->setContainer($this->container);
        
        $grid->initSettings($builder);
        
        return array(
            'grid' => $builder->build($dataProvider)
        );
    }
}
