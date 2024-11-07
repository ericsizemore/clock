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

use DateInvalidTimeZoneException;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Throwable;

use function date_default_timezone_get;

/**
 * A clock that relies on system time.
 *
 * @immutable
 */
final readonly class SystemClock implements ClockInterface
{
    private DateTimeZone $timezone;

    /**
     * @throws DateInvalidTimeZoneException If $timezone is passed as string and is invalid.
     */
    public function __construct(null|DateTimeZone|string $timezone = null)
    {
        if (!$timezone instanceof DateTimeZone) {
            $timezone ??= 'UTC';

            try {
                $this->timezone = new DateTimeZone($timezone === '' ? 'UTC' : $timezone);
                // \Exception < PHP 8.3, \DateInvalidTimeZoneException >= PHP 8.3
                // DateInvalidTimeZoneException is polyfilled via symfony/polyfill-php83
            } catch (Throwable $throwable) {
                throw new DateInvalidTimeZoneException($throwable->getMessage(), \intval($throwable->getCode()), $throwable);
            }

            return;
        }

        $this->timezone = $timezone;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return \sprintf(
            '[SystemClock("%s"): unixtime: %s; iso8601: %s;]',
            $this->timezone->getName(),
            $this->now()->format('U'),
            $this->now()->format(DateTimeInterface::ISO8601_EXPANDED)
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
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }

    /**
     * Returns a new SystemClock at current system time using the system's timezone.
     *
     * @throws DateInvalidTimeZoneException
     */
    public static function fromSystemTimezone(): SystemClock
    {
        return new self(new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @inheritDoc
     */
    public static function fromUtc(): SystemClock
    {
        return new SystemClock(new DateTimeZone('UTC'));
    }
}
