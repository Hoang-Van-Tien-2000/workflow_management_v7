@extends('master')
@section('title', 'Thống kê khách hàng')
@section('main-content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="card">
        <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-3">
                        <label class="form-label" for="mo-ta">Ngày tháng</label>
                        <input class="form-control" type="text" id="time_to" data-date-format="dd/mm/yy"
                            name="daterange" value="{{ $value }}" />
                    </div>
                </div>
                <div id="chartLine" class="col-xl-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div id="s-line" class=""></div>
                        </div>
                    </div>
                </div>
                {{-- <button class="btn-export btn-primary" id="exportExcel">Xuất Excel</button> --}}
            </div>
        </div>
    </div>

@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_custom.css') }}">
@endsection

@section('page-js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('plugins/apex/custom-apexcharts.js') }}"></script>
    <script>
        $(document).ready(function() {
            var formData = new FormData();
            formData.append('time', $('#time_to').val()); //Thời gian từ ngày nào đến ngày nào mặc định là 3 tháng

            $.ajax({
                url: "{{ route('statistic.customer.load_ajax_statistic_customer') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done(function(res) {
                var sline = {
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false,
                        }
                    },
                    // colors: ['#4361ee'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    series: [{
                        name: "Khách hàng",
                        data: res.customer
                    }],
                    grid: {
                        row: {
                            colors: ['#f1f2f3',
                                'transparent'
                            ], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: res.datelist,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val;
                            }
                        }
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#s-line"),
                    sline
                );
                chart.render();
            });

        });
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                chart = `${start.format('YYYY-MM-DD')} - ${end.format('YYYY-MM-DD')}`;
                var formData = new FormData();
                formData.append('time', chart);
                $.ajax({
                    url: "{{ route('statistic.customer.load_ajax_statistic_customer') }}",
                    type: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    $('.apexcharts-canvas').remove();
                    var sline = {
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false,
                            }
                        },
                        // colors: ['#4361ee'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        series: [{
                            name: "Khách hàng",
                            data: res.customer
                        }],
                        grid: {
                            row: {
                                colors: ['#f1f2f3',
                                    'transparent'
                                ], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: res.datelist,
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(
                        document.querySelector("#s-line"),
                        sline
                    );
                    chart.render();
                });


            });
        });
    </script>
@endsection
