<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaySalary;
use App\Models\User;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendMailSalaryController extends Controller
{
    public function __construct()
    {
        $this->module = 'pay_salaries';
        $this->breadcrumb = [
            'object'    => 'Bảng lương',
            'page'      => ''
        ];
        $this->title = 'Bảng lương';
    }

    public function viewMail($id)
    {
        $salary = PaySalary::find($id);
        $this->breadcrumb['page'] = 'Gửi mail';
        $data = [
            'salary'         => $salary,
        ];
        return $this->openView("modules.{$this->module}.send-mail", $data);
    }

    public function sendEmail(Request $request)
    {
        $salary     = PaySalary::find($request->id);
        $user       = User::find($salary->user_id);
        $contract   = Contract::find($salary->contract_id);
        $time   = Carbon::parse($salary->month)->format('m-Y');
        $data = [
            'noi_dung'                => $request->noi_dung,
            'ten_nhan_vien'           => $user->fullname,
            'chuc_vu'                 => $user->role->name,
            'luong_co_ban'            => $contract->salary,
            'so_ngay_lam_viec'        => $salary->working_day,
            'tro_cap'                 => $salary->allowance,
            'tong_luong'              => $salary->total,
            'tam_ung'                 => $salary->advance,
            'luong_thuong'            => $salary->sum_bonus,
            'luong_phat'              => $salary->sum_discipline,
            'luong_thuc_nhan'         => $salary->actual_salary,
            'subject'                 => "Lương tháng ". $time,
            'email'                   => $user->email,
        ];

       
        Mail::send('email-template', $data, function($message) use ($data) {
          $message->to($data['email'])->subject($data['subject']);
          $message->from($data['email']);
        });

        $route = "{$this->module}.list";
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Gửi mail thành công',
                'redirect' => route($route)
            ],
            200
        );
    }
}
