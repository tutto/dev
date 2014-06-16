<?php

namespace Tutto\DataGridBundle\Controller;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\DataGridBundle\DataGrid\GridSettingsInterface;
use Tutto\DataGridBundle\DataGrid\GridBuilder\SimpleGridBuilder;
use Tutto\DataGridBundle\DataGrid\DataProviderInterface;

/**
 * @author fluke.kuczwa@gmail.com
 */
abstract class AbstractDataGridController extends AbstractController {
    /**
     * @param GridSettingsInterface $grid
     * @param DataProviderInterface $dataProvider
     * @return array
     */
    public function renderDataGrid(GridSettingsInterface $grid, DataProviderInterface $dataProvider) {
        $builder = new SimpleGridBuilder();
        $builder->setContainer($this->getContainer());
        
        $grid->initSettings($builder);
        
        return array(
            'grid' => $builder->build($dataProvider)
        );
    }
}
