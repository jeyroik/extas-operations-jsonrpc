<?php
namespace tests;

use extas\components\operations\jsonrpc\Specs;
use extas\components\operations\jsonrpc\specs\SpecsProperty;
use extas\components\repositories\TSnuffRepository;
use extas\components\repositories\TSnuffRepositoryDynamic;
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
    use TSnuffRepositoryDynamic;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->createSnuffDynamicRepositories([]);
    }

    protected function tearDown(): void
    {
        $this->deleteSnuffDynamicRepositories();
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
                    ISampleParameter::FIELD__VALUE => 'snuffRepository'
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
        $this->assertEquals('snuffRepository', $op->getItemRepositoryName());
        $this->assertInstanceOf(SnuffRepository::class, $op->getItemRepository());
        $this->assertEquals('test', $op->getMethod());
    }

    public function testSpecs()
    {
        $op = new JsonRpcOperation();

        $specs = new Specs();
        $request = new SpecsProperty([
            SpecsProperty::FIELD__NAME => 'request',
            SpecsProperty::FIELD__TYPE => 'object',
            SpecsProperty::FIELD__PROPERTIES => []
        ]);
        $request->addProperty(new SpecsProperty([
            SpecsProperty::FIELD__NAME => 'test',
            SpecsProperty::FIELD__TYPE => 'string'
        ]));
        $request->setProperty('custom', [
            'arg1' => 'val1'
        ]);

        $response = new SpecsProperty([
            SpecsProperty::FIELD__NAME => 'response',
            SpecsProperty::FIELD__TYPE => 'object',
            SpecsProperty::FIELD__PROPERTIES => []
        ]);

        $specs->setRequest($request)->setResponse($response);

        $this->assertEquals(
            [
                'type' => 'object',
                'properties' => [
                    'test' => [
                        'type' => 'string'
                    ],
                    'custom' => [
                        'arg1' => 'val1'
                    ]
                ]
            ],
            $specs->getRequest()->__toArray(),
            'Incorrect request: ' . print_r($specs->getRequest()->__toArray(), true)
        );
        $this->assertEquals(
            [
                'type' => 'object',
                'properties' => []
            ],
            $specs->getResponse()->__toArray(),
            'Incorrect response: ' . print_r($specs->getResponse()->__toArray(), true)
        );

        $this->assertEquals(
            [
                'request' => [
                    'type' => 'object',
                    'properties' => [
                        'test' => [
                            'type' => 'string'
                        ],
                        'custom' => [
                            'arg1' => 'val1'
                        ]
                    ]
                ],
                'response' => [
                    'type' => 'object',
                    'properties' => []
                ]
            ],
            $specs->__toArray(),
            'Incorrect specs:' . print_r($specs->__toArray(), true)
        );

        $op->setSpecsFromObject($specs);
        $this->assertEquals(
            [
                'request' => [
                    'type' => 'object',
                    'properties' => [
                        'test' => [
                            'type' => 'string'
                        ],
                        'custom' => [
                            'arg1' => 'val1'
                        ]
                    ]
                ],
                'response' => [
                    'type' => 'object',
                    'properties' => []
                ]
            ],
            $op->getSpecsAsObject()->__toArray(),
            'Incorrect specs:' . print_r($specs->__toArray(), true)
        );

        $this->assertEquals(
            [
                'specs' => [
                    'request' => [
                        'type' => 'object',
                        'properties' => [
                            'test' => [
                                'type' => 'string'
                            ],
                            'custom' => [
                                'arg1' => 'val1'
                            ]
                        ]
                    ],
                    'response' => [
                        'type' => 'object',
                        'properties' => []
                    ]
                ]
            ],
            $op->__toArray()
        );
    }

    public function testAlreadyExistedProperty()
    {
        $prop = new SpecsProperty();
        $prop->addProperty(new SpecsProperty([
            SpecsProperty::FIELD__NAME => 'test'
        ]));

        $this->expectExceptionMessage('Property "test" already exist');
        $prop->addProperty(new SpecsProperty([
            SpecsProperty::FIELD__NAME => 'test'
        ]));
    }
}
