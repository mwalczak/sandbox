<?php
declare(strict_types=1);

class Time extends \DateTime implements DayMonthYearInterface
{
    private const MAX_HOUR = 23;
    private const MAX_MINUTE = 59;
    private const MAX_SECOND = 59;
    private const MAX_MICROSECOND = 999999;
    private const ONE_MILLION = 1000 * 1000;
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';


    public function __construct($time = 'now')
    {
        if (is_numeric($time)) {
            parent::__construct();
            $this->setMicroTimestamp((float) $time);
        } else if (is_string($time)) {
            parent::__construct($time);
        } else if ($time instanceof \DateTime) {
            parent::__construct();
            $this->setTimestamp($time->getTimestamp());
            $this->setMicrosecond((int) $time->format('u'));
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid type "%s" passed to %s class', gettype($time), get_class($this)));
        }
    }

    public static function create($time = 'now'): self
    {
        return new self($time);
    }

    public static function now(): self
    {
        return new self;
    }

    public static function unixEpoch(): self
    {
        return new self(0.0);
    }

    /*
     * Get
     */

    public function getMicroTimestamp(): float
    {
        return (float) ($this->getTimestamp() + ($this->getMicrosecond() / static::ONE_MILLION));
    }

    public function getMicrosecond(): int
    {
        return (int) $this->format('u');
    }

    public function getSecond(): int
    {
        return (int) $this->format('s');
    }

    public function getMinute(): int
    {
        return (int) $this->format('i');
    }

    public function getHour(): int
    {
        return (int) $this->format('H');
    }

    public function getDay(): int
    {
        return (int) $this->format('d');
    }

    public function getMonth(): int
    {
        return (int) $this->format('m');
    }

    public function getYear(): int
    {
        return (int) $this->format('Y');
    }

    public function getMonthYear(): MonthYearInterface
    {
        return new MonthYear($this->getMonth(), $this->getYear());
    }

    public function getNumberOfDaysInMonth(): int
    {
        return cal_days_in_month(CAL_GREGORIAN, $this->getMonth(), $this->getYear());
    }

    public function getModified($modifier): self
    {
        return (clone $this)->modify($modifier);
    }

    public function getNextDay(): self
    {
        return $this->getModified('+1 day');
    }

    public function getPreviousDay(): self
    {
        return $this->getModified('-1 day');
    }

    public function getStartOfDay(): self
    {
        return (clone $this)->setTime(0, 0, 0, 0);
    }

    public function getEndOfDay(): self
    {
        return (clone $this)->setTime(self::MAX_HOUR, self::MAX_MINUTE, self::MAX_SECOND, self::MAX_MICROSECOND);
    }

    public function getStartOfNextMonth(): self
    {
        return $this->getModified('first day of next month')->getStartOfDay();
    }

    public function getEndOfNextMonth(): self
    {
        return $this->getModified('last day of next month')->getEndOfDay();
    }

    public function getStartOfPreviousMonth(): self
    {
        return $this->getModified('first day of previous month')->getStartOfDay();
    }

    public function getEndOfPreviousMonth(): self
    {
        return $this->getModified('last day of previous month')->getEndOfDay();
    }

    public function getStartOfMonth(): self
    {
        return $this->getModified('first day of this month')->getStartOfDay();
    }

    public function getEndOfMonth(): self
    {
        return $this->getModified('last day of this month')->getEndOfDay();
    }

    public function getFormatted(string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return $this->format($format);
    }

    public static function timezone(): string
    {
        return self::now()->getTimezone()->getName();
    }

    /*
     * Is
     */

    public function isToday(): bool
    {
        return $this == self::createStartOfToday();
    }

    public function isPastMonth(): bool
    {
        return $this->getMonth() < self::createStartOfToday()->getMonth();
    }

    public function isCurrentMonth(): bool
    {
        return $this->getStartOfMonth() == self::createStartOfCurrentMonth();
    }

    public function isFutureMonth(): bool
    {
        return $this->getStartOfMonth() > self::createStartOfCurrentMonth();
    }

    public function isFutureMonthAlt(): bool
    {
        return $this->format('Ym') > date('Ym');
    }

    public function isMonthYear(MonthYearInterface $monthYear): bool
    {
        return
            $this->getMonth() === $monthYear->getMonth() &&
            $this->getYear() === $monthYear->getYear()
        ;
    }

    /*
     * Create
     */

    public static function createDay(int $day, int $month, int $year): self
    {
        return self::now()->setDate($year, $month, $day);
    }

    public static function createMonth(int $month, int $year): self
    {
        return self::now()->setDate($year, $month, 1);
    }

    public static function createFromMonthYear(MonthYearInterface $monthYear): self
    {
        return self::createMonth(
            $monthYear->getMonth(),
            $monthYear->getYear()
        );
    }

    public static function createFromDayMonthYear(DayMonthYearInterface $dayMonthYear): self
    {
        return self::createDay(
            $dayMonthYear->getDay(),
            $dayMonthYear->getMonth(),
            $dayMonthYear->getYear()
        );
    }

    public static function createStartOfToday(): self
    {
        return self::now()->getStartOfDay();
    }

    public static function createEndOfToday(): self
    {
        return self::now()->getEndOfDay();
    }

    public static function createStartOfCurrentMonth(): self
    {
        return self::now()->getStartOfMonth();
    }

    public static function createEndOfCurrentMonth(): self
    {
        return self::now()->getEndOfMonth();
    }

    /*
     * Set
     */

    public function setMicroTimestamp(float $microTimestamp): self
    {
        $timestamp = (int) $microTimestamp;
        $this->setTimestamp($timestamp);
        $this->setMicrosecond((int) round(($microTimestamp - $timestamp) * static::ONE_MILLION));

        return $this;
    }

    public function setMicrosecond(int $microseconds): self
    {
        $this->setTime(
            $this->getHour(),
            $this->getMinute(),
            $this->getSecond(),
            $microseconds
        );
        return $this;
    }

    public function __toString(): string
    {
        return $this->getFormatted();
    }
}
