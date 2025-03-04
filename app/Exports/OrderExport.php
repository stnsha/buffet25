<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromArray, WithHeadings, WithTitle, WithEvents
{
    protected array $results;
    protected string $venueName;
    protected string $venueDate;

    public function __construct(array $results, string $venueName, string $venueDate)
    {
        $this->results = $results;
        $this->venueName = $venueName;
        $this->venueDate = date('d M Y', strtotime($venueDate)); // Format the date
    }

    public function headings(): array
    {
        return [
            ["{$this->venueName} ({$this->venueDate})"], // Dynamic Title
            [ // Column headers
                'Order ID',
                'Customer Name',
                'Phone',
                'Email',
                'Total Payment',
                'ToyyibPay Ref',
                'Status',
                'Price Name',
                'Price',
                'Quantity',
                'Subtotal'
            ]
        ];
    }

    public function array(): array
    {
        $data = [];
        $rowIndex = 3; // Start after title and headers
        $mergeRanges = []; // Store merge ranges

        foreach ($this->results as $venue => $orders) {
            foreach ($orders as $order) {
                $firstRow = $rowIndex;
                $priceRows = count($order['order_details'], COUNT_RECURSIVE) - count($order['order_details']);

                foreach ($order['order_details'] as $details) {
                    foreach ($details as $detail) {
                        $data[] = [
                            $order['order_id'],
                            $order['customer_name'],
                            $order['customer_phone'],
                            $order['customer_email'],
                            $order['total_payment'],
                            $order['toyyibpay_ref'],
                            $order['status'],
                            $detail['price_name'],
                            $detail['price'],
                            $detail['quantity'],
                            $detail['subtotal']
                        ];
                        $rowIndex++;
                    }
                }

                if ($priceRows > 1) {
                    $mergeRanges[] = [
                        'columns' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'], // Columns to merge
                        'start' => $firstRow,
                        'end' => $rowIndex - 1
                    ];
                }
            }
        }

        $this->mergeRanges = $mergeRanges; // Store merge ranges for later use

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Apply merging for customer details
                foreach ($this->mergeRanges as $merge) {
                    foreach ($merge['columns'] as $column) {
                        $sheet->mergeCells("{$column}{$merge['start']}:{$column}{$merge['end']}");
                    }
                }
            },
        ];
    }

    public function title(): string
    {
        return "{$this->venueName} Report";
    }
}
