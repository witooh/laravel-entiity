<?php

namespace Witooh\Entity;

class Paginator
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var array
     */
    protected $query;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $dir;

    public function __construct()
    {
        $this->limit = 15;
        $this->offset = 0;
        $this->order = null;
        $this->dir = null;
        $this->total = null;
        $this->items = null;
    }

    public function toArray()
    {
        if($this->items === null) throw new \Exception('Items does\'t set in paginator');
        return array(
            'total' => $this->total,
            'count' => $this->count,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'page' => $this->page,
            'order' => $this->order,
            'dir' => $this->dir,
            'items' => $this->items,
        );
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toJson());
    }

    /**
     * @return int
     */
    protected function getPageAttribute()
    {
        return (int)ceil($this->total / $this->limit);
    }

    /**
     * @return int
     */
    protected function getCountAttribute()
    {
        return count($this->items);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasQuery($name)
    {
        return empty($this->query[$name]) ? false : true;
    }

    /**
     * @param array $query
     * @param int $offset
     * @param int $limit
     * @param string $order
     * @param string $dir
     */
    public function setCriteria(array $query, $offset, $limit, $order, $dir){
        $this->setValue('offset', $offset);
        $this->setValue('limit', $limit);
        $this->setValue('order', $order);
        $this->setValue('dir', $dir);
        $this->setValue('query', $query);
    }

    public function setCriteriaByArray(array $criteria)
    {
        foreach($criteria as $key=>$value)
        {
            if(property_exists($this, $key)){
                $this->setValue($key, $value);
            }
        }
    }

    protected function setValue($key, $value)
    {
        if(!isset($value))
        {
            $this->$key = $value;
        }
    }


    /**
     * @param string $name
     * @return mixed
     */
    public function getQuery($name)
    {
        return $this->query[$name];
    }

    public function hasOrder()
    {
        return empty($this->order) && empty($this->dir) ? false : true;
    }

    /**
     * @param int $total
     * @param array $items
     */
    public function setItems($total, array $items){
        $this->items = $items;
        $this->total = $total;
        $this->count = $this->getCountAttribute();
        $this->page = $this->getPageAttribute();
    }
}