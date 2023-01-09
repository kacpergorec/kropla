<?php
declare (strict_types=1);

namespace App\Table\Option;

class TableOption
{
    public const EDIT = 'edit';
    public const DETAILS = 'details';
    public const DELETE = 'delete';

    public const DEFAULT = [self::DETAILS, self::EDIT, self::DELETE];

    public function __construct(
        private string $optionType,
        private int    $identifier
    )
    {
    }

    public function anchor(): string
    {
        $href = "{$this->identifier}/{$this->optionType}";
        $class = "table-options__option table-options__option--{$this->optionType}";
        $label = ucfirst((string)$this->optionType);
//        $iconHtml = "<i class='table-options__icon table-options__icon--$label'></i>";

        return "<a href='$href' class='$class' aria-label='$label'>$label</a>";
    }

}