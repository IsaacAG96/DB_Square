<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class TableExport implements FromCollection
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function collection()
    {
        return DB::table($this->table)->get();
    }

}
