<?php
namespace extas\components\operations;

use extas\components\operations\jsonrpc\Specs;
use extas\interfaces\operations\IJsonRpcOperation;
use extas\interfaces\operations\jsonrpc\ISpecs;
use extas\interfaces\repositories\IRepository;

/**
 * Class JsonRpcOperation
 *
 * @package extas\components\operations
 * @author jeyroik <jeyroik@gmail.com>
 */
class JsonRpcOperation extends Operation implements IJsonRpcOperation
{
    /**
     * @return string
     */
    public function getItemName(): string
    {
        return $this->getParameterValue(static::PARAM__ITEM_NAME, '');
    }

    /**
     * @return string
     */
    public function getItemClass(): string
    {
        return $this->getParameterValue(static::PARAM__ITEM_CLASS, '');
    }

    /**
     * @param array $config
     * @return mixed
     */
    public function buildItem(array $config = [])
    {
        $class = $this->getItemClass();

        return new $class();
    }

    /**
     * @return string
     */
    public function getItemRepositoryName(): string
    {
        return $this->getParameterValue(static::PARAM__ITEM_REPOSITORY, '');
    }

    /**
     * @return IRepository
     */
    public function getItemRepository(): IRepository
    {
        $repoName = $this->getItemRepositoryName();

        return $this->$repoName();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->getParameterValue(static::PARAM__METHOD, '');
    }

    /**
     * @return ISpecs
     */
    public function getSpecsAsObject(): ISpecs
    {
        return new Specs($this->getSpecs());
    }

    /**
     * @param ISpecs $specs
     * @return $this|JsonRpcOperation
     */
    public function setSpecsFromObject(ISpecs $specs)
    {
        $this->setSpecs($specs->__toArray());

        return $this;
    }
}
