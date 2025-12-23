<?php

use App\Http\Controllers\Principal\AlumniController;
use App\Http\Controllers\Principal\AssignmentController;
use App\Http\Controllers\Principal\AttendanceController;
use App\Http\Controllers\Principal\AttendanceRegisterController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Principal\CollectiveTestController;
use App\Http\Controllers\Principal\InchargeController;
use App\Http\Controllers\Principal\ScheduleController;
use App\Http\Controllers\Principal\SectionCardController;
use App\Http\Controllers\Principal\SectionController as AdminSectionController;
use App\Http\Controllers\Principal\SectionResultController;
use App\Http\Controllers\Principal\SectionWiseScheduleController;
use App\Http\Controllers\Principal\StudentController;
use App\Http\Controllers\Principal\SubjectController;
use App\Http\Controllers\Principal\TaskController;
use App\Http\Controllers\Principal\UserCardController;
use App\Http\Controllers\Principal\UserController as AdminuserController;
use App\Http\Controllers\Principal\UserWiseScheduleController;
use App\Http\Controllers\Principal\TestAllocationController as AdminTestAllocationController;
use App\Http\Controllers\Principal\TestSectionController as AdminTestSectionController;
use App\Http\Controllers\Principal\UserController;
use App\Http\Controllers\Principal\UserRoleController;
use App\Http\Controllers\Principal\VoucherController;
use App\Http\Controllers\Principal\VoucherPayerController;
use App\Http\Controllers\Admission\PdfController;
use App\Http\Controllers\AlumniController as ControllersAlumniController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\PdfController as ControllersPdfController;
use App\Http\Controllers\Principal\DashboardController as PrincipalDashboardController;
use App\Http\Controllers\Principal\PdfController as PrincipalPdfController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\ResultDetailController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SubjectResultController;
use App\Http\Controllers\User\StudentController as userStudentController;
use App\Http\Controllers\User\ImportStudentController;
use App\Http\Controllers\User\TestAllocationController;
use App\Http\Controllers\User\TestAllocationResultController;
use App\Http\Controllers\User\TestController;
use App\Http\Controllers\TestPositionController;
use App\Http\Controllers\User\AttendanceController as userAttendanceController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FeeController;
use App\Http\Controllers\User\MyScheduleController;
use App\Http\Controllers\User\TaskController as userTaskController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(session('role'));
    } else {
        $events = Event::latest()->take(3)->get();
        return view('index', compact('events'));
    }
});


Route::view('about', 'about');
Route::view('contact', 'contact');
Route::get('gallary', [GallaryController::class, 'index']);

Route::view('login', 'login');
Route::get('switch/as/{role}', [UserController::class, 'switchAs']);

Route::resource('signup', SignupController::class);
Route::view('signup-success', 'signup-success');

Route::view('forgot', 'forgot');
Route::post('forgot', [AuthController::class, 'forgot']);

Route::post('login', [AuthController::class, 'login']);

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');
Route::resource('faculty', FacultyController::class)->only('index', 'create', 'store');
Route::resource('alumni', ControllersAlumniController::class)->only('index', 'create', 'store');;

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'principal', 'as' => 'principal.', 'middleware' => ['role:principal']], function () {
        Route::get('/', [PrincipalDashboardController::class, 'index']);
        Route::resource('subjects', SubjectController::class);
        Route::resource('alumni', AlumniController::class);
        Route::resource('sections', AdminSectionController::class);
        Route::resource('events', EventController::class);
        Route::resource('users', AdminuserController::class);
        Route::resource('vouchers', VoucherController::class);
        Route::resource('user.roles', UserRoleController::class);

        Route::resource('voucher.section.payers', VoucherPayerController::class);
        Route::get('voucher/{voucher}/section/{section}/missing/import', [VoucherPayerController::class, 'import'])->name('voucher.section.payers.import');
        Route::post('voucher/{voucher}/section/{section}/missing/import', [VoucherPayerController::class, 'postImport'])->name('voucher.section.payers.import.post');
        Route::delete('voucher/{voucher}/section/{section}/clean', [VoucherPayerController::class, 'postClean'])->name('voucher.section.payers.clean');

        Route::resource('section.lecture.schedule', ScheduleController::class);
        Route::get('class-schedule', [SectionWiseScheduleController::class, 'index'])->name('class-schedule');
        Route::get('class-schedule/print', [SectionWiseScheduleController::class, 'print'])->name('class-schedule.print');
        Route::post('class-schedule/post', [SectionWiseScheduleController::class, 'post'])->name('class-schedule.post');
        Route::post('class-schedule/clear', [SectionWiseScheduleController::class, 'clear']);

        Route::get('user-schedule', [userWiseScheduleController::class, 'index'])->name('user-schedule');
        Route::get('user-schedule/print', [userWiseScheduleController::class, 'print'])->name('user-schedule.print');
        Route::post('user-schedule/post', [userWiseScheduleController::class, 'post'])->name('user-schedule.post');

        Route::get('sections/{section}/clean', [AdminSectionController::class, 'clean'])->name('sections.clean');
        Route::get('section/{section}/reset-index', [AdminSectionController::class, 'resetIndex'])->name('sections.reset');
        Route::post('section/{section}/reset-rollno', [AdminSectionController::class, 'resetRollNo'])->name('sections.reset.rollno');
        Route::post('section/{section}/reset-admission-no', [AdminSectionController::class, 'resetAdmNo'])->name('sections.reset.admno');
        Route::post('sections/{section}/clean', [AdminSectionController::class, 'postClean'])->name('sections.clean.post');
        Route::resource('section.students', StudentController::class);
        Route::resource('section.cards', SectionCardController::class);
        Route::get('section/student-cards/print', [SectionCardController::class, 'print'])->name('section.cards.print');

        Route::resource('user-cards', userCardController::class);
        Route::get('users-cards/print', [PrincipalPdfController::class, 'printuserCards'])->name('user-cards.print');

        Route::get('sections/import/{section}', [AdminSectionController::class, 'import'])->name('sections.import');
        Route::post('sections/import', [AdminSectionController::class, 'postImport'])->name('sections.import.post');

        Route::get('sections/{section}/export', [AdminSectionController::class, 'export'])->name('sections.export');
        Route::post('sections/export', [AdminSectionController::class, 'postExport'])->name('sections.export.post');

        Route::view('change/password', 'principal.change_password');
        Route::post('change/password', [AuthController::class, 'changePassword'])->name('change.password');

        Route::resource('users', UserController::class);
        Route::resource('incharges', InchargeController::class);
        Route::resource('tests', CollectiveTestController::class);
        Route::resource('test.sections', AdminTestSectionController::class);
        Route::resource('test.section.results', SectionResultController::class);
        Route::resource('test.allocations', AdminTestAllocationController::class);

        // lock /unlock
        Route::patch('test/{id}/lock', [CollectiveTestController::class, 'lock'])->name('test.lock');
        Route::patch('test/{id}/unlock', [CollectiveTestController::class, 'unlock'])->name('test.unlock');
        Route::patch('test-allocation/{id}/lock', [AdminTestAllocationController::class, 'lock'])->name('test-allocation.lock');
        Route::patch('test-allocation/{id}/unlock', [AdminTestAllocationController::class, 'unlock'])->name('test-allocation.unlock');

        // print
        // Route::get('test-allocation/{id}/result/print', [SubjectResultController::class, 'print'])->name('test-allocation.result.print');

        Route::get('test/{t}/section/{s}/result/print', [ResultDetailController::class, 'print'])->name('test.section.result.print');
        Route::get('test/{t}/section/{s}/positions/print', [TestPositionController::class, 'print'])->name('test.section.positions.print');
        Route::get('test/{t}/section/{s}/report-cards/print', [ReportCardController::class, 'print'])->name('test.section.report-cards.print');

        Route::get('sections/{section}/print', [AdminSectionController::class, 'print'])->name('sections.print');
        Route::get('sections/{section}/print/phone-list', [PrincipalPdfController::class, 'printPhoneList'])->name('sections.print.phoneList');
        Route::get('sections/{section}/print/attendance-list', [ControllersPdfController::class, 'printAttendanceList'])->name('sections.print.attendanceList');
        Route::get('sections/{section}/print/student-detail', [PdfController::class, 'printStudentDetail'])->name('sections.print.studentDetail');
        Route::get('sections/{section}/print/orphan-list', [PdfController::class, 'printOrphanList'])->name('sections.print.orphanList');

        Route::resource('attendance', AttendanceController::class);
        Route::post('attendances/filter', [AttendanceController::class, 'filter'])->name('attendance.filter');
        Route::post('attendances/clear', [AttendanceController::class, 'clear'])->name('attendance.clear');
        Route::resource('tasks', TaskController::class);
        Route::resource('task.assignments', AssignmentController::class);
        Route::resource('attendance-register', AttendanceRegisterController::class);
        Route::get('attendanceByDate/{section}/{date}', [AttendanceController::class, 'attendanceByDate'])->name('attendance.byDate');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'role:user']], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('tests', TestController::class);
        Route::resource('students', userStudentController::class);
        Route::get('student-list/print', [userStudentController::class, 'print'])->name('students.print');
        Route::resource('my-schedule', MyScheduleController::class);
        Route::resource('test.test-allocations', TestAllocationController::class);
        Route::resource('test-allocation.results', TestAllocationResultController::class);
        Route::resource('test-allocation.import-students', ImportStudentController::class);
        Route::resource('section.attendance', userAttendanceController::class);
        Route::resource('section.fee', FeeController::class);
        Route::resource('tasks', userTaskController::class);
    });

    Route::group(['prefix' => 'shared', 'as' => 'shared.', 'middleware' => ['role:user|admin']], function () {
        Route::get('test-allocation/{id}/result/print', [SubjectResultController::class, 'print'])->name('test-allocation.result.print');
        Route::get('test/{t}/section/{s}/result/print', [ResultDetailController::class, 'print'])->name('test.section.result.print');
        Route::get('test/{t}/section/{s}/positions/print', [TestPositionController::class, 'print'])->name('test.section.positions.print');
        Route::get('test/{t}/section/{s}/report-cards/print', [ReportCardController::class, 'print'])->name('test.section.report-cards.print');
    });
});
