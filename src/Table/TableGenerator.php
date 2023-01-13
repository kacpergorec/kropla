<?php
declare (strict_types=1);

namespace App\Table;

use App\Helper\ArrayHelper;
use App\Helper\ObjectHelper;
use App\Table\Option\TableOption;
use App\Table\Option\TableOptionGenerator;
use InvalidArgumentException;
use ReflectionClass;

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
        } else {
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

        $this->addHeadersFromEntities($entities, $includedProperties);

        $this->addRowsFromEntities($entities, $includedProperties);

        return $this;
    }

    /**
     * Set the table to be displayed in a vertical layout.
     *
     * @param bool $vertical
     * @return TableGenerator
     */
    public function setVertical(bool $vertical = true): self
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
                'Number of cells (%d) does not match number of headers (%d) [%s]',
                $numCells,
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
    public function addOptionsColumn(array $options = TableOption::DEFAULT): self
    {

        $this->addHeader('');

        foreach ($this->tableData as $id => $data) {

            $tableOptions = TableOptionGenerator::generateMany($options, $id);

            $this->tableData[$id]['tg_table_options'] = $tableOptions;
        }

        return $this;
    }

    /**
     * @return TableGenerator
     */
    public function addIncrementalColumn(): self
    {
        array_unshift($this->tableHeaders, '#');

        $counter = 0;

        foreach ($this->tableData as $id => $data) {
            array_unshift($this->tableData[$id], ++$counter);
        }

        return $this;
    }


    public function sortBy(string $property = 'id', string $direction = 'ASC'): self
    {
        if (empty($this->tableData)) {
            return $this;
        };

        if (!isset(reset($this->tableData)[$property])) {
            throw new \InvalidArgumentException("Cannot sort the table by: '$property'. The property is not found within the table.");
        }

        usort($this->tableData, function ($a, $b) use ($property) {
            return $b[$property] <=> $a[$property];
        });

        $direction = strtoupper($direction);

        if ($direction === 'ASC') {
            $this->tableData = array_reverse($this->tableData);
        } elseif ($direction !== 'DESC') {
            throw new \InvalidArgumentException("Direction must be either DESC or ASC. ($direction given)");
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

    private function addHeadersFromEntities(array $entities, array $includedProperties): void
    {
        //If included properties contain their translations ex. ['El título' =>'title','Las paginas' => 'pages']
        if (ArrayHelper::arrayHasCustomKeys($includedProperties)){
            $headers = array_keys($includedProperties);
        } elseif (!empty($includedProperties)) {
            $includedProperties = array_map(fn($property) => ObjectHelper::readableMethodString($property), $includedProperties);
            $headers = array_map(fn($property) => ucfirst($property), $includedProperties);
        } else {
            $properties = ObjectHelper::findProperties(reset($entities), true);
            $headers = array_map(fn($property) => ObjectHelper::readableMethodString($property), $properties);
        }


        $this->addHeaders($headers);

    }

    private function addRowsFromEntities(array $entities, array $includedProperties): void
    {
        $tableGetters = ObjectHelper::findGettersByProperties($entities, $includedProperties);
        foreach ($entities as $entity) {
            $this->addRow(
            //Entity values in row
                array_map(static function ($getter) use ($entity) {
                    return $entity->$getter();
                }, $tableGetters),
                //Row is identified by entity id
                $entity->getId()
            );
        }
    }
}