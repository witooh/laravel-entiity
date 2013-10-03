<?php
namespace Witooh\Entity;

use Illuminate\Support\Contracts\ArrayableInterface;

abstract class AbstractEntity2 implements ArrayableInterface
{
    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        $type = str_split($name, 3)[0];
        if ($type == 'get') {
            return $this->getMethod($this->toSnakeCase("get", $name));
        } elseif ($type == 'set') {
            $this->setMethod($this->toSnakeCase("set", $name), $arguments[0]);
        }
    }

    /**
     * @param string $cut
     * @param string $methodName
     * @return string
     */
    private function toSnakeCase($cut, $methodName)
    {
        return snake_case(str_replace($cut, "", $methodName));
    }

    /**
     * @param string $prefix
     * @param string $propertyName
     * @return string
     */
    private function toMethodName($prefix, $propertyName)
    {
        return $prefix . ucfirst(camel_case($propertyName));
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \BadMethodCallException
     */
    private function getMethod($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \BadMethodCallException($name ." method doesn't exist");
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \BadMethodCallException
     */
    private function setMethod($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \BadMethodCallException($name ." method doesn't exist");
        }
    }

    /**
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        $properties = $this->toArray();

        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $properties)) {
                $method = $this->toMethodName('set', $key);
                $this->$method($value);
            }
        }
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = array();
        $attrs  = get_object_vars($this);
        foreach ($attrs as $key => $value) {
            if ($value instanceof ArrayableInterface) {
                $result[$key] = $value->toArray();
            } else {
                $method       = $this->toMethodName('get', $key);
                $result[$key] = $this->$method();
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}