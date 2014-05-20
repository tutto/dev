<?php

namespace Tutto\DataGridBundle\DataGrid;

use Tutto\DataGridBundle\DataGrid\Tag\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\DataProviderInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author fluke.kuczwa@gmail.com
 */
abstract class AbstractGridBuilder implements ContainerAwareInterface {
    /**
     * @var ContainerAwareInterface
     */
    protected $container;
    
    /**
     * @var AbstractColumn[]
     */
    protected $columns = array();
    
    
    protected $dataProvider;
    
    /**
     * @param AbstractColumn $column
     * @return AbstractGridBuilder
     */
    public function addColumn(AbstractColumn $column) {
        $this->columns[] = $column;
        return $this;
    }
    
    /**
     * @return AbstractColumn[]
     */
    public function getColumns() {
        return $this->columns;
    }
    
    /**
     * @return TagInterface;
     */
    abstract public function build(DataProviderInterface $dataProvider);
    
    
    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * @return ContainerAwareInterface
     */
    public function getContainer() {
        return $this->container;
    }
}
