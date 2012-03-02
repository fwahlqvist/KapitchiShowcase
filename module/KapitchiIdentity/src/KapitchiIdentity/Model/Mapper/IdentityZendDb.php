<?php

namespace KapitchiIdentity\Model\Mapper;

use KapitchiIdentity\Model\Mapper\Identity as IdentityMapper,
    KapitchiIdentity\Model\Identity;

class IdentityZendDb extends \ZfcBase\Mapper\DbMapperAbstract implements IdentityMapper {
    public function persist(Identity $model) {
        var_dump($model);
        exit;
    }
    
    public function remove(Identity $model) {
        var_dump($model);
        exit;
    }
}