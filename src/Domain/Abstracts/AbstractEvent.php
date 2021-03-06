<?php

namespace ConsulConfigManager\Consul\Domain\Abstracts;

use Illuminate\Support\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use ConsulConfigManager\Users\Interfaces\UserInterface;

/**
 * Class AbstractEvent
 *
 * @package ConsulConfigManager\Consul\Domain\Abstracts
 */
abstract class AbstractEvent extends ShouldBeStored
{
    /**
     * Timestamp of when event occurred
     * @var int
     */
    protected int $dateTime = 0;

    /**
     * Reference for user who triggered event
     * @var UserInterface|null
     */
    protected ?UserInterface $user = null;

    /**
     * AbstractEvent Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateTime = time();
    }

    /**
     * Get event occurrence timestamp
     * @return int
     */
    public function getDateTime(): int
    {
        if (property_exists($this, 'dateTime') && $this->dateTime !== 0) {
            return $this->dateTime;
        }
        return time();
    }

    /**
     * Set event occurrence time
     * @param Carbon|int $dateTime
     *
     * @return $this
     */
    public function setDateTime(Carbon|int $dateTime): AbstractEvent
    {
        $this->dateTime = is_int($dateTime) ? $dateTime : $dateTime->getTimestamp();
        return $this;
    }

    /**
     * Get user who triggered event
     * @return int
     */
    public function getUser(): int
    {
        if (property_exists($this, 'user') && $this->user !== null) {
            return $this->user->getID();
        }
        return $this->retrieveUserID();
    }

    /**
     * Set user
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user): AbstractEvent
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Retrieve user id to store 'who created' data
     * @return int
     */
    protected function retrieveUserID(): int
    {
        $request = request();
        if ($request !== null) {
            /**
             * @var UserInterface $user
             */
            $user = $request->user();
            if ($user !== null) {
                return $user->getID();
            }
        }
        return 0;
    }
}
