<?php

namespace GFNL\ModelExample\Model\ResourceModel\Example;

use GFNL\ModelExample\Model\Example;
use GFNL\ModelExample\Model\ResourceModel\Example as ResourceModelExample;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Example::class, ResourceModelExample::class);
    }
}
