<?php

namespace App\Exports;

use App\Models\PaySalary;
use App\Models\Contract;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Writer;
use \Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;


Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
    $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
});

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class SalaryUserExport extends DefaultValueBinder implements FromCollection, WithCustomValueBinder, WithStyles, ShouldAutoSize, WithCustomStartCell, WithMapping, WithHeadings, WithEvents
{
    private $pay_salary_id;

    public function __construct($pay_salary_id)
    {   
        $this->pay_salary_id = $pay_salary_id;
    }

    public function headings(): array
    {   
        return [
            'Nhân viên',
            'Thời gian',
            'Lương cơ bản',
            'Số ngày làm việc',
            'Lương',
            'Trợ cấp',
            'Tổng cộng',
            'Tạm ứng',
            'Khen thưởng',
            'Xử phạt',
            'Lương thực nhận',
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('D')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('E')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('F')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('G')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('H')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('J')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->getDelegate()->getStyle('K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setCellValue('D1', 'Bảng lương');
                $event->sheet->setCellValue('E2', "Ngày xuất báo cáo: ");
                $event->sheet->setCellValue('F2', date('d-m-Y', strtotime(Carbon::now())));
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling an entire column.
            'D1'  => ['font' => ['size' => 16, 'bold' => true]],
            'A1'  => ['font' => ['text-align' => 'center']],
            'A4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'B4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'C4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'D4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'E4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'F4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'G4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'H4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'I4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'J4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'K4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'L4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'E2'  => ['font' => ['name' => 'Rengular', 'size' => 11]],
            'F2'  => ['font' => ['name' => 'Rengular', 'size' => 11]],
        ];
    }

    public function collection()
    {   
        return PaySalary::where('id', $this->pay_salary_id)->with('user')->get();
    }

    public function map($paySalary): array
    {   
        $contract = Contract::find($paySalary->contract_id);
        return [
            $paySalary->user->fullname,
            date('m-Y', strtotime(Carbon::parse($paySalary->month))),
            (string)$contract->salary,
            (string)$paySalary->working_day,
            (string)$paySalary->salary,
            (string)$paySalary->allowance,
            (string)$paySalary->total,
            (string)$paySalary->advance,
            (string)$paySalary->sum_bonus,
            (string)$paySalary->sum_discipline,
            (string)$paySalary->actual_salary,
        ];
    }


    public function startCell(): string
    {
        return 'A4';
    }

}
