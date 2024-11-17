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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/**
 * A clock frozen in time.
 */
final class FrozenClock implements ClockInterface
{
    public function __construct(private DateTimeImmutable $now) {}

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return \sprintf(
            '[FrozenClock(): unixtime: %s; iso8601: %s;]',
            $this->now()->format('U'),
            $this->now()->format(DateTimeInterface::ISO8601_EXPANDED)
        );
    }

    /**
     * Adjusts the FrozenClock time based on a given modifier.
     *
     * @see https://www.php.net/manual/en/datetime.formats.php
     * @see https://www.php.net/manual/en/class.datemalformedstringexception.php
     *
     * @psalm-suppress PossiblyFalsePropertyAssignmentValue
     */
    public function adjustTo(string $withModifier): void
    {
        $this->now = $this->now->modify($withModifier);
    }

    /**
     * @inheritDoc
     */
    public function now(): DateTimeImmutable
    {
        return $this->now;
    }

    /**
     * Sets the FrozenClock to a specific time.
     */
    public function setTo(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    /**
     * @inheritDoc
     *
     * @throws \DateMalformedStringException
     */
    public static function fromUtc(): FrozenClock
    {
        return new FrozenClock(
            new DateTimeImmutable('now', new DateTimeZone('UTC'))
        );
    }
}
