<?php
declare(strict_types=1);

interface DayMonthYearInterface extends MonthYearInterface
{
    function getDay(): int;
}
