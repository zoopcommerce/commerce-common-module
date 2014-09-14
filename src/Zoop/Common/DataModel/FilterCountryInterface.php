<?php

namespace Zoop\Common\DataModel;

interface FilterCountryInterface
{
    public function getCompanies();

    public function setCompanies(array $companies);

    public function addCompany($company);
}
