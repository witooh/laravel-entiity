<?php
namespace Witooh\Entities;

interface IEntityFactory {
    /**
     * @param string $name
     * @param null|array $attr
     * @return \Witooh\Entities\AbstractEntitiy
     */
    public function create($name, $attr=null);
}