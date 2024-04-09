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

use Psr\Clock\ClockInterface as PsrClockInterface;

interface ClockInterface extends PsrClockInterface, \Stringable
{
    /**
     * String representation of current clock.
     */
    public function __toString(): string;

    public function now(): \DateTimeImmutable;

    /**
     * Returns a new *Clock at current system time in UTC.
     */
    public static function fromUtc(): ClockInterface;
}
