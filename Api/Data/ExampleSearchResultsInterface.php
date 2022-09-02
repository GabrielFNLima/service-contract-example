<?php

namespace GFNL\ModelExample\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;


interface ExampleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \GFNL\ModelExample\Api\Data\ExampleInterface[]
     */
    public function getItems();

    /**
     * @param \GFNL\ModelExample\Api\Data\ExampleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
