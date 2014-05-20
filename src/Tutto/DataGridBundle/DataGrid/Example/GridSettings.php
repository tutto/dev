<?php

namespace Tutto\DataGridBundle\DataGrid\Example;

use Tutto\DataGridBundle\DataGrid\GridSettingsInterface;
use Tutto\DataGridBundle\DataGrid\AbstractGridBuilder;
use Tutto\DataGridBundle\DataGrid\Tag\Column\StaticColumn;

/**
 * @author fluke.kuczwa@gmail.com
 */
class GridSettings implements GridSettingsInterface {
    public function initSettings(AbstractGridBuilder $builder) {
        $builder->addColumn(new StaticColumn('asd'));
    }
}
