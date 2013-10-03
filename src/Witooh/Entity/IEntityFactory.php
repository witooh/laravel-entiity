<?php
namespace Witooh\Entity;

interface IEntityFactory {
    /**
     * @param string $name
     * @param null|array $attr
     * @return \Eloquent
     */
    public function create($name, $attr=null);
}