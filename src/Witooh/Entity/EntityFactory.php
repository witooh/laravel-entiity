<?php
namespace Witooh\Entities;

class EntityFactory implements IEntityFactory {

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param string $name
     * @param null|array $attr
     * @return \Witooh\Entities\AbstractEntitiy
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