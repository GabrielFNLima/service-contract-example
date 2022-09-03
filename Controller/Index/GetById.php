<?php

namespace GFNL\ModelExample\Controller\Index;

use \Magento\Framework\Controller\Result\RawFactory;

class GetById extends \Magento\Framework\App\Action\Action
{

    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    private $resultPageFactory;
    /**
     * @var
     */
    private $modelRepository;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \GFNL\ModelExample\Model\ExampleRepository $modelRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \GFNL\ModelExample\Model\ExampleRepository $modelRepository,
        \Magento\Framework\App\Request\Http $request

    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->modelRepository = $modelRepository;
        $this->request = $request;
        return parent::__construct($context);
    }

    public function execute()
    {
        $search = $this->modelRepository->getById($this->request->getParam('id'));
        echo "ID: ".$search->getId()."<br>";
        echo "Custom Name: ".$search->getCustomName()."<br>";
        $this->resultPageFactory->create("raw");
    }
}
