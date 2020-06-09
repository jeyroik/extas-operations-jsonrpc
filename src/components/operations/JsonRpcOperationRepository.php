<?php
namespace extas\components\operations;

use extas\components\repositories\Repository;
use extas\interfaces\operations\IOperationRepository;

/**
 * Class JsonRpcOperationRepository
 *
 * @package extas\components\operations
 * @author jeyroik <jeyroik@gmail.com>
 */
class JsonRpcOperationRepository extends Repository implements IOperationRepository
{
    protected string $name = 'jsonrpc_operations';
    protected string $scope = 'extas';
    protected string $pk = JsonRpcOperation::FIELD__NAME;
    protected string $itemClass = JsonRpcOperation::class;
}
