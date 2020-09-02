<?php
namespace extas\interfaces\operations;

use extas\interfaces\operations\jsonrpc\ISpecs;
use extas\interfaces\repositories\IRepository;

/**
 * Interface IJsonRpcOperation
 *
 * @package extas\interfaces\operations
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IJsonRpcOperation extends IOperation
{
    public const PARAM__ITEM_NAME = 'item_name';
    public const PARAM__ITEM_CLASS = 'item_class';
    public const PARAM__ITEM_REPOSITORY = 'item_repository';
    public const PARAM__METHOD = 'method';

    /**
     * @return string
     */
    public function getItemName(): string;

    /**
     * @return string
     */
    public function getItemClass(): string;

    /**
     * @param array $config
     * @return mixed
     */
    public function buildItem(array $config = []);

    /**
     * @return string
     */
    public function getItemRepositoryName(): string;

    /**
     * @return IRepository
     */
    public function getItemRepository(): IRepository;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return ISpecs
     */
    public function getSpecsAsObject(): ISpecs;

    /**
     * @param ISpecs $specs
     * @return $this
     */
    public function setSpecsFromObject(ISpecs $specs);
}
