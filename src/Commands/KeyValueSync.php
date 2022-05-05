<?php

namespace ConsulConfigManager\Consul\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Users\Domain\Interfaces\UserRepository;
use ConsulConfigManager\Consul\Interfaces\Services\KeyValueServiceInterface;
use ConsulConfigManager\Consul\Domain\KeyValue\Repositories\KeyValueRepositoryInterface;

/**
 * Class KeyValueSync
 * @package ConsulConfigManager\Consul\Commands
 */
class KeyValueSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consul:kv:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize KV storage with Consul';

    /**
     * Key Value repository instance
     * @var KeyValueRepositoryInterface
     */
    private KeyValueRepositoryInterface $repository;

    /**
     * Key Value service instance
     * @var KeyValueServiceInterface
     */
    private KeyValueServiceInterface $service;

    /**
     * KVTest constructor.
     * @param UserRepository $userRepository
     * @param KeyValueRepositoryInterface $repository
     * @param KeyValueServiceInterface $service
     * @return void
     */
    public function __construct(KeyValueRepositoryInterface $repository, KeyValueServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute console command.
     * @return int
     * @throws RequestException
     */
    public function handle(): int
    {
        $this->info('Fetching list of keys from Consul server...');

        $keysList = array_values(array_filter($this->service->getKeysList(''), function (string $key): bool {
            return !Str::endsWith($key, '/');
        }));
        $keysCount = \count($keysList);
        $this->info('There are total of ' . $keysCount . ' key(s) registered with Consul server');

        $keyValueStorage = $this->retrieveKeys($keysList, $keysCount);
        $this->storeKeys($keyValueStorage);

        return 0;
    }

    /**
     * Retrieve data for kets from Consul Server
     * @param array $keysList
     * @param int $keysCount
     * @return array
     * @throws RequestException
     */
    private function retrieveKeys(array $keysList, int $keysCount): array
    {
        $keyValueStorage = [];
        $this->info('Retrieving values for ' . $keysCount . ' key(s)...');
        $progress = $this->output->createProgressBar($keysCount);
        $progress->start();

        foreach ($keysList as $key) {
            $keyValueStorage[$key] = $this->service->getKeyValue($key);
            $progress->advance();
        }

        $progress->finish();
        $this->newLine(2);
        $this->info('Successfully retrieve values for ' . $keysCount . ' key(s)');

        return $keyValueStorage;
    }

    /**
     * Store retrieved keys in the database
     * @param array $keyValueStorage
     * @return void
     */
    private function storeKeys(array $keyValueStorage)
    {
        $this->newLine(2);
        foreach ($keyValueStorage as $key => $value) {
            $key = trim($key);
            $model = $this->repository->find($key);
            if ($model === null) {
                $this->repository->create($key, $value);
                $this->info(sprintf('%s - created', $key));
            } else {
                if ($model->value !== $value) {
                    $this->repository->update($key, $value);
                    $this->info(sprintf('%s - updated', $key));
                } else {
                    $this->info(sprintf('%s - not changed', $key));
                }
            }
        }
    }
}
