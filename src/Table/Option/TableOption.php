<?php
declare (strict_types=1);

namespace App\Table\Option;

class TableOption
{

    public function __construct(
        private string $optionType,
        private int $identifier
    )
    {
    }

    public function anchor(): string
    {
        return "<a href='{$this->identifier}/{$this->optionType}' class='table-option table-option--{$this->optionType}'>{$this->optionType}</a>";
    }

}