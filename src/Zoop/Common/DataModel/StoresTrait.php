<?php

namespace Zoop\Common\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

trait StoresTrait
{
    /**
     * @ODM\Collection
     * @ODM\Index
     * @Shard\Zones
     */
    protected $stores = [];

    /**
     * @return array
     */
    public function getStores()
    {
        if (!is_array($this->stores)) {
            $this->stores = [];
        }
        return $this->stores;
    }

    /**
     * @param array $stores
     */
    public function setStores(array $stores)
    {
        $this->stores = $stores;
    }

    /**
     * @param string $store
     */
    public function addStore($store)
    {
        if (!empty($store) && in_array($store, $this->getStores()) === false) {
            $this->stores[] = $store;
        }
    }
}
