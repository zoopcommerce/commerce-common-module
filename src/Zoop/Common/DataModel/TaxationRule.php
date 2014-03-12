<?php

namespace Zoop\Common\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class TaxationRule
{
    /**
     * @ODM\String
     */
    protected $name;

    /**
     *
     * @ODM\Float
     */
    protected $rate;

    /**
     *
     * @ODM\String
     */
    protected $number;

    /**
     *
     * @ODM\Boolean
     */
    protected $isShippingTaxed = true;

    /**
     *
     * @ODM\Boolean
     */
    protected $isTaxIncluded = true;

    /**
     *
     * @ODM\Boolean
     */
    protected $isTaxRemoved = false;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = (string) $rate;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getIsShippingTaxed()
    {
        return $this->isShippingTaxed;
    }

    public function setIsShippingTaxed($isShippingTaxed)
    {
        $this->isShippingTaxed = (boolean) $isShippingTaxed;
    }

    public function getIsTaxIncluded()
    {
        return $this->isTaxIncluded;
    }

    public function setIsTaxIncluded($isTaxIncluded)
    {
        $this->isTaxIncluded = (boolean) $isTaxIncluded;
    }

    public function getIsTaxRemoved()
    {
        return $this->isTaxRemoved;
    }

    public function setIsTaxRemoved($isTaxRemoved)
    {
        $this->isTaxRemoved = (boolean) $isTaxRemoved;
    }
}
