<?php
namespace Witooh\Entity;

interface IAggregateFactory {
    /**
     * @param string $name
     * @param null|array $attr
     * @return \Witooh\Entity\AbstractEntity
     */
    public function create($name, $attr=null);
}