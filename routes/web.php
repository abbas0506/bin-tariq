<?php

use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AttendanceRegisterController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\CollectiveTestController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\InchargeController;
use App\Http\Controllers\Admin\PdfController as AdminPdfController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SectionCardController;
use App\Http\Controllers\Admin\SectionController as AdminSectionController;
use App\Http\Controllers\Admin\SectionResultController;
use App\Http\Controllers\Admin\SectionWiseScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeacherCardController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\TeacherWiseScheduleController;
use App\Http\Controllers\Admin\TestAllocationController as AdminTestAllocationController;
use App\Http\Controllers\Admin\TestSectionController as AdminTestSectionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\VoucherPayerController;
use App\Http\Controllers\Admission\PdfController;
use App\Http\Controllers\Admission\ApplicationController as AdmissionApplicationController;
use App\Http\Controllers\Admission\CardController;
use App\Http\Controllers\Admission\DashboardController;
use App\Http\Controllers\Admission\FeeController as AdmissionFeeController;
use App\Http\Controllers\Admission\ObjectionController as AdmissionObjectionController;
use App\Http\Controllers\Admission\RejectionController;
use App\Http\Controllers\Admission\SectionController;
use App\Http\Controllers\Admission\SectionStudentsController;
use App\Http\Controllers\AlumniController as ControllersAlumniController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\Library\BookController;
use App\Http\Controllers\Library\BookIssuanceController;
use App\Http\Controllers\Library\RackController;
use App\Http\Controllers\Library\BookReturnController;
use App\Http\Controllers\Library\DashboardController as LibraryDashboardController;
use App\Http\Controllers\Library\DomainBooksController;
use App\Http\Controllers\Library\DomainController;
use App\Http\Controllers\Library\LibraryRuleController;
use App\Http\Controllers\Library\PrintController;
use App\Http\Controllers\Library\RackBooksController;
use App\Http\Controllers\OnlineApplicationController;
use App\Http\Controllers\RejectionController\Admission;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\ResultDetailController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SubjectResultController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\ImportStudentController;
use App\Http\Controllers\Teacher\TestAllocationController;
use App\Http\Controllers\Teacher\TestAllocationResultController;
use App\Http\Controllers\Teacher\TestController;
use App\Http\Controllers\TestPositionController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\FeeController;
use App\Http\Controllers\Teacher\MyScheduleController;
use App\Http\Controllers\Teacher\TaskController as TeacherTaskController;
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

Route::resource('applications', AdmissionApplicationController::class);

Route::view('login', 'login');
Route::get('switch/as/{role}', [UserController::class, 'switchAs']);

Route::resource('signup', SignupController::class);
Route::view('signup-success', 'signup-success');

Route::view('forgot', 'forgot');
Route::post('forgot', [AuthController::class, 'forgot']);

Route::post('login', [AuthController::class, 'login']);

// Route::view('admission-25', 'admission.online-applications.instructions');
// Route::get('apply', [OnlineApplicationController::class, 'create']);
// Route::post('apply', [OnlineApplicationController::class, 'store']);
// Route::resource('online-applications', OnlineApplicationController::class);
// Route::get('applied/{application}', [OnlineApplicationController::class, 'applied'])->name('applied');

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');
Route::resource('faculty', FacultyController::class)->only('index', 'create', 'store');
Route::resource('alumni', ControllersAlumniController::class)->only('index', 'create', 'store');;

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::resource('groups', GroupController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('alumni', AlumniController::class);
        Route::resource('sections', AdminSectionController::class);
        Route::resource('events', EventController::class);
        Route::resource('teachers', AdminTeacherController::class);
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

        Route::get('teacher-schedule', [TeacherWiseScheduleController::class, 'index'])->name('teacher-schedule');
        Route::get('teacher-schedule/print', [TeacherWiseScheduleController::class, 'print'])->name('teacher-schedule.print');
        Route::post('teacher-schedule/post', [TeacherWiseScheduleController::class, 'post'])->name('teacher-schedule.post');

        Route::get('sections/{section}/clean', [AdminSectionController::class, 'clean'])->name('sections.clean');
        Route::get('section/{section}/reset-index', [AdminSectionController::class, 'resetIndex'])->name('sections.reset');
        Route::post('section/{section}/reset-rollno', [AdminSectionController::class, 'resetRollNo'])->name('sections.reset.rollno');
        Route::post('section/{section}/reset-admission-no', [AdminSectionController::class, 'resetAdmNo'])->name('sections.reset.admno');
        Route::post('sections/{section}/clean', [AdminSectionController::class, 'postClean'])->name('sections.clean.post');
        Route::resource('section.students', StudentController::class);
        Route::resource('section.cards', SectionCardController::class);
        Route::get('section/student-cards/print', [SectionCardController::class, 'print'])->name('section.cards.print');

        Route::resource('teacher-cards', TeacherCardController::class);
        Route::get('teachers-cards/print', [AdminPdfController::class, 'printTeacherCards'])->name('teacher-cards.print');

        Route::get('sections/import/{section}', [AdminSectionController::class, 'import'])->name('sections.import');
        Route::post('sections/import', [AdminSectionController::class, 'postImport'])->name('sections.import.post');

        Route::get('sections/{section}/export', [AdminSectionController::class, 'export'])->name('sections.export');
        Route::post('sections/export', [AdminSectionController::class, 'postExport'])->name('sections.export.post');

        Route::view('change/password', 'admin.change_password');
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
        Route::get('sections/{section}/print/phone-list', [PdfController::class, 'printPhoneList'])->name('sections.print.phoneList');
        Route::get('sections/{section}/print/attendance-list', [PdfController::class, 'printAttendanceList'])->name('sections.print.attendanceList');
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

    Route::group(['prefix' => 'admission', 'as' => 'admission.', 'middleware' => ['role:admission']], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('applications', AdmissionApplicationController::class);
        Route::patch('/applications/{application}/accept', [AdmissionApplicationController::class, 'accept'])->name('applications.accept');
        Route::patch('/applications/{application}/reject', [AdmissionApplicationController::class, 'reject'])->name('applications.reject');
        Route::patch('/applications/{application}/admit', [AdmissionApplicationController::class, 'admit'])->name('applications.admit');
        Route::resource('fee', AdmissionFeeController::class);
        Route::resource('objections', AdmissionObjectionController::class);

        Route::resource('rejections', RejectionController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('section.students', SectionStudentsController::class);

        Route::get('print/fee', [PdfController::class, 'printFee'])->name('print.fee');
        Route::get('print/objections', [PdfController::class, 'printObjections'])->name('print.objections');
    });

    Route::group(
        ['prefix' => 'library', 'as' => 'library.', 'middleware' => ['role:library']],
        function () {
            Route::get('/', [LibraryDashboardController::class, 'index']);
            Route::resource('books', BookController::class);
            Route::resource('domains', DomainController::class);
            Route::resource('domain.books', DomainBooksController::class);
            Route::resource('racks', RackController::class);
            Route::resource('rack.books', RackBooksController::class);
            Route::resource('library-rules', LibraryRuleController::class);
            // Route::resource('teachers', LibraryTeacherController::class);

            Route::get('print', [PrintController::class, 'index']);

            Route::get('print/teachers/list', [PrintController::class, 'printTeachersList'])->name('print.teachers.list');
            Route::get('print/rack-books/{rack}/list', [PrintController::class, 'printRackBooksList'])->name('print.rack-books.list');

            Route::get('print/teachers/qr', [PrintController::class, 'printTeachersQr'])->name('print.teachers.qr');
            Route::get('print/rack-books/{rack}/qr', [PrintController::class, 'printRackBooksQr'])->name('print.rack-books.qr');
            Route::get('print/specific-qr', [PrintController::class, 'printSpecificQr'])->name('print.specific-qr');

            Route::get('book-issuance/scan', [BookIssuanceController::class, 'scan'])->name('book-issuance.scan');
            Route::post('book-issuance/scan', [BookIssuanceController::class, 'postScan'])->name('book-issuance.scan.post');
            Route::get('book-issuance/confirm', [BookIssuanceController::class, 'confirm'])->name('book-issuance.confirm');
            Route::post('book-issuance/confirm', [BookIssuanceController::class, 'postConfirm'])->name('book-issuance.confirm.post');
            Route::get('book-issuance/issued', [BookIssuanceController::class, 'issued'])->name('book-issuance.issued');
            Route::get('book-issuance/delayed', [BookIssuanceController::class, 'delayed'])->name('book-issuance.delayed');
            Route::get('book-issuance/default', [BookIssuanceController::class, 'default'])->name('book-issuance.default');

            Route::get('book-return/scan', [BookReturnController::class, 'scan'])->name('book-return.scan');
            Route::post('book-return/scan', [BookReturnController::class, 'postScan'])->name('book-return.scan.post');
            Route::get('book-return/confirm', [BookReturnController::class, 'confirm'])->name('book-return.confirm');
            Route::patch('book-return/confirm/{book_issuance}', [BookReturnController::class, 'postConfirm'])->name('book-return.confirm.post');
        }
    );

    Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['auth', 'role:teacher']], function () {
        Route::get('/', [TeacherDashboardController::class, 'index']);
        Route::resource('tests', TestController::class);
        Route::resource('students', TeacherStudentController::class);
        Route::get('student-list/print', [TeacherStudentController::class, 'print'])->name('students.print');
        Route::resource('my-schedule', MyScheduleController::class);
        Route::resource('test.test-allocations', TestAllocationController::class);
        Route::resource('test-allocation.results', TestAllocationResultController::class);
        Route::resource('test-allocation.import-students', ImportStudentController::class);
        Route::resource('section.attendance', TeacherAttendanceController::class);
        Route::resource('section.fee', FeeController::class);
        Route::resource('tasks', TeacherTaskController::class);
    });

    Route::group(['prefix' => 'shared', 'as' => 'shared.', 'middleware' => ['role:teacher|admin']], function () {
        Route::get('test-allocation/{id}/result/print', [SubjectResultController::class, 'print'])->name('test-allocation.result.print');
        Route::get('test/{t}/section/{s}/result/print', [ResultDetailController::class, 'print'])->name('test.section.result.print');
        Route::get('test/{t}/section/{s}/positions/print', [TestPositionController::class, 'print'])->name('test.section.positions.print');
        Route::get('test/{t}/section/{s}/report-cards/print', [ReportCardController::class, 'print'])->name('test.section.report-cards.print');
    });
});
