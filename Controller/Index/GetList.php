<?php

namespace GFNL\ModelExample\Controller\Index;


use GFNL\ModelExample\Model\ResourceModel\Example\CollectionFactory;
use \Magento\Framework\Controller\Result\RawFactory;
use GFNL\ModelExample\Model\ExampleRepository;

class Getlist extends \Magento\Framework\App\Action\Action
{

    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    private $resultPageFactory;
    /**
     * @var
     */
    private $modelFactory;
    /**
     * @var
     */
    private $modelRepository;
    /**
     * @var
     */
    private $searchCriteriaBuilder;
    private CollectionFactory $collectionFactory;


    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \GFNL\ModelExample\Model\ExampleRepository $modelRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Magento\Framework\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory   $resultPageFactory,
        \GFNL\ModelExample\Model\ExampleRepository   $modelRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory                            $collectionFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->modelRepository = $modelRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $_filter = $this->searchCriteriaBuilder->create();
        $list = $this->modelRepository->getList($_filter);
        $results = $list->getItems();

        foreach ($results as $result) {
            echo $result->getCustomName(). " - ". $result->getId() ."<br/>";
        }
        $this->resultFactory->create("raw");


    }
}
