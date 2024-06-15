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

namespace Esi\Clock\Tests;

use DateInvalidTimeZoneException;
use DateTimeImmutable;
use DateTimeZone;
use Esi\Clock\FrozenClock;
use Esi\Clock\SystemClock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function date_default_timezone_get;

/**
 * @internal
 */
#[CoversClass(SystemClock::class)]
#[UsesClass(FrozenClock::class)]
final class SystemClockTest extends TestCase
{
    public function testClockAsStringShouldReturnStringMatchingFormat(): void
    {
        $timezone = new DateTimeZone('America/New_York');
        $clock    = new SystemClock($timezone);

        self::assertStringMatchesFormat('[SystemClock("%s"): unixtime: %s; iso8601: %s;]', (string) $clock);
    }

    public function testConstructUsesUtcIfPassedEmptyStringTimezone(): void
    {
        $clock = new SystemClock('');
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }

    public function testConstructUsesUtcIfPassedNullTimezone(): void
    {
        $clock = new SystemClock(null);
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }

    public function testConstructWithTimezoneString(): void
    {
        $clock = new SystemClock('America/New_York');
        $now   = $clock->now();

        self::assertSame('America/New_York', $now->getTimezone()->getName());
    }

    public function testDoesThrowException(): void
    {
        $this->expectException(DateInvalidTimeZoneException::class);
        new SystemClock('invalid/zone');
    }

    public function testFreezeReturnsFrozenClockAndReturnsSameObject(): void
    {
        $timezone = new DateTimeZone('America/New_York');
        $clock    = new SystemClock($timezone);

        $before      = new DateTimeImmutable('now', $timezone);
        $frozenClock = $clock->freeze();
        $after       = new DateTimeImmutable('now', $timezone);

        // @phpstan-ignore-next-line
        self::assertInstanceOf(FrozenClock::class, $frozenClock);

        $now = $frozenClock->now();

        self::assertGreaterThanOrEqual($before, $now);
        self::assertLessThanOrEqual($after, $now);

        self::assertSame($now, $frozenClock->now());
    }

    public function testFromSystemTimezoneCreatesAnInstanceUsingTheDefaultTimezoneInSystem(): void
    {
        $clock = SystemClock::fromSystemTimezone();
        $now   = $clock->now();

        self::assertSame(date_default_timezone_get(), $now->getTimezone()->getName());
    }

    public function testFromUtcCreatesAnInstanceUsingUtcAsTimezone(): void
    {
        $clock = SystemClock::fromUtc();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }

    public function testNowShouldRespectTheProvidedTimezone(): void
    {
        $timezone = new DateTimeZone('America/New_York');
        $clock    = new SystemClock($timezone);

        $before = new DateTimeImmutable('now', $timezone);
        $now    = $clock->now();
        $after  = new DateTimeImmutable('now', $timezone);

        self::assertEquals($timezone, $now->getTimezone());
        self::assertSame('America/New_York', $now->getTimezone()->getName());
        self::assertGreaterThanOrEqual($before, $now);
        self::assertLessThanOrEqual($after, $now);
    }
}
