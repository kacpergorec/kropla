<?php
declare (strict_types=1);

namespace App\Table\Option;

class TableOptionGenerator
{

    public static function generateMany($options, $identifier): TableOptionCollection
    {
        $optionColection = new TableOptionCollection();

        foreach ($options as $option)
        {
            $optionColection->add(new TableOption($option,$identifier));
        }

        return $optionColection;
    }
}