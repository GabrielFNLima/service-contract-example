<?php

namespace GFNL\ModelExample\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Example extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('gfnl_example', 'id');
    }

    public function addRelations($data)
    {
        $this->getConnection()
            ->insertMultiple('gfnl_example', $data);
    }

}
