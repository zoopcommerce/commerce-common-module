<?php

namespace Zoop\Common\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

trait CompaniesTrait
{
    /**
     * @ODM\Collection
     * @ODM\Index
     * @Shard\Zones
     */
    protected $companies = [];

    /**
     * @return array
     */
    public function getCompanies()
    {
        if (!is_array($this->companies)) {
            $this->companies = [];
        }
        return $this->companies;
    }

    /**
     * @param array $companies
     */
    public function setCompanies(array $companies)
    {
        $this->companies = $companies;
    }

    /**
     * @param string $company
     */
    public function addCompany($company)
    {
        if (!empty($company) && in_array($company, $this->getCompanies()) === false) {
            $this->companies[] = $company;
        }
    }
}
