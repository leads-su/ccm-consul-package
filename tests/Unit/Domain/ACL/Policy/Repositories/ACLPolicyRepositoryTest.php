<?php

namespace ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Test\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Test\Shared\ACL\WithPoliciesRepository;
use ConsulConfigManager\Consul\Domain\ACL\Policy\Interfaces\ACLPolicyEntity;

/**
 * Class ACLPolicyRepositoryTest
 * @package ConsulConfigManager\Consul\Test\Unit\Domain\ACL\Policy\Repositories
 */
class ACLPolicyRepositoryTest extends TestCase
{
    use WithPoliciesRepository;

    /**
     * Common policy id
     * @var string
     */
    private string $id = '1e8f8bb7-0111-450a-3f05-56d4e3911cc9';

    /**
     * Common policy name
     * @var string
     */
    private string $name = 'policy_example';

    /**
     * Common policy description
     * @var string
     */
    private string $description = 'This is an example policy.';

    /**
     * Common policy rules
     * @var string
     */
    private string $rules = '';

    public function testShouldPassIfCanCreateNewEntity(): void
    {
        $response = $this->policyRepository(mock: true)->create(
            $this->id,
            $this->name,
            $this->description,
            $this->rules
        );
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals($this->id, $response->getID());
        $this->assertEquals($this->name, $response->getName());
        $this->assertEquals($this->description, $response->getDescription());
        $this->assertEquals($this->rules, $response->getRules());
    }

    public function testShouldPassIfCanUpdateExistingEntity(): void
    {
        $response = $this->policyRepository(mock: true)->update(
            $this->id,
            $this->name,
            $this->description,
            $this->rules
        );
        $this->assertArrayHasKey('uuid', $response);
        $this->assertEquals($this->id, $response->getID());
        $this->assertEquals($this->name, $response->getName());
        $this->assertEquals($this->description, $response->getDescription());
        $this->assertEquals($this->rules, $response->getRules());
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllRequest(): void
    {
        $response = $this->policyRepository(true)->all();
        $this->assertEquals(
            $this->exceptDates($this->policyEntries, true),
            $this->exceptDates($response, true)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindRequest(): void
    {
        $response = $this->policyRepository(true)->find('1e8f8bb7-0111-450a-3f05-56d4e3911bb9');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByRequestWithId(): void
    {
        $response = $this->policyRepository(true)->findBy('id', '1e8f8bb7-0111-450a-3f05-56d4e3911bb9');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByRequestWithUuid(): void
    {
        $response = $this->policyRepository(true)->findBy('uuid', '0ead0ce3-1651-446e-9935-e558ad766eac');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByManyRequest(): void
    {
        $response = $this->policyRepository(true)->findByMany(['id', 'uuid'], '0ead0ce3-1651-446e-9935-e558ad766eac');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindOrFailRequest(): void
    {
        $response = $this->policyRepository(true)->findOrFail('1e8f8bb7-0111-450a-3f05-56d4e3911bb9');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByOrFailRequestWithId(): void
    {
        $response = $this->policyRepository(true)->findByOrFail('id', '1e8f8bb7-0111-450a-3f05-56d4e3911bb9');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByOrFailRequestWithUuid(): void
    {
        $response = $this->policyRepository(true)->findByOrFail('uuid', '0ead0ce3-1651-446e-9935-e558ad766eac');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindByManyOrFailRequest(): void
    {
        $response = $this->policyRepository(true)->findByManyOrFail(['id', 'uuid'], '0ead0ce3-1651-446e-9935-e558ad766eac');
        $this->assertEquals(
            $this->exceptDates($this->createPolicyEntityFromArray(Arr::first($this->policyEntries))),
            $this->exceptDates($response)
        );
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindOrFailRequest(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->policyRepository(true)->findOrFail('1e8f8bb7-0111-450a-3f05-56d4e3911bb8');
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindByOrFailRequestWithId(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->policyRepository(true)->findByOrFail('id', '1e8f8bb7-0111-450a-3f05-56d4e3911bb8');
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindByOrFailRequestWithUuid(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->policyRepository(true)->findByOrFail('uuid', '0ead0ce3-1651-446e-9935-e558ad766cas');
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindByManyOrFailRequest(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->policyRepository(true)->findByManyOrFail(['id', 'uuid'], '0ead0ce3-1651-446e-9935-e558ad766cas');
    }


//    public function testShouldPassIfCanDeleteExistingEntity(): void {
//        $response = $this->policyRepository(withData: true, mock: true)->delete('1e8f8bb7-0111-450a-3f05-56d4e3911bb9', false);
//        $this->assertTrue($response);
//    }

    /**
     * Create array without dates from entity
     *
     * @param array|ACLPolicyEntity|Collection $entity
     * @param bool                            $nested
     *
     * @return array
     */
    private function exceptDates(array|ACLPolicyEntity|Collection $entity, bool $nested = false): array
    {
        if (!is_array($entity)) {
            $entity = $entity->toArray();
        }

        if ($nested) {
            $data = [];
            foreach ($entity as $index => $value) {
                $data[$index] = Arr::except($value, [
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]);
            }
            return $data;
        }

        return Arr::except($entity, [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}
