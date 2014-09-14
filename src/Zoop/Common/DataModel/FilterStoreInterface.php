<?php

namespace Zoop\Common\DataModel;

interface FilterStoreInterface
{
    public function getStores();

    public function setStores(array $stores);

    public function addStore($store);
}
