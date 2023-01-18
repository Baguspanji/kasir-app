<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    protected $report;
    protected $app_name;
    protected $app_address;
    protected $month;

    public function __construct(array $report, $month, $app_name, $app_address)
    {
        $this->report = $report;
        $this->app_name = $app_name;
        $this->app_address = $app_address;
        $this->month = $month;
    }

    public function collection()
    {
        $report = $this->map($this->report);
        return collect($report);
    }

    public function map($items): array
    {
        $data = [];
        $no = 0;

        $total_income = 0;
        foreach ($items as $value) {
            $total_income += $value['income'];

            $row = [
                ++$no,
                $value['date'],
                $value['name'],
                $value['quantity'],
                $value['take_price'],
                $value['price'],
                $value['income'],
                '',
            ];

            $data[] = $row;
        }

        $row = [
            '',
            '',
            '',
            '',
            '',
            'Total Pendapatan',
            $total_income,
            '',
        ];

        $data[] = $row;

        return $data;
    }

    public function headings(): array
    {
        $header = [
            strtoupper($this->app_name) . PHP_EOL .
            $this->app_address,
        ];

        $row0 = [
            'Tanggal    : ' . $this->month,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $row1 = [
            'No',
            'Tanggal',
            'Nama Barang',
            'Quantity',
            'Harga Beli',
            'Harga Jual',
            'Pendapatan',
            'Keterangan',
        ];

        return [
            $header,
            [],
            $row0,
            $row1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:' . 'H1');
                $event->sheet->getDelegate()->getStyle('A1:' . 'H1')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A1:' . 'H1')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:' . 'H1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1:' . 'H1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                $event->sheet->getDelegate()->setRightToLeft(false);
                $event->sheet->getDelegate()->getStyle('B4:H4')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(false);
            },
        ];
    }

    public function toNum($n)
    {
        $r = '';
        for ($i = 1; $n >= 0 && $i < 10; $i++) {
            $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
            $n -= pow(26, $i);
        }
        return $r;
    }
}
