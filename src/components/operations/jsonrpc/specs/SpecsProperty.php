<?php
namespace extas\components\operations\jsonrpc\specs;

use extas\components\exceptions\AlreadyExist;
use extas\components\Item;
use extas\components\THasName;
use extas\components\THasType;
use extas\interfaces\operations\jsonrpc\specs\ISpecsProperty;

/**
 * Class SpecsProperty
 *
 * @package extas\components\operations\jsonrpc\specs
 * @author jeyroik <jeyroik@gmail.com>
 */
class SpecsProperty extends Item implements ISpecsProperty
{
    use THasName;
    use THasType;

    /**
     * @return array
     */
    public function __toArray(): array
    {
        $result = parent::__toArray();
        unset($result[static::FIELD__NAME]);

        return $result;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->config[static::FIELD__PROPERTIES] ?? [];
    }

    /**
     * @param ISpecsProperty $property
     * @return $this|SpecsProperty
     * @throws AlreadyExist
     */
    public function addProperty(ISpecsProperty $property)
    {
        $props = $this->getProperties();
        $name = $property->getName();

        if (isset($props[$name])) {
            throw new AlreadyExist('property "' . $name . '"');
        }

        $this->setProperty($name, $property->__toArray());

        return $this;
    }

    /**
     * @param array $properties
     * @return $this|SpecsProperty
     */
    public function setProperties(array $properties)
    {
        $this->config[static::FIELD__PROPERTIES] = $properties;

        return $this;
    }

    /**
     * @param string $name
     * @param array $value
     * @return $this|SpecsProperty
     */
    public function setProperty(string $name, array $value)
    {
        $props = $this->getProperties();
        $props[$name] = $value;

        $this->setProperties($props);

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
