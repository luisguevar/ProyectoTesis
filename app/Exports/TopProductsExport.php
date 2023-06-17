<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TopProductsExport implements FromCollection, WithHeadings
{
    protected $topProducts;

    public function __construct($topProducts)
    {
        $this->topProducts = $topProducts;
    }

    public function collection()
    {
        return collect($this->topProducts);
    }

    public function headings(): array
    {
        return [
            'Producto',
            'Subcategoría',
            'Categoría',
            'Cantidad vendida'
        ];
    }
}
