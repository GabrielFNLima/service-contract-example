<?php

namespace GFNL\ModelExample\Api\Data;

interface ExampleInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCustomName();

    /**
     * @param string $customName
     * @return $this
     */
    public function setCustomName($customName);
}
