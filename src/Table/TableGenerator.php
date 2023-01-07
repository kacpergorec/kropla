<?php
declare (strict_types=1);

namespace App\Table;

use InvalidArgumentException;

/**
 * Service for generating HTML tables.
 */
class TableGenerator
{
    private array $tableData = [];

    private array $tableHeaders = [];

    private bool $vertical = false;

    /**
     * Add a row of data to the table.
     *
     * @param array    $rowData
     * @param int|null $rowId
     * @return TableGenerator
     */
    public function addRow(array $rowData, ?int $rowId = null): self
    {
        $this->validateEqualColumns($rowData);

        if ($rowId) {
            $this->tableData[$rowId] = $rowData;
        }else{
            $this->tableData[] = $rowData;
        }

        return $this;
    }

    /**
     * Add multiple rows of data to the table.
     *
     * @param array $rowsData
     * @return TableGenerator
     */
    public function addRows(array $rowsData): self
    {
        foreach ($rowsData as $rowData) {
            $this->addRow($rowData);
        }

        return $this;
    }

    /**
     * Add a header to the table.
     *
     * @param string $header
     * @return TableGenerator
     */
    public function addHeader(string $header): self
    {
        $this->tableHeaders[] = $header;

        return $this;
    }

    /**
     * Add multiple headers to the table.
     *
     * @param array $headers
     * @return TableGenerator
     */
    public function addHeaders(array $headers): self
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
        return $this;
    }

    /**
     * Add rows and headers to the table based on the properties of an array of objects.
     *
     * @param array $entities
     * @param array $includedProperties
     * @return TableGenerator
     */
    public function addEntities(array $entities, array $includedProperties = []): self
    {
        if (empty($entities)) {
            return $this;
        }

        $this->addHeaders(array_map(fn($property) => ucfirst($property), $includedProperties));

        $firstEntity = reset($entities);

        if (empty($includedProperties)) {
            $methods = get_class_methods($firstEntity);
            $tableGetters = array_filter($methods, fn($getter) => str_starts_with($getter, 'get'));
        } else {
            $tableGetters = array_map(fn($property) => 'get' . ucfirst($property), $includedProperties);
        }

        foreach ($entities as $entity) {
            $this->addRow(array_map(static function ($getter) use ($entity) {
                return $entity->$getter();
            }, $tableGetters), $entity->getId());
        }

        return $this;
    }

    /**
     * Set the table to be displayed in a vertical layout.
     *
     * @param bool $vertical
     * @return TableGenerator
     */
    public function setVertical(bool $vertical): self
    {
        $this->vertical = $vertical;

        return $this;
    }

    /**
     * Validate that the number of cells in a row is equal to the number of header cells in the table.
     *
     * @param array $rowData
     * @throws InvalidArgumentException
     */
    private function validateEqualColumns(array $rowData): void
    {
        $numHeaders = count($this->tableHeaders);
        $numCells = count($rowData);
        if ($numHeaders !== $numCells) {
            throw new InvalidArgumentException(sprintf(
                'Number of cells (%d) [%s] does not match number of headers (%d) [%s]',
                $numCells,
                implode(',', $rowData),
                $numHeaders,
                implode(',', $this->tableHeaders)
            ));
        }
    }

    /**
     * Add an "Options" column to the table with the specified option type for each row.
     *
     * @param array $options
     * @return TableGenerator
     */
    public function addOptionsColumn(array $options = Table::OPTIONS_DEFAULT): self
    {

        $this->addHeader('Options');

        foreach ($this->tableData as $id => $data) {

            $tableOptions = TableOptionGenerator::generateMany($options,$id);

            $this->tableData[$id][] = $tableOptions;
        }

        return $this;
    }


    /**
     * Build the table object.
     *
     * @return Table
     */
    public function build(): Table
    {
        return new Table(
            $this->tableHeaders,
            $this->tableData,
            $this->vertical
        );
    }
}