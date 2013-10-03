<?php
namespace Witooh\Entity;

use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;

abstract class AbstractEntity implements ArrayableInterface, JsonableInterface
{

    protected $primaryKey = 'id';

    protected $attributes = array();

    protected $fillable = array();

    public function __construct(array $attr = array())
    {

        if (empty($attr)) {
            $this->init();
        } else {
            $this->fill($attr);
        }
    }


    public function init()
    {

    }

    /**
     * @param array $attr
     * @param bool $guard
     */
    public function fill(array $attr, $guard = true)
    {
        foreach ($attr as $key => $value) {
            if ($guard) {
                if (array_key_exists($key, $this->fillable)) {
                    $this->$key = $value;
                }
            } else {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param string $prefix
     * @param string $name
     * @return string
     */
    protected function toMethod($prefix, $name)
    {
        return $prefix . ucfirst(camel_case($name));
    }

    public function __get($name)
    {
        $method = $this->toMethod('get', $name);

        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        throw new NotFoundAttributeException();
    }

    public function __set($name, $value)
    {
        $method = $this->toMethod('set', $name);

        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->attributes[$name] = $value;
        }
    }

    /**
     * @return array
     */
    public function toDb()
    {
        $arr        = array();
        $properties = $this->attributes;
        foreach ($properties as $key => $value) {
            $method = $this->toMethod('db', $key);
            if (method_exists($this, $method)) {
                $arr[$key] = $this->$method();
            } else {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $arr        = array();
        $properties = $this->attributes;
        foreach ($properties as $key => $value) {
            if ($value instanceof ArrayableInterface) {
                $arr[$key] = $value->toArray();
            } else {
                $arr[$key] = $this->$key;
            }
        }

        return $arr;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function getKeyValue()
    {
        $key = $this->primaryKey;

        return $this->$key;
    }

}