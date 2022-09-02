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
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \GFNL\ModelExample\Model\ExampleRepository $modelRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory
    ) {
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
        $_filter = $this->searchCriteriaBuilder->addFilter("custom_name","lima")->create();
        $list = $this->modelRepository->getList($_filter);
        $results = $list->getItems();

//        $list = $this->modelRepository->getById(3);
//        $results = $list->getData();

//        $this->modelRepository->delete(3);

//        $list = $this->collectionFactory->create()->addFieldToSelect('*');
//        $results = $list->load()->getData();
        var_dump($results);
//        foreach ($results as $result) {
//            echo $result['custom_name']. "<br/>";
//        }
        die('list3');



    }
}
