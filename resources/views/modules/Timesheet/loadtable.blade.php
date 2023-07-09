
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
                <tbody id="reset">
                    @foreach($users as $key=>$user)
                    
                    <?php

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
                                @foreach($Timesheets as $Timesheet_real)
                                    @if((int)Carbon\Carbon::parse($Timesheet_real->checkin)->format('d') == $i && $user->id ==$Timesheet_real->user_id)
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