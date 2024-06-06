<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TableExport implements FromArray, WithHeadings, WithMapping
{
    protected $table;
    protected $data;
    protected $owners;

    public function __construct($table, $data, $owners)
    {
        $this->table = $table;
        $this->data = $data;
        $this->owners = $owners;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        if (count($this->data) > 0) {
            return array_keys($this->data[0]);
        }
        return [];
    }

    public function map($row): array
    {
        $mappedRow = [];
        foreach ($row as $key => $value) {
            if ($key == 'id_propietario') {
                $mappedRow[] = $this->owners[$value] . '#' . $value;
            } else {
                $mappedRow[] = $value;
            }
        }
        return $mappedRow;
    }
}
