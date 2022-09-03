<?php

namespace GFNL\ModelExample\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

use GFNL\ModelExample\Api\Data\ExampleSearchResultsInterface;
use GFNL\ModelExample\Model\ExampleFactory;
use GFNL\ModelExample\Api\ExampleRepositoryInterface;
use GFNL\ModelExample\Model\ResourceModel\Example as ExampleResource;
use GFNL\ModelExample\Model\ResourceModel\Example\CollectionFactory;
use GFNL\ModelExample\Model\ResourceModel\Example\Collection;
use \Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

//use GFNL\ModelExample\Api\Data\ExampleSearchResultsInterface;

class ExampleRepository implements ExampleRepositoryInterface
{
    public function __construct(
        ExampleResource                                                  $customResource,
        ExampleFactory                                                   $customFactory,
        CollectionFactory                                                $collectionFactory,
        CollectionProcessorInterface                                     $collectionProcessor,
        \GFNL\ModelExample\Api\Data\ExampleSearchResultsInterfaceFactory $searchResultsFactory
    )
    {
        $this->customResource = $customResource;
        $this->customFactory = $customFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;

        $this->searchResultFactory = $searchResultsFactory;
    }

    public function save(\GFNL\ModelExample\Api\Data\ExampleInterface $custom)
    {
            $custom->setCustomName($custom->getCustomName());
        try {
            $this->customResource->save($custom);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        }
        return $custom;
//        return $this->customResource->save($custom);
    }

    /**
     * @inheritDoc
     */
    public function getById($customId)
    {
        $custom = $this->customFactory->create();
        $this->customResource->load($custom, $customId);
        if (!$custom->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Unable to find ID "%1"', $customId));
        }
        return $custom;
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }


    /**
     * @inheritDoc
     */
    public function delete(\GFNL\ModelExample\Api\Data\ExampleInterface $custom)
    {
        try {
            $this->customResource->delete($custom);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

}
