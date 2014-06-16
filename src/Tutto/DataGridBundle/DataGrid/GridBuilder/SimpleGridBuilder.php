<?php

namespace Tutto\DataGridBundle\DataGrid\GridBuilder;

use Tutto\DataGridBundle\DataGrid\AbstractGridBuilder;
use Tutto\DataGridBundle\DataGrid\Tag\AbstractColumn;
use Tutto\DataGridBundle\DataGrid\DataProviderInterface;
use Tutto\DataGridBundle\XHTML\Tag\Table\Body;
use Tutto\DataGridBundle\XHTML\Tag\Table\Table;
use Tutto\DataGridBundle\XHTML\Tag\Table\Head;
use Tutto\DataGridBundle\XHTML\Tag\Table\Td;
use Tutto\DataGridBundle\XHTML\Tag\Table\Tr;
use Tutto\DataGridBundle\XHTML\Tag\Table\Th;
use Tutto\DataGridBundle\XHTML\Tag\Text\P;

/**
 * @author fluke.kuczwa@gmail.com
 */
class SimpleGridBuilder extends AbstractGridBuilder {
    /**
     * @param DataProviderInterface $dataProvider
     * @return mixed|Table
     */
    public function build(DataProviderInterface $dataProvider) {
        $table = new Table();
        $thead = new Head();
        
        $tr = new Tr();
        $thead->addChild($tr);
        
        //Add columns to tr xhtml tag
        foreach($this->getColumns() as $column) {
            $tr->addChild(new Th($column->getContent()));
        }

        $tbody = new Body();
        //List results
        foreach($dataProvider->getResults() as $result) {
            $tr = new Tr();
            foreach ($this->getColumns() as $column) {
                var_dump($column);
                $td = new Td(new P($result->getId()));
                $tr->addChild($td);
            }
        }

        $table->addChild($thead);
        $thead->addChild($tbody);

        return $table;
    }
}
