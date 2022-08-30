<?php

namespace GFNL\ModelExample\Api;

interface ExampleRepositoryInterface
{
    /**
     * @param \GFNL\ModelExample\Api\Data\ExampleInterface $custom
     * @return int
     */
    public function save(\GFNL\ModelExampl\Api\Data\Examplenterface $custom);

    /**
     * @param $customId
     * @return \GFNL\ModelExample\Api\Data\ExampleInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($customId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \GFNL\ModelExample\Api\Data\ExampleSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $customId
     * @return bool
     */
    public function delete($customId);
}
