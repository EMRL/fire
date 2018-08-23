<?php

namespace Fire\Model\Term;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;

class TermEntityMapper implements EntityMapperContract
{
    public function map(EntityContract $entity, array $data)
    {
        $entity->setId($data['term_id']);
        $entity->setName($data['name']);
        $entity->setSlug($data['slug']);
        $entity->setDescription($data['description']);
        $entity->setCount($data['count']);
        $entity->setTaxonomy(get_taxonomy($data['taxonomy']));
        $entity->setNative($data);
    }
}
