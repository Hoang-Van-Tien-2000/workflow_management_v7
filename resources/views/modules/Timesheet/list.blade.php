@extends('master')
@section('main-content')
@csrf
<div class="admin-data-content layout-top-spacing" id="old">
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
                                    <select class="form-control" id="monthPaySalary" name="monthPaySalary" >
                                        <option value=""></option>
                                        @foreach($dateTimesheets as $dateTimesheet)
                                        <option value="{{ $dateTimesheet['substring(checkin,1,7)']}}">{{ $dateTimesheet['substring(checkin,1,7)'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select multiple="multiple" class="form-control" id="department_id" name="department_id" >
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="d-lg-flex justify-content-end">
                                            <button 
                                            style="height: 45.17px; margin-right: 0.25em;" 
                                            type="button" 
                                            class="btn btn-outline-primary mt-2 mt-lg-0"
                                            data-toggle="modal" 
                                            data-target="#exportModal" 
                                            onclick="onOpenModalImport()" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></button>
                                    </div>
                                </div>
                                <!-- thêm chấm công -->
                            </div>
                        </div>
                       
                        <div class="col-12 layout-spacing" id="resettable">
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
                                        <tbody >
                                            @foreach($users as $key=>$user)
                                            <?php
                                                $Timesheet_reals = App\Models\Timesheet::where('checkout','!=',null)
                                                ->where('user_id', $user->id)->where('checkin','LIKE',"%$monthNow%")->where('status',1)->get();
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
                                                    <th style="text-align:center"><a href="{{route('Timesheet.export_timesheet',['id' => $user->id, 'time' => $monthNow])}}" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></a></th>
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
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <form 
        data-validate-parsley 
        id="formexportModal" 
        class="modal-dialog modal-sm" 
        role="document"
        action="{{ route('Timesheet.exporting_timesheet_of_department') }}" 
        method="post"
    >
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xuất danh sách chấm công</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body"> 
            <div class="form-row mt-2">
                <label class="form-label" for="mo-ta">Phòng ban</label>
                <select id="phong_ban" name="phong_ban" class="form-select">   
                    <option value=""></option>
                    @foreach($departments as $department)
                    <option value="{{$department->id }}">{{$department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row mt-2">
                <label class="form-label" for="mo-ta">Tháng (Mặc định là tháng hiện tại)</label>
                <select id="thang" name="thang" class="form-select">
                    <option value=""></option>
                    @foreach($dateTimesheets as $dateTimesheet)
                    <option value="{{ $dateTimesheet['substring(checkin,1,7)']}}">{{ $dateTimesheet['substring(checkin,1,7)'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn-cancel" onclick="onCloseModalExport()" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Huỷ bỏ</button>
            <button onclick="onSubmitModal()"  id="btnSubmitModal" type="button" class="btn btn-primary">Đồng ý</button>
        </div>
        </div>
    </form>
</div>
@section('page-js')
<script type="text/javascript">
    function onOpenModalImport(button) {
        $('#exportModal').on('shown.bs.modal', function () {
            $("#phong_ban").select2({
               placeholder: "Chọn phòng ban",
               allowClear: true,
               closeOnSelect : true,
                tags: false, 
                language: {
                    noResults: function (params) {
                    return "Không tìm thấy kết quả";
                    }
                },
            });
            $("#thang").select2({
               placeholder: "Chọn tháng",
               allowClear: true,
               closeOnSelect : true,
                tags: false, 
                language: {
                    noResults: function (params) {
                    return "Không tìm thấy kết quả";
                    }
                },
            });
        })
    }

    function onCloseModalExport(button) {
        $('#exportModal').on('hide.bs.modal', function () {
        })
    }

    function onSubmitModal() {
        if($('#formexportModal').parsley().validate()) {
            $('#formexportModal').submit()
        }
    }
</script>
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
            var filterdepartment_id = JSON.stringify($("#department_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())

            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.list')}}",
                type: 'get',
                data: {
                    user_id       :filteruser_id,
                    department_id : filterdepartment_id,
                    month         :filtermonth
                },
                dataType: 'json',
            }).done(function(res){
                console.log(res);
                $("#resettable").html("");
                $("#resettable").html(res.data);
            })
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())

            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.list')}}",
                type: 'get',
                data: {
                    user_id       :filteruser_id,
                    department_id : filterdepartment_id,
                    month         :filtermonth
                },
                dataType: 'json',
            }).done(function(res){
                console.log(res);
                $("#resettable").html("");
                $("#resettable").html(res.data);
            })
        }
    });
   
    $("#monthPaySalary").select2({
       placeholder: "Chọn tháng",
       allowClear: true,
       minimumResultsForSearch: 0
    });
</script>


<script type="text/javascript">
    $("#department_id").multipleSelect({
        placeholder: "Chọn phòng ban",
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
            var filterdepartment_id = JSON.stringify($("#department_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())

            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.list')}}",
                type: 'get',
                data: {
                    user_id       :filteruser_id,
                    department_id : filterdepartment_id,
                    month         :filtermonth
                },
                dataType: 'json',
            }).done(function(res){
                console.log(res);
                $("#resettable").html("");
                $("#resettable").html(res.data);
            })
        },

        onClear: function () {
            var filteruser_id = JSON.stringify($("#user_id").val())
            var filterdepartment_id = JSON.stringify($("#department_id").val())
            var filtermonth = JSON.stringify($("#monthPaySalary").val())
 
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
            $.ajax({
                url: "{{route('Timesheet.list')}}",
                type: 'get',
                data: {
                    user_id       :filteruser_id,
                    department_id : filterdepartment_id,
                    month         :filtermonth
                },
                dataType: 'json',
            }).done(function(res){
                console.log(res);
                $("#resettable").html("");
                $("#resettable").html(res.data);
            })
        }
    });
   
    $("#monthPaySalary").select2({
       placeholder: "Chọn tháng",
       allowClear: true,
       minimumResultsForSearch: 0
    });
</script>

<script type="text/javascript">
    $('#monthPaySalary').on('select2:select', function (e) {
        var filteruser_id = JSON.stringify($("#user_id").val())
        var filterdepartment_id = JSON.stringify($("#department_id").val())
        var filtermonth = JSON.stringify($("#monthPaySalary").val())
 
        $.ajax({
            url: "{{route('Timesheet.list')}}",
            type: 'get',
            data: {
                user_id       :filteruser_id,
                department_id : filterdepartment_id,
                month         :filtermonth
            },
            dataType: 'json',
        }).done(function(res){
            console.log(res);
            $("#resettable").html("");
            $("#resettable").html(res.data);
    });
});
</script>
@endsection
@endsection 