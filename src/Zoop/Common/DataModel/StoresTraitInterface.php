<?php

namespace Zoop\Common\DataModel;

interface StoresTraitInterface
{
    public function getStores();

    public function setStores(array $stores);

    public function addStore($store);
}
