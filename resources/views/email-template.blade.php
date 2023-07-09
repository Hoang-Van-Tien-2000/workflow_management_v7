<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if($noi_dung != '')
                            <div class="row">
                                Nội dung                        : {!! $noi_dung !!}
                            </div>
                        @endif
                        <div class="row">
                            Tên nhân viên                   : {!! $ten_nhan_vien !!}
                        </div>
                        <div class="row">
                            Chức vụ                         : {!! $chuc_vu !!}
                        </div>
                        <div class="row">
                            Lương cơ bản                    : {!! $luong_co_ban !!}
                        </div>
                        <div class="row">
                            Số ngày làm việc trong tháng    : {!! $so_ngay_lam_viec !!}
                        </div>
                        <div class="row">
                            Trợ cấp                         : {!! $tro_cap !!}
                        </div>
                        <div class="row">
                            Tổng lương                      : {!! $tong_luong !!}
                        </div>
                        <div class="row">
                            Tạm ứng                         : {!! $tam_ung !!}
                        </div>
                        <div class="row">
                            Lương thưởng                    : {!! $luong_thuong !!}
                        </div>
                        <div class="row">
                            Lương phạt                      : {!! $luong_phat !!}
                        </div>
                        <div class="row">
                            Lương thực nhận                 : {!! $luong_thuc_nhan !!}
                        </div>  
                    </div>
               </div>
           </div>
       </div>
   </div>
</body>
</html>