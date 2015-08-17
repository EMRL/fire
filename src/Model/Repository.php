<?php

namespace Fire\Model;

use Closure;
use Fire\Contracts\Model\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract
{
    /**
     * @var  string
     */
    protected $entityClass;

    /**
     * @var  [Fire\Contracts\Model\EntityMapper]
     */
    protected $entityMappers = [];

    public function registerEntityMapper(Closure $closure)
    {
        $this->entityMappers[] = $closure;
    }

    protected function mapData(array $data)
    {
        $entity = $this->createEntity();

        foreach ($this->entityMappers as $key => $mapper) {
            if ($mapper instanceof Closure) {
                $this->entityMappers[$key] = $mapper = $mapper();
            }

            $mapper->map($entity, $data);
        }

        return $entity;
    }

    protected function createEntity()
    {
        return new $this->entityClass;
    }

    public function setEntityClass($class)
    {
        $this->entityClass = $class;
    }
}
