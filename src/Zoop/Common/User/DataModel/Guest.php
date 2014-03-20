<?php

namespace Zoop\Common\User\DataModel;

use Zoop\Common\User\UserInterface;
use Zoop\Common\User\RoleAwareUserInterface;
use Zoop\Shard\User\DataModel\UserTrait;
use Zoop\Shard\User\DataModel\RoleAwareUserTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class Guest implements UserInterface, RoleAwareUserInterface
{
    use UserTrait;
    use RoleAwareUserTrait;
}
