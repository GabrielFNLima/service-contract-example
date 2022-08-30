<?php

namespace GFNL\ModelExample\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use GFNL\ModelExample\Api\Data\ExampleSearchResultsInterfaceFactory;
use GFNL\ModelExample\Model\ExampleFactory;
use GFNL\ModelExample\Api\ExampleRepositoryInterface;
use GFNL\ModelExample\Model\ResourceModel\Example as ExampleResource;
use GFNL\ModelExample\Model\ResourceModel\Example\CollectionFactory;

class ExampleRepository implements ExampleRepositoryInterface
{
    public function __construct(
        ExampleResource $customResource,
        ExampleFactory $customFactory,
        CollectionFactory $collectionFactory,
        ExampleSearchResultsInterfaceFactory $searchResultsFactory
    )
    {
        $this->customResource = $customResource;
        $this->customFactory = $customFactory;
        $this->collectionFactory = $collectionFactory;
        $this->$searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(\GFNL\ModelExample\Api\Data\ExampleInterface  $custom)
    {
        $this->customResource->save($custom);
        return $custom->getId();
    }

    /**
     * @inheritDoc
     */
    public function getById($customId)
    {
        $custom = $this->customFactory->create();
        $this->customResource->load($custom, $customId);
        if(!$custom->getId()) {
            throw new NoSuchEntityException('Custom does not exist');
        }
        return $custom;
    }

    /**
     * @inheritDoc
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder(
                $field,
                $this->getDirection($sortOrder->getDirection())
            );

        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->load();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setCriteria($searchCriteria);

        $customs=[];
        foreach ($collection as $Custom){
            $Customs[] = $Custom;
        }
        $searchResults->setItems($customs);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete($customId)
    {
        $custom = $this->customFactory->create();
        $custom->setId($customId);
        if( $this->ExampleResource->delete($custom)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $customId
     * @return string
     */

    private function getDirection($direction)
    {
        return $direction == SortOrder::SORT_ASC ?: SortOrder::SORT_DESC;
    }
    /**
     * @param \Magento\Framework\Api\Search\FilterGroup $group
     *
     */
    private function addFilterGroupToCollection($group, $collection)
    {
        $fields = [];
        $conditions = [];

        foreach($group->getFilters() as $filter){
            $condition = $filter->getConditionType() ?: 'eq';
            $field = $filter->getField();
            $value = $filter->getValue();
            $fields[] = $field;
            $conditions[] = [$condition=>$value];

        }
        $collection->addFieldToFilter($fields, $conditions);
    }
}
