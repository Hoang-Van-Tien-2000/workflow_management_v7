<?php

namespace App\Exports;

use App\Models\PaySalary;
use App\Models\Contract;
use App\Models\User;
use App\Models\Timesheet;
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

class TimeSheetExport extends DefaultValueBinder implements FromCollection, WithCustomValueBinder, WithStyles, ShouldAutoSize, WithCustomStartCell, WithMapping, WithHeadings, WithEvents
{
    private $user_id;
    private $time;

    public function __construct($user_id, $time)
    {   
        $this->user_id = $user_id;
        $this->time = $time;
    }


    public function headings(): array
    {   
        if($this->time == null)
        {
            $endate = (int) Carbon::now()->endOfMonth()->format('d');
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        }
        else
        {
            $month = substr($this->time,5,7);
            $year = substr($this->time,0,4);
            $endate = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
        }

        if($month == '1' || $month == '3'|| $month == '5' || $month == '7' || $month == '8' || $month == '10' || $month == '12')
        {
            return [
                'Nhân viên',
                'Thời gian',
                '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31',
                'Tổng số ngày làm'
            ];
        }
        else if($month == '2')
        {
            if($endate == '28')
            {
                return [
                    'Nhân viên',
                    'Thời gian',
                    '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28',
                    'Tổng số ngày làm'
                ];
            }
            else
            {
                return [
                    'Nhân viên',
                    'Thời gian',
                    '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29',
                    'Tổng số ngày làm'
                ];
            }
        }
        else
        {
            return [
                'Nhân viên',
                'Thời gian',
                '1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30',
                'Tổng số ngày làm'
            ];
        }
    }


    public function registerEvents(): array
    {   
        
        if($this->time == null)
        {
            $endate = (int) Carbon::now()->endOfMonth()->format('d');
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        }
        else
        {
            $month = substr($this->time,5,7);
            $year = substr($this->time,0,4);
            $endate = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
        }

        if($month == '1' || $month == '3'|| $month == '5' || $month == '7' || $month == '8' || $month == '10' || $month == '12')
        {
            return [
                AfterSheet::class    => function (AfterSheet $event) {
                    $event->sheet->setCellValue('L1', 'Bảng chấm công');
                    $event->sheet->setCellValue('N2', "Ngày xuất báo cáo: ");
                    $event->sheet->setCellValue('Q2', date('d-m-Y', strtotime(Carbon::now())));
                    // Format columns
                    $event->sheet->getColumnDimension('A')->setAutoSize(true);
                    $event->sheet->getColumnDimension('B')->setAutoSize(true);
                    $event->sheet->getColumnDimension('C')->setAutoSize(false);
                    $event->sheet->getColumnDimension('D')->setAutoSize(false);
                    $event->sheet->getColumnDimension('E')->setAutoSize(false);
                    $event->sheet->getColumnDimension('F')->setAutoSize(false);
                    $event->sheet->getColumnDimension('G')->setAutoSize(false);
                    $event->sheet->getColumnDimension('H')->setAutoSize(false);
                    $event->sheet->getColumnDimension('I')->setAutoSize(false);
                    $event->sheet->getColumnDimension('J')->setAutoSize(false);
                    $event->sheet->getColumnDimension('K')->setAutoSize(false);
                    $event->sheet->getColumnDimension('L')->setAutoSize(false);
                    $event->sheet->getColumnDimension('M')->setAutoSize(false);
                    $event->sheet->getColumnDimension('N')->setAutoSize(false);
                    $event->sheet->getColumnDimension('O')->setAutoSize(false);
                    $event->sheet->getColumnDimension('P')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Q')->setAutoSize(false);
                    $event->sheet->getColumnDimension('R')->setAutoSize(false);
                    $event->sheet->getColumnDimension('S')->setAutoSize(false);
                    $event->sheet->getColumnDimension('T')->setAutoSize(false);
                    $event->sheet->getColumnDimension('U')->setAutoSize(false);
                    $event->sheet->getColumnDimension('V')->setAutoSize(false);
                    $event->sheet->getColumnDimension('W')->setAutoSize(false);
                    $event->sheet->getColumnDimension('X')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Y')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Z')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AA')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AB')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AC')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AD')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AE')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AF')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AG')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AH')->setAutoSize(true);
                    $event->sheet->getDefaultColumnDimension()->setWidth(20);
                    $event->sheet->getDelegate()->getStyle('A4:AH4')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getDelegate()->getStyle('A5:AH5')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                },
            ];
        }
        else if($month == '2')
        {
            if($endate == '28')
            {
                return [
                    AfterSheet::class    => function (AfterSheet $event) {
                        $event->sheet->setCellValue('L1', 'Bảng châm công');
                        $event->sheet->setCellValue('N2', "Ngày xuất báo cáo: ");
                        $event->sheet->setCellValue('Q2', date('d-m-Y', strtotime(Carbon::now())));
                        // Format columns
                        $event->sheet->getColumnDimension('A')->setAutoSize(true);
                        $event->sheet->getColumnDimension('B')->setAutoSize(true);
                        $event->sheet->getColumnDimension('C')->setAutoSize(false);
                        $event->sheet->getColumnDimension('D')->setAutoSize(false);
                        $event->sheet->getColumnDimension('E')->setAutoSize(false);
                        $event->sheet->getColumnDimension('F')->setAutoSize(false);
                        $event->sheet->getColumnDimension('G')->setAutoSize(false);
                        $event->sheet->getColumnDimension('H')->setAutoSize(false);
                        $event->sheet->getColumnDimension('I')->setAutoSize(false);
                        $event->sheet->getColumnDimension('J')->setAutoSize(false);
                        $event->sheet->getColumnDimension('K')->setAutoSize(false);
                        $event->sheet->getColumnDimension('L')->setAutoSize(false);
                        $event->sheet->getColumnDimension('M')->setAutoSize(false);
                        $event->sheet->getColumnDimension('N')->setAutoSize(false);
                        $event->sheet->getColumnDimension('O')->setAutoSize(false);
                        $event->sheet->getColumnDimension('P')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Q')->setAutoSize(false);
                        $event->sheet->getColumnDimension('R')->setAutoSize(false);
                        $event->sheet->getColumnDimension('S')->setAutoSize(false);
                        $event->sheet->getColumnDimension('T')->setAutoSize(false);
                        $event->sheet->getColumnDimension('U')->setAutoSize(false);
                        $event->sheet->getColumnDimension('V')->setAutoSize(false);
                        $event->sheet->getColumnDimension('W')->setAutoSize(false);
                        $event->sheet->getColumnDimension('X')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Y')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Z')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AA')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AB')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AC')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AD')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AE')->setAutoSize(true);
                        $event->sheet->getDefaultColumnDimension()->setWidth(20);
                        $event->sheet->getDelegate()->getStyle('A4:AH4')
                                        ->getAlignment()
                                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A5:AH5')
                                        ->getAlignment()
                                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    },
                ];
            }
            else
            {
                return [
                    AfterSheet::class    => function (AfterSheet $event) {
                        $event->sheet->setCellValue('L1', 'Bảng chấm công');
                        $event->sheet->setCellValue('N2', "Ngày xuất báo cáo: ");
                        $event->sheet->setCellValue('Q2', date('d-m-Y', strtotime(Carbon::now())));
                        
                        // Format columns
                        $event->sheet->getColumnDimension('A')->setAutoSize(true);
                        $event->sheet->getColumnDimension('B')->setAutoSize(true);
                        $event->sheet->getColumnDimension('C')->setAutoSize(false);
                        $event->sheet->getColumnDimension('D')->setAutoSize(false);
                        $event->sheet->getColumnDimension('E')->setAutoSize(false);
                        $event->sheet->getColumnDimension('F')->setAutoSize(false);
                        $event->sheet->getColumnDimension('G')->setAutoSize(false);
                        $event->sheet->getColumnDimension('H')->setAutoSize(false);
                        $event->sheet->getColumnDimension('I')->setAutoSize(false);
                        $event->sheet->getColumnDimension('J')->setAutoSize(false);
                        $event->sheet->getColumnDimension('K')->setAutoSize(false);
                        $event->sheet->getColumnDimension('L')->setAutoSize(false);
                        $event->sheet->getColumnDimension('M')->setAutoSize(false);
                        $event->sheet->getColumnDimension('N')->setAutoSize(false);
                        $event->sheet->getColumnDimension('O')->setAutoSize(false);
                        $event->sheet->getColumnDimension('P')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Q')->setAutoSize(false);
                        $event->sheet->getColumnDimension('R')->setAutoSize(false);
                        $event->sheet->getColumnDimension('S')->setAutoSize(false);
                        $event->sheet->getColumnDimension('T')->setAutoSize(false);
                        $event->sheet->getColumnDimension('U')->setAutoSize(false);
                        $event->sheet->getColumnDimension('V')->setAutoSize(false);
                        $event->sheet->getColumnDimension('W')->setAutoSize(false);
                        $event->sheet->getColumnDimension('X')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Y')->setAutoSize(false);
                        $event->sheet->getColumnDimension('Z')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AA')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AB')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AC')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AD')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AE')->setAutoSize(false);
                        $event->sheet->getColumnDimension('AF')->setAutoSize(true);
                        $event->sheet->getDefaultColumnDimension()->setWidth(20);
                        $event->sheet->getDelegate()->getStyle('A4:AH4')
                                        ->getAlignment()
                                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A5:AH5')
                                        ->getAlignment()
                                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    },
                ];
            }
        }
        else
        {
            return [
                AfterSheet::class    => function (AfterSheet $event) {
                    $event->sheet->setCellValue('L1', 'Bảng chấm công');
                    $event->sheet->setCellValue('N2', "Ngày xuất báo cáo: ");
                    $event->sheet->setCellValue('Q2', date('d-m-Y', strtotime(Carbon::now())));
                    // Format columns
                    $event->sheet->getColumnDimension('A')->setAutoSize(true);
                    $event->sheet->getColumnDimension('B')->setAutoSize(true);
                    $event->sheet->getColumnDimension('C')->setAutoSize(false);
                    $event->sheet->getColumnDimension('D')->setAutoSize(false);
                    $event->sheet->getColumnDimension('E')->setAutoSize(false);
                    $event->sheet->getColumnDimension('F')->setAutoSize(false);
                    $event->sheet->getColumnDimension('G')->setAutoSize(false);
                    $event->sheet->getColumnDimension('H')->setAutoSize(false);
                    $event->sheet->getColumnDimension('I')->setAutoSize(false);
                    $event->sheet->getColumnDimension('J')->setAutoSize(false);
                    $event->sheet->getColumnDimension('K')->setAutoSize(false);
                    $event->sheet->getColumnDimension('L')->setAutoSize(false);
                    $event->sheet->getColumnDimension('M')->setAutoSize(false);
                    $event->sheet->getColumnDimension('N')->setAutoSize(false);
                    $event->sheet->getColumnDimension('O')->setAutoSize(false);
                    $event->sheet->getColumnDimension('P')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Q')->setAutoSize(false);
                    $event->sheet->getColumnDimension('R')->setAutoSize(false);
                    $event->sheet->getColumnDimension('S')->setAutoSize(false);
                    $event->sheet->getColumnDimension('T')->setAutoSize(false);
                    $event->sheet->getColumnDimension('U')->setAutoSize(false);
                    $event->sheet->getColumnDimension('V')->setAutoSize(false);
                    $event->sheet->getColumnDimension('W')->setAutoSize(false);
                    $event->sheet->getColumnDimension('X')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Y')->setAutoSize(false);
                    $event->sheet->getColumnDimension('Z')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AA')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AB')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AC')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AD')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AE')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AF')->setAutoSize(false);
                    $event->sheet->getColumnDimension('AG')->setAutoSize(true);
                    $event->sheet->getDefaultColumnDimension()->setWidth(10);
                    $event->sheet->getDelegate()->getStyle('A4:AH4')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getDelegate()->getStyle('A5:AH5')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                },
            ];
        }
        
    }


    public function styles(Worksheet $sheet)
    {
        return [

            // Styling an entire column.
            'L1'  => ['font' => ['size' => 20, 'bold' => true, 'text-align' => 'center']],
            'N2'  => ['font' => ['size' => 15, 'bold' => true, 'text-align' => 'center']],
            'Q2'  => ['font' => ['size' => 15, 'bold' => true, 'text-align' => 'center']],
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
            'M4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'N4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'O4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'P4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'Q4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'R4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'S4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'T4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'U4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'V4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'W4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'X4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'Y4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'Z4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AA4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AB4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AC4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AD4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AE4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AF4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AG4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
            'AH4'  => ['font' => ['size' => 11, 'bold' => true, 'text-align' => 'center']],
        ];
    }

    public function collection()
    {   
        return User::where('id', $this->user_id)->get();
        // if($this->time == null)
        // {
        //     $endate = (int) Carbon::now()->endOfMonth()->format('d');
        //     $month = Carbon::now()->month;
        //     $year = Carbon::now()->year;
        // }
        // else
        // {
        //     $month = substr($this->time,5,7);
        //     $year = substr($this->time,0,4);
        //     $endate = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // }
        // return Timesheet::where('user_id', $this->user_id)->whereMonth('checkin', $month)->whereYear('checkin', $year)->get();

    }

    public function map($timeSheet): array
    {   
        if($this->time == null)
        {
            $endate = (int) Carbon::now()->endOfMonth()->format('d');
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        }
        else
        {
            $month = substr($this->time,5,7);
            $year = substr($this->time,0,4);
            $endate = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        $Timesheet_reals = Timesheet::where('checkout','!=',null)->where('user_id', $this->user_id)->where('status',1)->whereMonth('checkin', $month)->whereYear('checkin', $year)->get();
        $user = User::find($this->user_id);
        $check = 0;
        for($i=1; $i <= $endate; $i++)
        {$a[$i] = '';}
        for($i=1; $i <= $endate; $i++)
        {
            foreach($Timesheet_reals as $Timesheet_real)
            {
                if((int)Carbon::parse($Timesheet_real->checkin)->format('d') == $i)
                {
                    if(Carbon::parse($Timesheet_real->checkin)->diffInHours(Carbon::parse($Timesheet_real->checkout)) > 4)
                    {
                        $a[$i] = 'x';
                        $check  += 1;
                    }
                    else 
                    {
                        $a[$i] = 'x/2';
                        $check += 1/2;
                    }
                }
                // else
                // {
                //     $a[$i] = '';
                // }
            }
        }
        if($month == '1' || $month == '3'|| $month == '5' || $month == '7' || $month == '8' || $month == '10' || $month == '12')
        {
            return [
                $user->fullname,
                $this->time,
                $a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7],$a[8],$a[9],$a[10],$a[11],$a[12],$a[13],$a[14],$a[15],$a[16],$a[17],$a[18],$a[19],$a[20],$a[21],$a[22],$a[23],$a[24],$a[25],$a[26],$a[27],$a[28],$a[29],$a[30],$a[31],
                $check
            ];
        }
        else if($month == '2' )
        {
            if($endate == '28')
            {
                return [
                    $user->fullname,
                    $this->time,
                    $a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7],$a[8],$a[9],$a[10],$a[11],$a[12],$a[13],$a[14],$a[15],$a[16],$a[17],$a[18],$a[19],$a[20],$a[21],$a[22],$a[23],$a[24],$a[25],$a[26],$a[27],$a[28],
                    $check
                ];
            }
            else
            {
                return [
                    $user->fullname,
                    $this->time,
                    $a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7],$a[8],$a[9],$a[10],$a[11],$a[12],$a[13],$a[14],$a[15],$a[16],$a[17],$a[18],$a[19],$a[20],$a[21],$a[22],$a[23],$a[24],$a[25],$a[26],$a[27],$a[28],$a[29],
                    $check
                ];
            }
        }
        else
        {
            return [
                $user->fullname,
                $this->time,
                $a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7],$a[8],$a[9],$a[10],$a[11],$a[12],$a[13],$a[14],$a[15],$a[16],$a[17],$a[18],$a[19],$a[20],$a[21],$a[22],$a[23],$a[24],$a[25],$a[26],$a[27],$a[28],$a[29],$a[30],
                $check
            ];
        }
    }


    public function startCell(): string
    {
        return 'A4';
    }
}
