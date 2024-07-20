<?php
namespace Apps\Core\Entity;
use \ReflectionClass;
abstract class Entity
{
    public function __get($property) {
        $reflector = new ReflectionClass($this);
        if ($reflector->hasProperty($property)) {
            $propertyReflector = $reflector->getProperty($property);
            $propertyReflector->setAccessible(true);
            return $propertyReflector->getValue($this);
        } else {
            throw new \Exception("Propriété '$property' inexistante dans la classe " . get_class($this));
        }
    }

    public function __set($property, $value) {
        $reflector = new ReflectionClass($this);
        if ($reflector->hasProperty($property)) {
            $propertyReflector = $reflector->getProperty($property);
            $propertyReflector->setAccessible(true);
            $propertyReflector->setValue($this, $value);
        } else {
            throw new \Exception("Propriété '$property' inexistante dans la classe " . get_class($this));
        }
    }

    public function __serialize() {}
    public function __unserialize($serialized) {}

}