<?php
declare (strict_types=1);

namespace App\Table\Cell;

use App\Table\Option\TableOptionCollection;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Twig\Environment;

class ObjectCell
{
    public static function render(object $object, Environment $twig): string
    {

        if ($object instanceof DateTime) {
            return IntlDateFormatter::formatObject($object, [IntlDateFormatter::RELATIVE_MEDIUM, IntlDateFormatter::NONE], 'pl');
        }

        if ($object instanceof TableOptionCollection) {
            return $twig->render('admin/components/table/options/options.html.twig',[
                'options' => $object
            ]);
        }

        return (string)$object;
    }
}