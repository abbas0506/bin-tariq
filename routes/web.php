<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CollectiveTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\ResultDetailController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SectionAttendanceController;
use App\Http\Controllers\SectionCardController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionResultController;
use App\Http\Controllers\SectionScheduleController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectResultController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestPositionController;
use App\Http\Controllers\TestSectionController;
use App\Http\Controllers\TestAllocationController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserScheduleController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherPayerController;
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
        return redirect('dashboard');
    } else {
        $events = Event::latest()->take(3)->get();
        return view('index', compact('events'));
    }
});


// Route::view('/', '');
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::resource('users', UserController::class);
    Route::resource('user.roles',  UserRoleController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('sections', SectionController::class);

    Route::resource('vouchers', VoucherController::class);
    Route::resource('voucher.section.payers', VoucherPayerController::class);
    Route::get('voucher/{voucher}/section/{section}/missing/import', [VoucherPayerController::class, 'import'])->name('voucher.section.payers.import');
    Route::post('voucher/{voucher}/section/{section}/missing/import', [VoucherPayerController::class, 'postImport'])->name('voucher.section.payers.import.post');
    Route::delete('voucher/{voucher}/section/{section}/clean', [VoucherPayerController::class, 'postClean'])->name('voucher.section.payers.clean');

    Route::get('sections/list/{page}', [SectionController::class, 'list'])->name('sections.list');
    Route::resource('section.fee', FeeController::class);
    Route::resource('section.students', StudentController::class);
    Route::get('sections/import/{section}', [SectionController::class, 'import'])->name('sections.import');
    Route::post('sections/import', [SectionController::class, 'postImport'])->name('sections.import.post');

    Route::get('sections/{section}/export', [SectionController::class, 'export'])->name('sections.export');
    Route::post('sections/export', [SectionController::class, 'postExport'])->name('sections.export.post');
    Route::get('sections/{section}/clean', [SectionController::class, 'clean'])->name('sections.clean');
    Route::get('section/{section}/reset-index', [SectionController::class, 'resetIndex'])->name('sections.reset');
    Route::post('section/{section}/reset-rollno', [SectionController::class, 'resetRollNo'])->name('sections.reset.rollno');
    Route::post('sections/{section}/clean', [SectionController::class, 'postClean'])->name('sections.clean.post');

    Route::resource('section.cards', SectionCardController::class);
    Route::get('section/cards/{section}/print', [SectionCardController::class, 'print'])->name('section.cards.print');

    // schedule
    Route::resource('section.lecture.schedule', ScheduleController::class);
    Route::get('class-schedule', [SectionScheduleController::class, 'index'])->name('class-schedule');
    Route::get('class-schedule/print', [SectionScheduleController::class, 'print'])->name('class-schedule.print');
    Route::post('class-schedule/post', [SectionScheduleController::class, 'post'])->name('class-schedule.post');
    Route::post('class-schedule/clear', [SectionScheduleController::class, 'clear']);
    Route::get('user-schedule', [UserScheduleController::class, 'index'])->name('user-schedule');
    Route::get('user-schedule/view', [UserScheduleController::class, 'show'])->name('user-schedule.show');
    Route::get('user-schedule/print', [UserScheduleController::class, 'print'])->name('user-schedule.print');
    Route::post('user-schedule/post', [UserScheduleController::class, 'post'])->name('user-schedule.post');

    // attendance
    Route::get('attendance/summary', [SectionAttendanceController::class, 'summary'])->name('attendance.summary');
    Route::get('attendance/filter', [SectionAttendanceController::class, 'filter'])->name('attendance.filter');
    Route::post('attendances/filter', [SectionAttendanceController::class, 'filter'])->name('attendance.filter');
    Route::resource('section.attendance', SectionAttendanceController::class);

    // assessment
    Route::resource('tests', CollectiveTestController::class);
    Route::resource('test.sections', TestSectionController::class);
    Route::resource('test.section.results', SectionResultController::class);
    Route::resource('test.allocations', TestAllocationController::class);

    // lock /unlock
    Route::patch('test/{id}/lock', [CollectiveTestController::class, 'lock'])->name('test.lock');
    Route::patch('test/{id}/unlock', [CollectiveTestController::class, 'unlock'])->name('test.unlock');
    Route::patch('test-allocation/{id}/lock', [TestAllocationController::class, 'lock'])->name('test-allocation.lock');
    Route::patch('test-allocation/{id}/unlock', [TestAllocationController::class, 'unlock'])->name('test-allocation.unlock');

    Route::get('test/{t}/section/{s}/result/print', [ResultDetailController::class, 'print'])->name('test.section.result.print');
    Route::get('test/{t}/section/{s}/positions/print', [TestPositionController::class, 'print'])->name('test.section.positions.print');
    Route::get('test/{t}/section/{s}/report-cards/print', [ReportCardController::class, 'print'])->name('test.section.report-cards.print');

    Route::resource('tasks', TaskController::class);
    Route::resource('task.assignments', AssignmentController::class);
});



Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'principal', 'as' => 'principal.', 'middleware' => ['role:principal']], function () {
        Route::get('/', [PrincipalDashboardController::class, 'index']);
        Route::resource('user-cards', userCardController::class);
        Route::get('users-cards/print', [PrincipalPdfController::class, 'printuserCards'])->name('user-cards.print');


        Route::view('change/password', 'change_password');
        Route::post('change/password', [AuthController::class, 'changePassword'])->name('change.password');

        // Route::resource('users', userController::class);
        Route::resource('incharges', InchargeController::class);


        Route::get('sections/{section}/print/phone-list', [PrincipalPdfController::class, 'printPhoneList'])->name('sections.print.phoneList');
        Route::get('sections/{section}/print/attendance-list', [ControllersPdfController::class, 'printAttendanceList'])->name('sections.print.attendanceList');
        Route::get('sections/{section}/print/student-detail', [PdfController::class, 'printStudentDetail'])->name('sections.print.studentDetail');
        Route::get('sections/{section}/print/orphan-list', [PdfController::class, 'printOrphanList'])->name('sections.print.orphanList');
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
