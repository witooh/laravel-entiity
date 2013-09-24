<?php

namespace Witooh\Entity;

use Illuminate\Support\Collection;

class PageCollection extends AbstractEntitiy
{

    /**
     * @var int
     */
    protected $total;
    /**
     * @var int
     */
    protected $start;
    /**
     * @var int
     */
    protected $limit;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    public function __construct()
    {
        $this->total  = 0;
        $this->start = 0;
        $this->limit  = 0;
        $this->items  = new Collection();
    }

    /**
     * @param array $value
     */
    public function setItems($value)
    {
        $this->items = $this->items->make($value);
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return (int)ceil($this->total/$this->limit);
    }

    /**
     * @return int
     */
    public function getTotalItem()
    {
        return $this->items->count();
    }
}