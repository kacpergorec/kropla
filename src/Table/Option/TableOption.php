<?php
declare (strict_types=1);

namespace App\Table\Option;

use Twig\Environment;

class TableOption
{
    public const EDIT = 'edit';
    public const DETAILS = 'details';
    public const DELETE = 'delete';

    public const DEFAULT = [self::DETAILS, self::EDIT, self::DELETE];

    public function __construct(
        private readonly string $type,
        private readonly int    $identifier,
    )
    {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->identifier;
    }

}