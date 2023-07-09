@extends('master')
@section('main-content')
@csrf
<div class="admin-data-content layout-top-spacing">
    <div class="row project-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-3">

                                    <select multiple="multiple" class="form-control" id="user_id" name="user_id" >
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="monthPaySalary" name="monthPaySalary" >
                                        @foreach($dateTimesheets as $dateTimesheet)
                                        <option value="{{ $dateTimesheet['substring(checkin,1,7)']}}">{{ $dateTimesheet['substring(checkin,1,7)'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- thêm chấm công -->
                            </div>
                        </div>
                       
                        <div class="col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="table-responsive">
                                    <table id="user" class="table table-striped table-bordered table-custom-text">
                                        <thead>
                                            <tr>
                                                
                                                <th>STT</th>
                                                <th>Họ và tên</th>
                                                <th>Chức danh</th>
                                                <th>Tháng</th>
                                                <th>Phòng ban</th>
                                                @for($i=1; $i <= $endate; $i++)
                                                <th  style="width: 5%">{{$i}}</th>
                                                @endfor
                                                <th>Tổng cộng</th>
                                                <th>Xuất excel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $key=>$user)
                                            <?php
                                                     $monthNow = Carbon\Carbon::now()->format('Y-m');

                                                $Timesheet_reals = App\Models\Timesheet::where('checkout','!=',null)
                                                ->where('user_id', $user->id)->where('checkin','LIKE',"%$monthNow%")->where('status',1)->get();
                                            //   dd($monthNow);
                                                // if(!empty($monthNow) || $monthNow!=null)
                                                // {
                                                //     // dd($monthNow);
                                                //     // foreach($monthNow as $month){
                                                //     //     $Timesheet_reals = $Timesheet_reals->orwhere('checkin','LIKE',"%$month%");
                                                //     // }
                                                //     // $Timesheet_reals = $Timesheet_reals->get();
                                                 
                                                // }
                                                // else{
                                                //     $monthNow = Carbon\Carbon::now()->format('Y-m');
                                                //     $Timesheet_reals = $Timesheet_reals->where('checkin','LIKE',"%$monthNow%")->get();
                                                // }
                                            ?>
                                            <tr>
                                                    <th>{{$key+1}}</th>
                                                    <th>{{$user->fullname}}</th>
                                                    <th>{{$user->nameRole}}</th>
                                                    <th>{{$monthNow}}</th>
                                                    <th>{{$user->department->name}}</th>
                                                    <?php
                                                        $tong = 0 ;
                                                    ?>                       
                                                    @for($i=1; $i <= $endate; $i++)
                                                        <?php
                                                            $check = 0;
                                                        ?>
                                                        @foreach($Timesheet_reals as $Timesheet_real)
                                                            @if((int)Carbon\Carbon::parse($Timesheet_real->checkin)->format('d') == $i)
                                                                <?php
                                                                    if(Carbon\Carbon::parse($Timesheet_real->checkin)->diffInHours(Carbon\Carbon::parse($Timesheet_real->checkout)) > 4)
                                                                    {
                                                                        $check = 1;
                                                                        $tong+=1;
                                                                    }
                                                                    else{
                                                                        $check = 1/2;
                                                                        $tong+=1/2;
                                                                    }
                                                                ?>
                                                            @endif
                                                        @endforeach

                                                        @if($check)
                                                            <th>{{$check}}</th>
                                                        @else
                                                            <th></th>
                                                        @endif
                                                    @endfor

                                                    <th>{{$tong}}</th>
                                                    <th style="text-align:center"><a href="{{route('Timesheet.export_timesheet',['id' => $user->id])}}" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></a></th>
                                            @endforeach
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div>
        </div> 
    </div>
</div>

@section('page-js')
<script type="text/javascript">
    $("#user_id").multipleSelect({
        placeholder: "Chọn tên nhân viên",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())

            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.search')}}",
                type: 'get',
                data: {
                  user_id :filteruser_id,
                   month:filtermonth
                },
                dataType: 'json',
            })
            setTimeout(function() {
                            location.reload();
                        }, 1500);
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
 
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.search')}}",
                type: 'get',
                data: {
                   user_id :filteruser_id,
                   month:filtermonth
                },
                dataType: 'json',
            })
            setTimeout(function() {
                            location.reload();
                        }, 1500);
        }
    });
   
    // $("#select-chon-hang-loat").select2({
    //    placeholder: "Chọn thao tác",
    //    allowClear: true,
    //    minimumResultsForSearch: -1
    // });
</script>
<script type="text/javascript">
    $("#monthPaySalary").multipleSelect({
        placeholder: "Chọn tháng",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
 
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.search')}}",
                type: 'get',
                data: {
                  user_id :filteruser_id,
                   month:filtermonth
                },
                dataType: 'json',
            })
            setTimeout(function() {
                            location.reload();
                        }, 1500);
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
 
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.search')}}",
                type: 'get',
                data: {
                  user_id :filteruser_id,
                   month:filtermonth
                },
                dataType: 'json',
            })
            setTimeout(function() {
                            location.reload();
                        }, 1500);
        }
    });
   
 
</script>

@endsection
@endsection 