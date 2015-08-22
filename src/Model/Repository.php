<?php

namespace Fire\Model;

use Closure;
use Fire\Contracts\Model\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $entityMappers = [];

    /**
     * Add an entity mapper to the registry
     *
     * @param  Closure  $closure
     */
    public function registerEntityMapper(Closure $closure)
    {
        $this->entityMappers[] = $closure;
    }

    /**
     * Map data array to the new entity object
     *
     * @param  array  $data
     * @return Fire\Contracts\Model\Entity
     */
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

    /**
     * Create a new entity object
     *
     * @return  Fire\Contracts\Model\Entity
     */
    protected function createEntity()
    {
        return new $this->entityClass;
    }

    /**
     * Set the entity class
     *
     * @param string  $class
     */
    public function setEntityClass($class)
    {
        $this->entityClass = $class;
    }
}
