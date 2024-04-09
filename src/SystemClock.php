<?php

declare(strict_types=1);

/**
 * This file is part of Esi\Clock.
 *
 * (c) Eric Sizemore <admin@secondversion.com>
 *
 * This source file is subject to the MIT license. For the full copyright and
 * license information, please view the LICENSE file that was distributed with
 * this source code.
 */

namespace Esi\Clock;

use function date_default_timezone_get;
use function sprintf;

/**
 * A clock that relies on system time.
 *
 * @immutable
 */
final class SystemClock implements ClockInterface
{
    private readonly \DateTimeZone $timezone;

    /**
     * @throws \DateInvalidTimeZoneException If $timezone is passed as string and is invalid.
     */
    public function __construct(\DateTimeZone | string | null $timezone = null)
    {
        if ($timezone === null || $timezone === '') {
            $timezone = new \DateTimeZone('UTC');
        }

        if (\is_string($timezone)) {
            try {
                $timezone = new \DateTimeZone($timezone);
            } catch (\Throwable $throwable) { // \Exception < PHP 8.3, \DateInvalidTimeZoneException >= PHP 8.3
                throw new \DateInvalidTimeZoneException($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
            }
        }

        $this->timezone = $timezone;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf(
            '[SystemClock("%s"): unixtime: %s; iso8601: %s;]',
            $this->timezone->getName(),
            $this->now()->format('U'),
            $this->now()->format(\DateTimeInterface::ISO8601_EXPANDED)
        );
    }

    /**
     * Create a FrozenClock from the current SystemClock now.
     */
    public function freeze(): FrozenClock
    {
        return new FrozenClock($this->now());
    }

    /**
     * @inheritDoc
     */
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', $this->timezone);
    }

    /**
     * Returns a new SystemClock at current system time using the system's timezone.
     */
    public static function fromSystemTimezone(): static
    {
        return new static(new \DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @inheritDoc
     */
    public static function fromUtc(): static
    {
        return new static(new \DateTimeZone('UTC'));
    }
}
