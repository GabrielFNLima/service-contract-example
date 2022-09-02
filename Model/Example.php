<?php

namespace GFNL\ModelExample\Model;

use Magento\Framework\Model\AbstractModel;
use GFNL\ModelExample\Api\Data\ExampleInterface;
use GFNL\ModelExample\Model\ResourceModel\Example as ResourceModelExample;
class Example extends AbstractModel implements ExampleInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModelExample::class);
    }

    public function setCustomName($customName)
    {
        return $this->setData('custom_name', $customName);
    }

    public function getCustomName()
    {
        return $this->getData('custom_name');
    }

    public function getCustomAttributes()
    {
        return [];
    }
}
