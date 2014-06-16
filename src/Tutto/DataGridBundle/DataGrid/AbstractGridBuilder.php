<?php

namespace Tutto\DataGridBundle\DataGrid;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\DataGridBundle\DataGrid\Tag\AbstractColumn;

/**
 * @author fluke.kuczwa@gmail.com
 */
abstract class AbstractGridBuilder extends AbstractContainerAware {
    
    /**
     * @var AbstractColumn[]
     */
    protected $columns = array();
    
    /**
     * @param AbstractColumn $column
     */
    public function addColumn(AbstractColumn $column) {
        $this->columns[] = $column;
    }
    
    /**
     * @return AbstractColumn[]
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * @param DataProviderInterface $dataProvider
     * @return mixed
     */
    abstract public function build(DataProviderInterface $dataProvider);
}
