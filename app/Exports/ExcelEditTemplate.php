<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;


class ExcelEditTemplate implements FromArray
{
    protected $templates;

    public function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    public function array(): array   
    {
        return $this->templates;
    }
}