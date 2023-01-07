<?php
declare (strict_types=1);

namespace App\Table;

class TableOptionGenerator
{

    public static function generateMany($options, $identifier): array
    {
        $htmlOptions = [];

        foreach ($options as $option)
        {
            $htmlOptions[] = new TableOption($option,$identifier);
        }

        return $htmlOptions;
    }
}