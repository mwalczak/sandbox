<?php
declare(strict_types=1);

class DayMonthYear extends MonthYear implements DayMonthYearInterface
{
    private int $day;


    public function __construct(int $day, int $month, int $year)
    {
        parent::__construct($month, $year);
        $this->day = $day;
    }

    public static function createFromDateTime(\DateTime $dateTime): self
    {
        return new self(
            (int) $dateTime->format('d'),
            (int) $dateTime->format('m'),
            (int) $dateTime->format('Y')
        );
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getAsArray(): array
    {
        return parent::getAsArray() + [
            'day' => $this->day,
        ];
    }
}
