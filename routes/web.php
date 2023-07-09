<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScrumBoardController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AnnualLeaveController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ContractExtensionController;
use App\Http\Controllers\PaySalarieController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdvanceAllowanceController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ConfigController;
use App\Events\Message;
use App\Http\Controllers\ThongKecontroller;
use App\Http\Controllers\SendMailSalaryController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group([
    'middleware' => 'auth',

], function ($router) {
    Route::prefix('thong-ke')->group(function () {
        Route::name('statistic.')->group(function () {
            Route::prefix('cong-viec')->group(function () {
                Route::name('task.')->group(function () {
                    Route::get('/', [ThongKecontroller::class, 'indexCongViec'])->name('list');
                    Route::get('/chi-tiet/{sdt}', [ThongKecontroller::class, 'detail'])->name('detail');
                    Route::get('/load-ajax-statistic-task', [ThongKeController::class, 'loadAjaxstatisticTask'])->name('load_ajax_statistic_task');
                    Route::get('/load-ajax-detail-statistic-task', [ThongKeController::class, 'loadAjaxDetailstatisticTask'])->name('load_ajax_detail_statistic_task');
                });
            });
            Route::prefix('khach-hang')->group(function () {
                Route::name('customer.')->group(function () {
                    Route::get('/', [ThongKecontroller::class, 'indexKhachHang'])->name('list');
                    Route::post('/load-ajax-statistic-customer', [ThongKeController::class, 'loadAjaxstatisticCustomer'])->name('load_ajax_statistic_customer');
                });
            });
        });
    });
    Route::prefix('du-an')->group(function () {
        Route::name('project.')->group(function () {
            Route::get('/them-moi', [ProjectController::class, 'create'])->name('create_project');
            Route::get('/autoComplete', [ProjectController::class, 'autoComplete'])->name('autoComplete');
            Route::post('/search', [ProjectController::class, 'search'])->name('search');
            Route::get('/cai-dat/{id}', [ProjectController::class, 'setting'])->name('setting');
            Route::post('/update-project', [ProjectController::class, 'update'])->name('update');
            Route::post('/create-project', [ProjectController::class, 'store'])->name('store');
            Route::post('/assign-project', [ProjectController::class, 'assign'])->name('assign');
            Route::post('/remove-user-project', [ProjectController::class, 'removeUser'])->name('remove_user');
            Route::post('/user-in-work', [ProjectController::class, 'userInWork'])->name('user_in_work');
            Route::post('/out-project', [ProjectController::class, 'outProject'])->name('out_project');
            Route::post('/delete-project', [ProjectController::class, 'deleteProject'])->name('delete_project');
            Route::get('/chinh-sua/{id}', [ProjectController::class, 'edit'])->name('edit');
            Route::get('/', [ProjectController::class, 'index'])->name('list');
            Route::post('/load-ajax-user', [ProjectController::class, 'loadAjaxUser'])->name('load_ajax_user');
        });
        Route::name('task.')->group(function () {
            // Route::get('/create', [ProjectController::class, 'create'])->name('create');
            Route::post('/create', [ScrumBoardController::class, 'store'])->name('store');
            Route::post('/save-assign', [ScrumBoardController::class, 'assign'])->name('assign');
            Route::post('/delete-assign', [ScrumBoardController::class, 'deleteAssign'])->name('delete_assign');
            Route::post('/comment', [ScrumBoardController::class, 'comment'])->name('comment');
            Route::post('/edit-comment', [ScrumBoardController::class, 'editComment'])->name('edit_comment');
            Route::post('/delete-comment', [ScrumBoardController::class, 'deleteComment'])->name('delete_comment');
            Route::post('/delete-file', [ScrumBoardController::class, 'deleteFile'])->name('delete_file');
            Route::get('/chi-tiet', [ScrumBoardController::class, 'detailTask'])->name('detail_task');
            Route::get('/{id}/thung-rac', [ScrumBoardController::class, 'trash'])->name('trash');
            Route::post('/create-list', [ScrumBoardController::class, 'store_list'])->name('store_list');
            Route::post('/edit_list', [ScrumBoardController::class, 'edit_list'])->name('edit_list');
            Route::post('/clear_all', [ScrumBoardController::class, 'clear_all'])->name('clear_all');
            Route::post('/move', [ScrumBoardController::class, 'move'])->name('move');
            Route::post('/destroy-list', [ScrumBoardController::class, 'destroy_list'])->name('destroy_list');
            Route::post('/destroy', [ScrumBoardController::class, 'destroy'])->name('destroy');
            Route::post('/update-deription-task', [ScrumBoardController::class, 'updateDeriptionTask'])->name('update_deription_task');
            Route::post('/update-name-task', [ScrumBoardController::class, 'updateNameTask'])->name('update_name_task');
            Route::post('/upload-file', [ScrumBoardController::class, 'uploadFile'])->name('upload_file');
            Route::post('/change-prioriy', [ScrumBoardController::class, 'changePriority'])->name('change_priority');
            Route::post('/save-deadline', [ScrumBoardController::class, 'saveDeadline'])->name('save_deadline');
            Route::post('/change-status-task', [ScrumBoardController::class, 'changeStatusTask'])->name('change_status_task');
            Route::get('{id}/cong-viec', [ScrumBoardController::class, 'list'])->name('list');
            Route::get('/load-ajax-list-task-trash', [ScrumBoardController::class, 'loadAjaxListTaskTrash'])->name('load_ajax_list_tasktrash');
            Route::post('/khoi-phuc', [ScrumBoardController::class, 'restore'])->name('restore');
            Route::post('/khoi-phuc-all', [ScrumBoardController::class, 'restores'])->name('restores');
            Route::post('/xoa-vv', [ScrumBoardController::class, 'forceDelete'])->name('forceDelete');
            Route::post('/xoa-vv-all', [ScrumBoardController::class, 'forceDeletes'])->name('forceDeletes');

            
        });

        Route::get('/check-in', [TimesheetController::class, 'checkIn'])->name('check-in');
        Route::get('/auth-checkin', [TimesheetController::class, 'authCheckin'])->name('auth-checkin');
        Route::get('/checkout', [TimesheetController::class, 'checkout'])->name('checkout');
        Route::get('/checkout-at', [TimesheetController::class, 'checkoutAt'])->name('checkout-at');
    });
    Route::name('dashboard.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('list');
        Route::get('/load-ajax-list-user', [HomeController::class, 'loadAjaxListUser'])->name('load_ajax_list_user');
        Route::get('/load-ajax-list-annual-leave', [HomeController::class, 'loadAjaxListAnnualLeave'])->name('load_ajax_list_annual_leave');
    });

    Route::prefix('nguoi-dung')->group(function () {
        Route::name('user.')->group(function () {
            // Route::group(['middleware' => ['role_or_permission:Super Admin|Thêm mới người dùng']], function () { 
                Route::get('/them-moi', [UserController::class, 'create'])->name('create');
                Route::post('/them-moi', [UserController::class, 'store'])->name('store');
            // }); 
            Route::group(['middleware' => ['role_or_permission:Super Admin|Cập nhật nhân viên']], function () { 
                Route::get('/cap-nhat/{id}', [UserController::class, 'edit'])->name('edit');
                Route::post('/cap-nhat', [UserController::class, 'update'])->name('update');
            });
            // Route::group(['middleware' => ['role_or_permission:Super Admin|Xoá người dùng']], function () { 
                Route::post('/xoa', [UserController::class, 'destroy'])->name('destroy');

            // }); 
            Route::post('/update-password', [UserController::class, 'changePass'])->name('change_pass');
            Route::post('/show', [UserController::class, 'show'])->name('show');
            Route::group(['middleware' => ['role_or_permission:Super Admin|Danh sách nhân viên']], function () {
                Route::get('/', [UserController::class, 'index'])->name('list');
            }); 
            Route::get('/load-ajax-list-user', [UserController::class, 'loadAjaxListUser'])->name('load_ajax_list_user');
            Route::get('/load-filter-user', [UserController::class, 'loadFilterUser'])->name('load_filter_user');
            Route::get('/ma-nhan-vien', [UserController::class, 'getMaNhanVien'])->name('code');
        });
    });

    Route::prefix('phan-quyen')->group(function () {
        Route::name('role.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:Super Admin|Danh sách chức vụ']], function () {
                Route::get('/', [RoleController::class, 'index'])->name('list');
            }); 
            Route::group(['middleware' => ['role_or_permission:Super Admin|Thêm chức vụ']], function () {
                Route::get('/them-moi', [RoleController::class, 'create'])->name('create');
                Route::post('/them-moi', [RoleController::class, 'store'])->name('store');
            }); 
            Route::group(['middleware' => ['role_or_permission:Super Admin|Xóa chức vụ']], function () {
                Route::post('/xoa', [RoleController::class, 'destroy'])->name('destroy');
            });
            Route::group(['middleware' => ['role_or_permission:Super Admin|Cập nhật chức vụ']], function () {
                Route::get('/cap-nhat/{id}', [RoleController::class, 'edit'])->name('edit');
                Route::post('/cap-nhat', [RoleController::class, 'update'])->name('update');
            });
            Route::get('/load-ajax-list-role', [RoleController::class, 'loadAjaxListRole'])->name('load_ajax_list_role');
        });
    });

    Route::prefix('phong-ban')->group(function () {
        Route::name('department.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:Super Admin|Danh sách phòng ban']], function () {
                Route::get('/', [DepartmentController::class, 'index'])->name('list');
            });
            Route::group(['middleware' => ['role_or_permission:Super Admin|Thêm phòng ban']], function () {
                Route::get('/them-moi', [DepartmentController::class, 'create'])->name('create');
                Route::post('/them-moi', [DepartmentController::class, 'store'])->name('store');
            });
            Route::group(['middleware' => ['role_or_permission:Super Admin|Xóa phòng ban']], function () {
                Route::post('/xoa', [DepartmentController::class, 'destroy'])->name('destroy');
            });
            Route::group(['middleware' => ['role_or_permission:Super Admin|Cập nhật phòng ban']], function () {
                Route::get('/cap-nhat/{id}', [DepartmentController::class, 'edit'])->name('edit');
                Route::post('/cap-nhat', [DepartmentController::class, 'update'])->name('update');
            });
            Route::get('/load-ajax-list-department', [DepartmentController::class, 'loadAjaxListDepartment'])->name('load_ajax_list_department');

        });
    });

    Route::prefix('nghi-phep')->group(function () {
        Route::name('annual_leave.')->group(function () {
            Route::get('/', [AnnualLeaveController::class, 'index'])->name('list');
            Route::get('/them-moi', [AnnualLeaveController::class, 'create'])->name('create');
            Route::post('/them-moi', [AnnualLeaveController::class, 'store'])->name('store');
            Route::get('/danh-sach-nghi-phep-cho-duyet', [AnnualLeaveController::class, 'waitingListForApproval'])->name('waiting_list_for_approval');
            Route::get('/chap-nhan-don-xin-nghi-phep/{id}', [AnnualLeaveController::class, 'approveLeaveApplication'])->name('approve_leave_application');
            Route::get('/load-ajax-danh-sach-nghi-phep-cho-duyet', [AnnualLeaveController::class, 'loadAjaxWaitingListForApproval'])->name('load_ajax_waiting_list_for_approval');
            Route::post('/xoa', [AnnualLeaveController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [AnnualLeaveController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [AnnualLeaveController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [AnnualLeaveController::class, 'loadAjaxListAnnualLeave'])->name('load_ajax_list_annual_leave');
            Route::post('/cap-nhat/ly-do-khong-chap-nhan', [AnnualLeaveController::class, 'updateReason'])->name('reason_not_approving');
        });
    });
    Route::prefix('hop-dong')->group(function () {
        Route::name('contracts.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('list');
            Route::get('/them-moi', [ContactController::class, 'create'])->name('create');
            Route::post('/them-moi', [ContactController::class, 'store'])->name('store');
            Route::get('/them-moi/nhan-vien-moi', [ContactController::class, 'createNewUser'])->name('create_new_user');
            Route::post('/them-moi/nhan-vien-moi', [ContactController::class, 'storeNewUser'])->name('store_new_user');
            Route::get('/them-moi/nhan-vien-da-co', [ContactController::class, 'createOldUser'])->name('create_old_user');
            Route::post('/them-moi/nhan-vien-da-co', [ContactController::class, 'storeOldUser'])->name('store_old_user');
            Route::post('/xoa', [ContactController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [ContactController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [ContactController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-contract', [ContactController::class, 'loadAjaxListContract'])->name('load_ajax_list_contracts');
            Route::get('/ma-hoa-don', [ContactController::class, 'getMaHoaDon'])->name('code');
            Route::get('/danh-sach-hop-dong-sap-het-han', [ContactController::class, 'contractIsAboutToExpire'])->name('contract_is_about_to_expire');
            Route::get('/load-ajax-is-about-to-expire', [ContactController::class, 'loadAjaxContractIsAboutToExpire'])->name('load_ajax_contract_is_about_to_expire');
            
            Route::get('/danh-sach-nguoi-dung', [ContractExtensionController::class, 'index'])->name('list_user');
            Route::get('/load-ajax-list-user', [ContractExtensionController::class, 'loadAjaxListUser'])->name('load_ajax_list_user');
            Route::get('/load-filter-user', [ContractExtensionController::class, 'loadFilterUser'])->name('load_filter_user');
            Route::get('/nguoi-dung/{id}', [ContractExtensionController::class, 'contractOfUser'])->name('list_contract_of_user');
            Route::get('/load-ajax-list-contract-of-user', [ContractExtensionController::class, 'loadAjaxListContractOfUser'])->name('load_ajax_list_contract_of_user');
            Route::get('/nguoi-dung/gia-han/{id}', [ContractExtensionController::class, 'renewPage'])->name('renew_page');
            Route::post('/nguoi-dung/gia-han', [ContractExtensionController::class, 'renew'])->name('renew');
            Route::get('/nguoi-dung/{id}/cap-nhat/{contract_id}', [ContractExtensionController::class, 'edit'])->name('edit_renew');
            Route::post('/nguoi-dung/cap-nhat', [ContractExtensionController::class, 'update'])->name('update_renew');
        });
    });

    Route::prefix('luong')->group(function () {
        Route::name('salary.')->group(function () {
            Route::get('/', [SalaryController::class, 'index'])->name('list');
            Route::get('/them-moi', [SalaryController::class, 'create'])->name('create');
            Route::post('/them-moi', [SalaryController::class, 'store'])->name('store');
            Route::post('/xoa', [SalaryController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [SalaryController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [SalaryController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [SalaryController::class, 'loadAjaxListSalary'])->name('load_ajax_list_salary');
            Route::post('/show', [SalaryController::class, 'show'])->name('show');

        });
    });

    Route::prefix('khen-thuong')->group(function () {
        Route::name('bonus.')->group(function () {
            Route::get('/', [BonusController::class, 'index'])->name('list');
            Route::get('/them-moi', [BonusController::class, 'create'])->name('create');
            Route::post('/them-moi', [BonusController::class, 'store'])->name('store');
            Route::post('/xoa', [BonusController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [BonusController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [BonusController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-bonus', [BonusController::class, 'loadAjaxListBonus'])->name('load_ajax_list_bonus');
            Route::post('/show', [BonusController::class, 'show'])->name('show');

        });
    });

    Route::prefix('xu-phat')->group(function () {
        Route::name('discipline.')->group(function () {
            Route::get('/', [DisciplineController::class, 'index'])->name('list');
            Route::get('/them-moi', [DisciplineController::class, 'create'])->name('create');
            Route::post('/them-moi', [DisciplineController::class, 'store'])->name('store');
            Route::post('/xoa', [DisciplineController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [DisciplineController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [DisciplineController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-discipline', [DisciplineController::class, 'loadAjaxListDiscipline'])->name('load_ajax_list_discipline');
            Route::post('/show', [DisciplineController::class, 'show'])->name('show');
        });
    });

    Route::prefix('bang-luong')->group(function () {
        Route::name('pay_salaries.')->group(function () {
            Route::get('/', [PaySalarieController::class, 'index'])->name('list');
            Route::get('/them-moi', [PaySalarieController::class, 'create'])->name('create');
            Route::post('/them-moi', [PaySalarieController::class, 'store'])->name('store');
            Route::post('/xoa', [PaySalarieController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [PaySalarieController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [PaySalarieController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [PaySalarieController::class, 'loadAjaxListPaySalaries'])->name('load_ajax_list_pay_salaries');
            Route::get('/exporting-paysalary/{id}', [PaySalarieController::class, 'exportPaySalary'])->name('exporting_paysalary');
            Route::get('/send-mail/{id}', [SendMailSalaryController::class, 'viewMail'])->name('view_send_mail');
            Route::post('/send-mail', [SendMailSalaryController::class, 'sendEmail'])->name('send_mail');
            Route::post('/exporting-of-department', [PaySalarieController::class, 'exportPaySalaryOfDepartment'])->name('exporting_pay_salaries_of_department');
        });
    });

    Route::prefix('cham-cong')->group(function () {
        Route::name('Timesheet.')->group(function () {
            Route::get('/', [TimesheetController::class, 'index'])->name('list');
            Route::get('/search', [TimesheetController::class, 'search'])->name('search');

                Route::get('/danh-sach-thoi-gian-di-lam', [TimesheetController::class, 'listTimesheet'])->name('list_timesheet');
                Route::get('/load-ajax-danh-sach-thoi-gian-di-lam-trong-thang', [TimesheetController::class, 'loadAjaxListTimesheetAcctance'])->name('load_ajax_list_Timesheet_Acctance');
                // Route::get('/cap-nhat/{id}', [TimesheetController::class, 'edit'])->name('edit');
                Route::get('/duyet/{id}', [TimesheetController::class, 'approve'])->name('approve');
                Route::get('/huy-duyet/{id}', [TimesheetController::class, 'cancelApproval'])->name('cancelApproval');

                Route::post('/them-moi', [TimesheetController::class, 'store'])->name('store');

                // Route::post('/xoa', [TimesheetController::class, 'destroy'])->name('destroy');

            Route::get('/load-ajax-list-annual-leave', [TimesheetController::class, 'loadAjaxListTimesheet'])->name('load_ajax_list_Timesheet');
            Route::get('/exporting-timesheet/{id}/{time}', [TimesheetController::class, 'exportTimesheet'])->name('export_timesheet');
            Route::post('/exporting-of-department', [TimesheetController::class, 'exportTimesheetOfDepartment'])->name('exporting_timesheet_of_department');
        });
    });
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/scrumboard', [ScrumBoardController::class, 'list'])->name('scrumboard');
  
    Route::prefix('tai-khoan')->group(function () {
        Route::name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'list'])->name('list');
            Route::post('/update-avartar', [ProfileController::class, 'UpdateAvt'])->name('update_avt');
            Route::post('/update', [ProfileController::class, 'Update'])->name('update');
            Route::post('/thay-doi-mat-khau', [ProfileController::class, 'updatePass'])->name('update_pass');
        });
    });
    Route::prefix('khach-hang')->group(function () {
        Route::name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('list');
            Route::get('/them-moi', [CustomerController::class, 'create'])->name('create');
            Route::post('/them-moi', [CustomerController::class, 'store'])->name('store');
            Route::post('/xoa', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [CustomerController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [CustomerController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-customer', [CustomerController::class, 'loadAjaxListCustomer'])->name('load_ajax_list_customer');
            Route::post('/gui-email', [CustomerController::class, 'sendemail'])->name('send_email');
            // Route::post('/update-khach-hang', [CustomerController::class, 'UpdateAvt'])->name('update_avt');
            // Route::post('/update', [CustomerController::class, 'Update'])->name('update');
            // Route::post('/thay-doi-mat-khau', [CustomerController::class, 'updatePass'])->name('update_pass');
        });
    });
    
    Route::prefix('tam-ung-phu-cap')->group(function () {
        Route::name('advance_allowance.')->group(function () {
            Route::get('/', [AdvanceAllowanceController::class, 'index'])->name('list');
            Route::get('/them-moi', [AdvanceAllowanceController::class, 'create'])->name('create');
            Route::post('/them-moi', [AdvanceAllowanceController::class, 'store'])->name('store');
            Route::post('/xoa', [AdvanceAllowanceController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [AdvanceAllowanceController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [AdvanceAllowanceController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-department', [AdvanceAllowanceController::class, 'loadAjaxListAdvanceAllowance'])->name('load_ajax_list_advance_allowance');

        });
    });

    Route::prefix('cau-hinh')->group(function () {
        Route::name('config.')->group(function () {
            Route::get('/cap-nhat', [ConfigController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [ConfigController::class, 'update'])->name('update');
        });
    });

});


Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', function () {
        return view('modules.authentication.login');
    })->name("login");
    Route::post('/dang-nhap', [HomeController::class, 'doLogin'])->name('do_login');
});

Route::get('/register', function () {
    return view('modules.authentication.register');
})->name('register');

Route::get('auth/redirect/{provider}', [UserController::class, 'redirect']);
Route::get('callback/{provider}', [UserController::class, 'callback']);
Route::get('/check-role', [UserController::class, 'checkRole'])->name('checkRole');
Route::get('/send-message', function (Request $request) {
    event(
        new Message($request->input("username"),$request->input("message"),$request->input("task_id"))
    );
});

Route::get('/forget-password', function (){
    return view('modules.authentication.otp');
})->name('forget-password');

