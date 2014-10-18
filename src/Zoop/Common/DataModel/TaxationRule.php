<?php

namespace Zoop\Common\DataModel;

use Zoop\Common\DataModel\TaxationRuleInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class TaxationRule implements TaxationRuleInterface
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

    public function isShippingTaxed()
    {
        return $this->isShippingTaxed;
    }

    public function setIsShippingTaxed($isShippingTaxed)
    {
        $this->isShippingTaxed = (boolean) $isShippingTaxed;
    }

    public function isTaxIncluded()
    {
        return $this->isTaxIncluded;
    }

    public function setIsTaxIncluded($isTaxIncluded)
    {
        $this->isTaxIncluded = (boolean) $isTaxIncluded;
    }

    public function isTaxRemoved()
    {
        return $this->isTaxRemoved;
    }

    public function setIsTaxRemoved($isTaxRemoved)
    {
        $this->isTaxRemoved = (boolean) $isTaxRemoved;
    }
}
