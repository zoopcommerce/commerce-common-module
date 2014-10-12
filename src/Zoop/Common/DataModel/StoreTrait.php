<?php

namespace Zoop\Common\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

trait StoreTrait
{
    /**
     * @ODM\Collection
     * @ODM\Index
     * @Shard\Zones
     */
    protected $store;

    /**
     * @return string
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param string $store
     */
    public function setStore($store)
    {
        $this->store = (string) $store;
    }
}
