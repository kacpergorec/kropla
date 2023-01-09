<?php
declare (strict_types=1);

namespace App\Table\Cell;

use DateTime;
use DateTimeZone;
use IntlDateFormatter;

class ObjectCell
{
    public static function render(object $object): string
    {

        if ($object instanceof DateTime) {
            return IntlDateFormatter::formatObject($object, [IntlDateFormatter::RELATIVE_MEDIUM, IntlDateFormatter::NONE], 'pl');
        }

        return (string)$object;
    }
}