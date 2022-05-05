<?php

namespace ConsulConfigManager\Consul\Domain\Service\Interfaces;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;

/**
 * Interface ServiceEntity
 * @package ConsulConfigManager\Consul\Domain\Service\Interfaces
 */
interface ServiceEntity extends Arrayable, ArrayAccess, HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    /**
     * Get entity id
     * @return int
     */
    public function getId(): int;

    /**
     * Set entity id
     * @param int $id
     * @return $this
     */
    public function setID(int $id): self;

    /**
     * Get entry uuid
     * @return string
     */
    public function getUuid(): string;

    /**
     * Set entry uuid
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): self;

    /**
     * Get entity identifier
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Set entity identifier
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier(string $identifier): self;

    /**
     * Get entity service
     * @return string
     */
    public function getService(): string;

    /**
     * Set entity service
     * @param string $service
     * @return $this
     */
    public function setService(string $service): self;

    /**
     * Get entity address
     * @return string
     */
    public function getAddress(): string;

    /**
     * Set entity address
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self;

    /**
     * Get entity port
     * @return int
     */
    public function getPort(): int;

    /**
     * Set entity port
     * @param int $port
     * @return $this
     */
    public function setPort(int $port): self;

    /**
     * Get entity datacenter
     * @return string
     */
    public function getDatacenter(): string;

    /**
     * Set entity datacenter
     * @param string $datacenter
     * @return $this
     */
    public function setDatacenter(string $datacenter): self;

    /**
     * Get entity tags
     * @return array
     */
    public function getTags(): array;

    /**
     * Set entity tags
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags): self;

    /**
     * Get entity meta
     * @return array
     */
    public function getMeta(): array;

    /**
     * Set entity meta
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta): self;

    /**
     * Get entity online status
     * @return bool
     */
    public function isOnline(): bool;

    /**
     * Set entity online status
     * @param bool $online
     * @return $this
     */
    public function setOnline(bool $online): self;

    /**
     * Get entity environment
     * @return string
     */
    public function getEnvironment(): string;

    /**
     * Set entity environment
     * @param string $environment
     * @return $this
     */
    public function setEnvironment(string $environment): self;
}
