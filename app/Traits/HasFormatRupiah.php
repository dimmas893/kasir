<?php

namespace App\Traits;

trait HasFormatRupiah
{
    function formatRupiah($field)
    {
        $nominal = $this->attributes[$field];
        return number_format($nominal, 0, ',', '.');
    }
}