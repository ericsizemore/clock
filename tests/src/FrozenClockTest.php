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

use DateMalformedStringException;
use DateTimeImmutable;
use Esi\Clock\FrozenClock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(FrozenClock::class)]
final class FrozenClockTest extends TestCase
{
    public function testAdjustToChangesTheObject(): void
    {
        $oldNow = new DateTimeImmutable();
        $newNow = $oldNow->modify('+7 days');

        $clock = new FrozenClock($oldNow);
        $clock->adjustTo('+7 days');

        self::assertNotEquals($oldNow, $clock->now());
        self::assertEquals($newNow, $clock->now());

        $clock->adjustTo('-7 days');

        self::assertEquals($oldNow, $clock->now());
        self::assertNotEquals($newNow, $clock->now());
    }

    #[RequiresPhp('8.3')]
    public function testAdjustToThrowsForInvalidModifier(): void
    {
        $clock = FrozenClock::fromUtc();

        $this->expectException(DateMalformedStringException::class);
        $clock->adjustTo('notValid');
    }

    public function testClockAsStringShouldReturnStringMatchingFormat(): void
    {
        $clock = FrozenClock::fromUtc();

        self::assertStringMatchesFormat('[FrozenClock(): unixtime: %s; iso8601: %s;]', (string) $clock);
    }

    public function testFromUtcCreatesClockFrozenAtCurrentSystemTimeInUtc(): void
    {
        $clock = FrozenClock::fromUtc();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }

    public function testNowShouldAlwaysReturnTheSameObject(): void
    {
        $now   = new DateTimeImmutable();
        $clock = new FrozenClock($now);

        self::assertSame($now, $clock->now());
        self::assertSame($now, $clock->now());
    }

    public function testSetToChangesTheObject(): void
    {
        $oldNow = new DateTimeImmutable();
        $clock  = new FrozenClock($oldNow);

        $newNow = new DateTimeImmutable();
        $clock->setTo($newNow);

        self::assertNotSame($oldNow, $clock->now());
        self::assertSame($newNow, $clock->now());
    }
}
