<?php

namespace Tutto\DataGridBundle\DataGrid;

use Tutto\DataGridBundle\DataGrid\AbstractGridBuilder;

/**
 * @author fluke.kuczwa@gmail.com
 */
interface GridSettingsInterface {
    /**
     * @return void
     */
    public function initSettings(AbstractGridBuilder $builder);
}
