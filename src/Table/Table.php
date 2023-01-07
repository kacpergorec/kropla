<?php
declare (strict_types=1);

namespace App\Table;

/**
 * Class representing an HTML table.
 */
class Table
{
    public const OPTION_EDIT = 'edit';
    public const OPTION_SHOW = 'show';
    public const OPTION_DELETE = 'delete';

    public const OPTIONS_DEFAULT = [self::OPTION_SHOW, self::OPTION_EDIT, self::OPTION_DELETE];

    public function __construct(
        private array $headers,
        private array $data,
        private bool  $vertical
    )
    {
    }

    /**
     * Get the table headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the table data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the vertical flag.
     *
     * @return bool
     */
    public function isVertical(): bool
    {
        return $this->vertical;
    }
}
