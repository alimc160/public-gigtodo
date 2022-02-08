<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderDetailsExport implements FromCollection
{
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
    * @return Order
     */
    public function collection()
    {
        return $this->order;
    }
}
