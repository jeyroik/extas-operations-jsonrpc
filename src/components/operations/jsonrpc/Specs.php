<?php
namespace extas\components\operations\jsonrpc;

use extas\components\Item;
use extas\components\operations\jsonrpc\specs\SpecsProperty;
use extas\interfaces\operations\jsonrpc\ISpecs;
use extas\interfaces\operations\jsonrpc\specs\ISpecsProperty;

/**
 * Class Specs
 *
 * @package extas\components\operations\jsonrpc
 * @author jeyroik <jeyroik@gmail.com>
 */
class Specs extends Item implements ISpecs
{
    /**
     * @return ISpecsProperty
     */
    public function getRequest(): ISpecsProperty
    {
        return new SpecsProperty($this->config[static::FIELD__REQUEST] ?? []);
    }

    /**
     * @return ISpecsProperty
     */
    public function getResponse(): ISpecsProperty
    {
        return new SpecsProperty($this->config[static::FIELD__RESPONSE] ?? []);
    }

    /**
     * @param ISpecsProperty $request
     * @return $this|Specs
     */
    public function setRequest(ISpecsProperty $request)
    {
        $this->config[static::FIELD__REQUEST] = $request->__toArray();

        return $this;
    }

    /**
     * @param ISpecsProperty $response
     * @return $this|Specs
     */
    public function setResponse(ISpecsProperty $response)
    {
        $this->config[static::FIELD__RESPONSE] = $response->__toArray();

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
