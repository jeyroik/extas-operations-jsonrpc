<?php
namespace tests;

use extas\interfaces\samples\parameters\ISampleParameter;

use extas\components\items\SnuffRepository;
use extas\components\operations\JsonRpcOperation;
use extas\components\plugins\PluginEmpty;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonRpcOperationTest
 *
 * @package tests
 * @author jeyroik <jeyroik@gmail.com>
 */
class JsonRpcOperationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
    }

    public function testBasicLogic()
    {
        $op = new JsonRpcOperation([
            JsonRpcOperation::FIELD__PARAMETERS => [
                JsonRpcOperation::PARAM__ITEM_NAME => [
                    ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_NAME,
                    ISampleParameter::FIELD__VALUE => 'test'
                ],
                JsonRpcOperation::PARAM__ITEM_CLASS => [
                    ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_CLASS,
                    ISampleParameter::FIELD__VALUE => PluginEmpty::class
                ],
                JsonRpcOperation::PARAM__ITEM_REPOSITORY => [
                    ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_REPOSITORY,
                    ISampleParameter::FIELD__VALUE => SnuffRepository::class
                ],
                JsonRpcOperation::PARAM__METHOD => [
                    ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__METHOD,
                    ISampleParameter::FIELD__VALUE => 'test'
                ]
            ]
        ]);

        $this->assertEquals('test', $op->getItemName());
        $this->assertEquals(PluginEmpty::class, $op->getItemClass());
        $this->assertInstanceOf(PluginEmpty::class, $op->buildItem());
        $this->assertEquals(SnuffRepository::class, $op->getItemRepositoryName());
        $this->assertInstanceOf(SnuffRepository::class, $op->getItemRepository());
        $this->assertEquals('test', $op->getMethod());
    }
}
