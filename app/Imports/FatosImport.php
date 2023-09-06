<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FatosImport implements ToCollection
{
    private $collection;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->collection;
    }

    public function get_Data(): Collection
    {
        return $this->collection;
    }
}
