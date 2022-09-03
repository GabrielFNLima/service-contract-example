<?php

namespace GFNL\ModelExample\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use GFNL\ModelExample\Model\ExampleFactory;
use GFNL\ModelExample\Model\ExampleRepository;

/**
 * Class Index
 * @package GFNL\ModelExample\Controller\Index\Index
 */
class Index extends Action
{


    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    protected $resultPageFactory;
    private ExampleFactory $exampleFactory;
    private ExampleRepository $exampleRepository;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory, ExampleFactory $exampleFactory, ExampleRepository $exampleRepository)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->exampleFactory = $exampleFactory;
        $this->exampleRepository = $exampleRepository;
        return parent::__construct($context);
    }

    /**
     * Function execute
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $obj = $this->exampleFactory->create()->addData([
            'custom_name' => 'lima ' . rand()
        ]);
        var_dump($this->exampleRepository->save($obj)->getCustomName());

        $this->resultFactory->create("raw");
    }
}
