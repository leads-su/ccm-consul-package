<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use ConsulConfigManager\Consul\Test\TestCase;
use ConsulConfigManager\Consul\Domain\Service\Events\ServiceCreated;

/**
 * Class AbstractEventTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\Service\Events
 */
abstract class AbstractEventTest extends TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetDateTimeMethod(array $data): void
    {
        $instance = new ServiceCreated($data);
        $this->assertNotEquals(0, $instance->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromSetDateTimeMethod(array $data): void
    {
        $instance = new ServiceCreated($data);

        /**
         * @var Carbon $carbonInstance
         */
        $carbonInstance = Arr::get($data, 'time');
        $instance->setDateTime($carbonInstance);

        $this->assertEquals($carbonInstance->getTimestamp(), $instance->getDateTime());
    }

    /**
     * Created event data provider
     * @return \array[][]
     */
    public function eventDataProvider(): array
    {
        return [
            'ccm-example-127.0.0.1'             =>  [
                'data'                          =>  [
                    'id'                        =>  'ccm-example-127.0.0.1',
                    'uuid'                      =>  'aa52111e-751a-4ca2-a63e-01acdce449c5',
                    'service'                   =>  'ccm',
                    'address'                   =>  '127.0.0.1',
                    'port'                      =>  32175,
                    'datacenter'                =>  'dc0',
                    'tags'                      =>  [],
                    'meta'                      =>  [
                        'operating_system'      =>  'linux',
                        'log_level'             =>  'DEBUG',
                        'go_version'            =>  '1.17.2',
                        'environment'           =>  'development',
                        'architecture'          =>  'amd64',
                        'application_version'   =>  '99.9.9',
                    ],
                    'online'                    =>  true,
                    'time'                      =>  Carbon::now(),
                ],
            ],
        ];
    }
}
