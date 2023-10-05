<?php

namespace App\Imports\CMS;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LanguagesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
