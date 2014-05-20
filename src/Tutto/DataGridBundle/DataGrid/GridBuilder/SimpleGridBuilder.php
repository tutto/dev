<?php

namespace Tutto\DataGridBundle\DataGrid\GridBuilder;

use Tutto\DataGridBundle\DataGrid\AbstractGridBuilder;
use Tutto\DataGridBundle\DataGrid\Tag\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\DataProviderInterface;
use Tutto\DataGridBundle\XHTML\Tag\Table\Table;
use Tutto\DataGridBundle\XHTML\Tag\Table\Head;
use Tutto\DataGridBundle\XHTML\Tag\Table\Body;
use Tutto\DataGridBundle\XHTML\Tag\Table\Tr;
use Tutto\DataGridBundle\XHTML\Tag\Table\Th;

/**
 * @author fluke.kuczwa@gmail.com
 */
class SimpleGridBuilder extends AbstractGridBuilder {
    /**
     * @return Table
     */
    public function build(DataProviderInterface $dataProvider) {
        $table = new Table();
        $thead = new Head();
        
        $tr = new Tr();
        
        //Add columns to tr xhtml tag
        /* @var $column AbstractColumn */
        foreach($this->getColumns() as $column) {
            $tr->addChild(new Th($column->getContent()));
        }
        
        //List results
        foreach($dataProvider->getResults() as $result) {
        }
        
        $thead->addChild($tr);
        $table->addChild($thead);
        
        return $table;
    }
}
