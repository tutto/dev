<?php

namespace Tutto\DataGridBundle\DataGrid\DataProvider;

use Tutto\DataGridBundle\DataGrid\DataProviderInterface;
use Doctrine\ORM\QueryBuilder;

use Countable;

/**
 * @author fluke.kuczwa@gmail.com
 */
class DoctrineProvider implements DataProviderInterface, Countable {
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;
    
    public function __construct(QueryBuilder $query) {
        $this->setQueryBuilder($query);
    }
    
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder() {
        return $this->queryBuilder;
    }
    
    /**
     * @param QueryBuilder $query
     * @return DoctrineProvider
     */
    public function setQueryBuilder(QueryBuilder $query) {
        $this->queryBuilder = $query;
        return $this;
    }
    
    /**
     * 
     * @param int $limit
     * @param int $count
     */
    public function getResults($limit = 50, $offset = 0) {
        return $this->getQueryBuilder()
             ->getQuery()
             ->setMaxResults((int) $limit)
             ->setFirstResult((int) $offset)
             ->getResult();
    }

    public function count() {
        return 0;
    }
}
