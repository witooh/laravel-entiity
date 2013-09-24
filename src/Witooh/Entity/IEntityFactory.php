<?php
namespace Witooh\Entity;

interface IEntityFactory {
    /**
     * @param string $name
     * @param null|array $attr
     * @return \Witooh\Entity\AbstractEntitiy
     */
    public function create($name, $attr=null);
}