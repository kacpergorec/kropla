<?php
declare (strict_types=1);

namespace App\Admin\Metadata;

class AdminMetadata
{

    public function __construct(
        private string $label,
        private int $order = 10,
        private string $iconClass = '',
        private string $description = '',
        private array $customProperties = [],
    )
    {
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getIconClass(): string
    {
        return $this->iconClass;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getCustomProperties(): array
    {
        return $this->customProperties;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->getLabel();
    }

}