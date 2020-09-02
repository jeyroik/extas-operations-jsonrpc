<?php
namespace extas\interfaces\operations\jsonrpc;

use extas\interfaces\IItem;
use extas\interfaces\operations\jsonrpc\specs\ISpecsProperty;

/**
 * Interface ISpecs
 *
 * @package extas\interfaces\operations\jsonrpc
 * @author jeyroik <jeyroik@gmail.com>
 */
interface ISpecs extends IItem
{
    public const SUBJECT = 'extas.operation.jsonrpc.specs';

    public const FIELD__REQUEST = 'request';
    public const FIELD__RESPONSE = 'response';

    /**
     * @return ISpecsProperty
     */
    public function getRequest(): ISpecsProperty;

    /**
     * @return ISpecsProperty
     */
    public function getResponse(): ISpecsProperty;

    /**
     * @param ISpecsProperty $request
     * @return $this
     */
    public function setRequest(ISpecsProperty $request);

    /**
     * @param ISpecsProperty $response
     * @return $this
     */
    public function setResponse(ISpecsProperty $response);
}
