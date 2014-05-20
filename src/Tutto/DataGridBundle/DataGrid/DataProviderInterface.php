<?php

namespace Tutto\DataGridBundle\DataGrid;

/**
 * @author fluke.kuczwa@gmail.com
 */
interface DataProviderInterface {
    public function getResults($limit = 50, $count = 0);
}
