<?php
declare (strict_types=1);

namespace App\Table\Option;

use Doctrine\Common\Collections\ArrayCollection;

class TableOptionCollection extends ArrayCollection
{

    public function add(mixed $element)
    {
        if (!$element instanceof TableOption) {
            $elementType = ucfirst(gettype($element));
            throw new \InvalidArgumentException("TableOptionCollection only accepts TableOption instances. {$elementType} given.");
        }
        parent::add($element);
    }

}