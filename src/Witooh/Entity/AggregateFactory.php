<?php
namespace Witooh\Entity;

class AggregateFactory implements IAggregateFactory {

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param string $namespace
     */
    public function __construct($namespace="")
    {
        $this->namespace = $namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $name
     * @param null|array $attr
     * @return \Witooh\Entity\AbstractEntity
     */
    public function create($name, $attr=null)
    {
        $entityClassName = $this->getClassName($name);
        $entity = new $entityClassName;

        if(is_array($attr)){
            $entity->fill($attr);
        }

        return $entity;
    }

    /**
     * @param string $name
     * @return string
     */
    private function getClassName($name)
    {
        return $this->namespace . '\\' . $name;
    }
}