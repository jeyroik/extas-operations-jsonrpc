<?php
namespace extas\interfaces\operations\jsonrpc\specs;

use extas\interfaces\IHasName;
use extas\interfaces\IHasType;
use extas\interfaces\IItem;

/**
 * Interface ISpecsProperty
 *
 * @package extas\interfaces\operations\jsonrpc\specs
 * @author jeyroik <jeyroik@gmail.com>
 */
interface ISpecsProperty extends IItem, IHasName, IHasType
{
    public const SUBJECT = 'extas.operation.jsonrpc.specs.property';

    public const FIELD__PROPERTIES = 'properties';

    /**
     * @return array
     */
    public function getProperties(): array;

    /**
     * @param ISpecsProperty $property
     * @return $this
     */
    public function addProperty(ISpecsProperty $property);

    /**
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties);

    /**
     * @param string $name
     * @param array $value
     * @return $this
     */
    public function setProperty(string $name, array $value);

    /**
     * @param string $name
     * @return bool
     */
    public function hasProperty(string $name): bool;
}
