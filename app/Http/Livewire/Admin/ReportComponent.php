<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use PDF;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Category;
use TCPDF;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TopProductsExport;

class ReportComponent extends Component
{


    public $topProducts = [];
    public function render()
    {
        /* Accedemos a todas las órdenes */
        $orders = Order::query()->where('status', '<>', 1);
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        $orders = $orders->get();

        /* Iteramos cada orden y decodificamos el content (aquí está el detalle de la orden) */
        $productQuantities = [];
        foreach ($orders as $order) {
            $content = json_decode($order->content, true);

            // se incrementa la cantidad vendida para cada producto en el arreglo $productQuantities
            foreach ($content as $product) {
                $productId = $product['id'];
                $quantity = $product['qty'];

                //Si el producto ya existe, sumamos ; sino, agregamos.
                if (isset($productQuantities[$productId])) {
                    $productQuantities[$productId] += $quantity;
                } else {
                    $productQuantities[$productId] = $quantity;
                }
            }
        }

        // Ordenar los productos por la cantidad vendida en orden descendente
        arsort($productQuantities);

        // Obtener los 5 productos más vendidos con su nombre

        foreach (array_slice($productQuantities, 0, 5, true) as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $subcategory = Subcategory::find($product->subcategory_id);
                $subcategoryName = $subcategory ? $subcategory->name : 'Sin subcategoría';

                $category = Category::find($subcategory->category_id);
                $categoryName = $category ? $category->name : 'Sin categoría';

                $topProducts[$productId] = [
                    'name' => $product->name,
                    'subcategory' => $subcategoryName,
                    'category' => $categoryName,
                    'quantity' => $quantity,
                ];
            }
        }
        $this->topProducts = $topProducts; // Asignar los valores a la propiedad
        return view('livewire.admin.report-component', compact('orders', 'topProducts'))->layout('layouts.admin');
    }

    public function generarPDF()
    {
        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Establecer información del documento PDF
        $pdf->SetCreator('Tu Nombre');
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Reporte de productos más vendidos');
        $pdf->SetSubject('Reporte de productos más vendidos');
        $pdf->SetKeywords('productos, vendidos, reporte');

        // Agregar una página
        $pdf->AddPage();

        // Establecer el contenido del PDF
        $html = '<h1>Reporte de productos más vendidos</h1>';

        $html .= '<table border="1">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Subcategoría</th>
                            <th>Categoría</th>
                            <th>Cantidad vendida</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($this->topProducts as $productId => $productData) {
            $html .= '<tr>
                        <td>' . $productData['name'] . '</td>
                        <td>' . $productData['subcategory'] . '</td>
                        <td>' . $productData['category'] . '</td>
                        <td>' . $productData['quantity'] . '</td>
                    </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Generar el PDF y guardarlo en el directorio de almacenamiento
        $pdf->Output(storage_path('app/reportes/reporte_productos_vendidos.pdf'), 'F');

        // Descargar el archivo PDF generado
        return response()->download(storage_path('app/reportes/reporte_productos_vendidos.pdf'));
    }

    public function generarExcel()
    {
        $export = new TopProductsExport($this->topProducts);
        return Excel::download($export, 'reporte_productos_vendidos.xlsx');
    }
}
