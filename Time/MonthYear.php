<?php
declare(strict_types=1);

class MonthYear implements MonthYearInterface, ArrayableInterface
{
    private int $month;

    private int $year;


    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public static function createFromDateTime(\DateTime $dateTime): self
    {
        return new self(
            (int) $dateTime->format('m'),
            (int) $dateTime->format('Y')
        );
    }

    public static function createPreviousMonth(): self
    {
        return self::createFromDateTime(new \DateTime('-1 month'));
    }

    public static function createCurrentMonth(): self
    {
        return self::createFromDateTime(new \DateTime());
    }

    public static function createFromMicroTimestamp(float $timestamp)
    {
        return self::createFromDateTime(new Time($timestamp));
    }

    public function isCurrentMonth(): bool
    {
        return $this == self::createCurrentMonth();
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonthYear(): MonthYearInterface
    {
        return new MonthYear($this->month, $this->year);
    }

    public function getDayMonthYears(): DayMonthYearCollection
    {
        $dayMonthYearCollection = new DayMonthYearCollection;

        $numberOfDays = Time::createFromMonthYear($this)->getNumberOfDaysInMonth();
        foreach (range(1, $numberOfDays) as $day) {
            $dayMonthYearCollection->add(new DayMonthYear($day, $this->getMonth(), $this->getYear()));
        }

        return $dayMonthYearCollection;
    }

    public function getAsArray(): array
    {
        return [
            'month' => $this->month,
            'year' => $this->year
        ];
    }
}
