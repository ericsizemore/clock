# Usage

Make your objects depend on the `Esi\Clock\ClockInterface` interface.
You can then use `SystemClock` to retrieve the current time or `FrozenClock` to retrieve a specific time.

For example:

```php
<?php

declare(strict_types=1);

use Esi\Clock\ClockInterface;
use Esi\Clock\FrozenClock;
use Esi\Clock\SystemClock;

class MyCoolObject
{
    public function __construct(private ClockInterface $clock) {}

    public function getCurrentTime(): \DateTimeImmutable
    {
        return $this->clock->now();
    }

    public function freezeTime(): FrozenClock
    {
        if ($this->clock instanceof SystemClock) {
            return $this->clock->freeze();
        }

        return $this->clock->now();
    }
    // ...
}
```

```php
<?php

declare(strict_types=1);

use Esi\Clock\SystemClock;
// ...
// ...

$clock = new MyCoolObject(new SystemClock('America/New_York'));
\var_dump($clock->getCurrentTime());
/*
class DateTimeImmutable#6 (3) {
  public $date =>
  string(26) "2024-04-10 13:46:30.724222"
  public $timezone_type =>
  int(3)
  public $timezone =>
  string(16) "America/New_York"
}
*/

$frozenClock = $clock->freezeTime();
$now = $frozenClock->now();

\var_dump($now);
/*
class DateTimeImmutable#7 (3) {
  public $date =>
  string(26) "2024-04-10 13:46:30.727716"
  public $timezone_type =>
  int(3)
  public $timezone =>
  string(16) "America/New_York"
}
*/

\sleep(5);

$stillNow = $frozenClock->now();
\var_dump($stillNow);
/*
class DateTimeImmutable#7 (3) {
  public $date =>
  string(26) "2024-04-10 13:46:30.727716"
  public $timezone_type =>
  int(3)
  public $timezone =>
  string(16) "America/New_York"
}
*/
```

## `SystemClock`

Object that will return the current time based on the given timezone. The timezone passed to the constructor of `SystemClock` can either be a 
string of the timezone identifier, or a [`DateTimeZone`](https://www.php.net/datetimezone) object.

Create a new system clock:

```php
<?php

declare(strict_types=1);

use Esi\Clock\SystemClock;

/**
 * You can either create your own \DateTimeZone object to pass to the SystemClock, or
 * you can pass the timezone string. E.g.:
 * 
 * @see https://www.php.net/datetimezone
 *
 * $clock = new SystemClock('America/New_York');
 */
$timezone = new \DateTimeZone('America/New_York');
$clock = new SystemClock($timezone);

$now = $clock->now();

/**
 * You can also make use of either `fromUtc()` or `fromSystemTimezone()`
 */
// Create a clock using UTC
$clock = SystemClock::fromUtc();
$now = $clock->now();

// Or the default system timezone
$clock = SystemClock::fromSystemTimezone();
$now = $clock->now();
```

## `FrozenClock`

Test object that always returns a fixed time object. When creating a `FrozenClock`, it must be passed a `\DateTimeImmutable` object in its constructor.
See `DateTimeImmutable` at [php.net](https://www.php.net/DateTimeImmutable).

When creating the `DateTimeImmutable` object to pass into `FrozenClock`, if instantiated with no arguments it uses `now` to create the object with the current time. 
You can also pass a date/time string to set the `FrozenClock` to a specific time.

You can use `DateTimeImmutable` directly, or:

* [`DateTimeImmutable::createFromFormat`](https://www.php.net/manual/en/datetimeimmutable.createfromformat.php)
* [`DateTimeImmutable::createFromInterface`](https://www.php.net/manual/en/datetimeimmutable.createfrominterface.php) - if using an object that implements `DateTimeInterface`, such as `DateTime`.

Create a new frozen clock:

```php
<?php

declare(strict_types=1);

use Esi\Clock\FrozenClock;

$now = new \DateTimeImmutable();
$clock = new FrozenClock($now);

\sleep(5);

$stillNow = $clock->now();
```

You can also set the frozen clock to a new time by using it's `setTo()` method, which also requires a `DateTimeImmutable` object:

```php
<?php

declare(strict_types=1);

use Esi\Clock\FrozenClock;

$clock = new FrozenClock(new \DateTimeImmutable());
$now = $clock->now();

$clock->setTo(new \DateTimeImmutable('+3 hours'));
$newNow = $clock->now();
```

Or make use of the `adjustTo()` method which requires a valid date/time string to be passed.
Note: On PHP 8.3+, an invalid string will result in a [DateMalformedStringException](https://www.php.net/manual/en/class.datemalformedstringexception.php) being thrown, otherwise it is an error.

```php
<?php

declare(strict_types=1);

use Esi\Clock\FrozenClock;

$clock = new FrozenClock(new \DateTimeImmutable());
$now = $clock->now();

$clock->adjustTo('+3 hours');
$newNow = $clock->now();
```

You can also create a new frozen clock by freezing a system clock:

```php
<?php

declare(strict_types=1);

use Esi\Clock\SystemClock;

$timezone = new \DateTimeZone('America/New_York');
$clock = new SystemClock($timezone);

$frozenClock = $clock->freeze();

$now = $clock->now();

\sleep(5);

$stillNow = $clock->now();
```
