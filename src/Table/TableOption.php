<?php
declare (strict_types=1);

namespace App\Table;

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
        return "<a href='{$this->optionType}/{$this->identifier}' class='table-option table-option--{$this->optionType}'>{$this->optionType}</a>";
    }

}