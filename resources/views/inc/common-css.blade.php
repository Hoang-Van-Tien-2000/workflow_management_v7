<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/js/loader.js') }}"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLE -->
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link href="{{ asset('plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/fullcalendar/custom-fullcalendar.advance.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ asset('assets') }}" rel="stylesheet" type="text/css" /> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('assets/plugins/parsleyjs/parsley.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/plugins/multiple-select/multiple-select.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
<link href="{{ asset('assets/css/apps/scrumboard.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom-admin-page.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css"
    href="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.css" />
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<!-- END PAGE LEVEL STYLE -->
<style>
    .widget {
        margin-bottom: 10px;
        border: none;
        box-shadow: rgb(145 158 171 / 24%) 0px 0px 2px 0px, rgb(145 158 171 / 24%) 0px 16px 32px -4px;
    }

    .widget-content-area {
        border-radius: 6px;
    }

    .daterangepicker.dropdown-menu {
        z-index: 1059;
    }

    /*
 ===============================
   @Import	Function
 ===============================
*/
    /*
 ===============================
   @Import	Mixins
 ===============================
*/
    .custom-file-container {
        box-sizing: border-box;
        position: relative;
        display: block;
    }

    .custom-file-container label {
        color: #4361ee;
    }

    .custom-file-container label .custom-file-container__image-clear {
        color: #3b3f5c;
    }

    .custom-file-container__custom-file {
        box-sizing: border-box;
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(2.25rem + 2px);
        margin-bottom: 0;
        margin-top: 5px;
    }

    .custom-file-container__custom-file:hover {
        cursor: pointer;
    }

    .custom-file-container__custom-file__custom-file-input {
        box-sizing: border-box;
        min-width: 14rem;
        max-width: 100%;
        height: calc(2.25rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-container__custom-file__custom-file-input:focus~span {
        outline: 1px dotted #515365;
        outline: 5px auto -webkit-focus-ring-color;
    }

    .custom-file-container__custom-file__custom-file-control {
        box-sizing: border-box;
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 5;
        height: auto;
        overflow: hidden;
        line-height: 1.5;
        user-select: none;
        background-clip: padding-box;
        border-radius: .25rem;
        height: auto;
        border: 1px solid #f1f2f3;
        color: #3b3f5c;
        font-size: 15px;
        padding: 8px 10px;
        letter-spacing: 1px;
        background-color: #f1f2f3;
    }

    .custom-file-container__custom-file__custom-file-control__button {
        box-sizing: border-box;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 6;
        display: block;
        height: auto;
        padding: 10px 16px;
        line-height: 1.25;
        background-color: rgba(27, 85, 226, 0.239216);
        color: #4361ee;
        border-left: 1px solid #e0e6ed;
        box-sizing: border-box;
    }

    .custom-file-container__image-preview {
        box-sizing: border-box;
        transition: all 0.2s ease;
        margin-top: 54px;
        margin-bottom: 40px;
        height: 250px;
        width: 100%;
        border-radius: 4px;
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
        background-color: #fff;
        overflow: auto;
        padding: 15px;
    }

    .custom-file-container__image-multi-preview {
        position: relative;
        box-sizing: border-box;
        transition: all 0.2s ease;
        border-radius: 6px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        float: left;
        margin: 1.858736%;
        width: 29.615861214%;
        height: 90px;
        box-shadow: 0 4px 10px 0 rgba(51, 51, 51, 0.25);
    }

    .custom-file-container__image-multi-preview__single-image-clear {
        left: -6px;
        background: #ffffff;
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        text-align: center;
        margin-top: -6px;
        box-shadow: 0 4px 10px 0 rgba(51, 51, 51, 0.25);
    }

    .custom-file-container__image-multi-preview__single-image-clear:hover {
        background: #cbcbbd;
        cursor: pointer;
    }

    .custom-file-container__image-multi-preview__single-image-clear__icon {
        color: #4361ee;
        display: block;
        margin-top: -2px;
    }
</style>
