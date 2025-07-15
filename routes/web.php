<?php

use App\Http\Controllers\Acounting\AccountingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgeLimitController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\Front\ApplicantPreview\CorrectApplicantController;
use App\Http\Controllers\Front\OfferingCourse\OfferingCourseController;
use App\Http\Controllers\Front\Dashboard\DashboardController;
use App\Http\Controllers\Front\Phases\AptitudeController;

use App\Http\Controllers\Front\Phases\DocumentationController;
use App\Http\Controllers\Front\Phases\InterviewController;

use App\Http\Controllers\Front\Profile\ProfileController;
use App\Http\Controllers\Front\Reports\ReportGenerationController;
use App\Http\Controllers\Front\School\BeceResultController;
use App\Http\Controllers\Front\School\BeceSubjectController;
use App\Http\Controllers\Front\School\WassceResultController;
use App\Http\Controllers\Front\School\WassceSubjectController;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RolesandPermission\RolesAndPermissionController;
use App\Http\Controllers\Useraccount\UserAccountController;
use App\Http\Controllers\Lecturer\LecturerHomeController;
use App\Http\Controllers\Lecturer\LecturerCourseController;
use App\Http\Controllers\Lecturer\LecturerAssignmentController;
use App\Http\Controllers\Lecturer\LecturerQuizzesController;
use App\Http\Controllers\Lecturer\LecturerExamsController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Student\StudentAssignmentController;
use App\Http\Controllers\Student\StudentAccountController;
use App\Http\Controllers\Student\StudentTimetableController;
use App\Http\Controllers\Student\StudentResultSlipController;
use App\Http\Controllers\Student\StudentContactController;
use App\Http\Controllers\Student\StudentFAQsController;
use App\Http\Controllers\Frontend\FrontendController;


use App\Http\Controllers\Admin\AdminHomeController;

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminAssignmentController;
use App\Http\Controllers\Admin\AdminScoresController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminCoursePackagingController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\Front\Phases\BodySelectionController;
use App\Http\Controllers\Front\Phases\MedicalsController;
use App\Http\Controllers\Front\Phases\VettingController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PrintAdmissionLetterController;
use App\Http\Controllers\SubBranchController;
use App\Http\Controllers\SubSubBranchController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return view('auth.login');
})->name('admin.login');

Auth::routes();
Route::post('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

Route::get('/verify/otp', [OTPController::class, 'showVerifyOtpForm'])->name('verify.otp');
Route::post('/verify/otp', [OTPController::class, 'verifyOtp'])->name('otp.verify');

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/change-password', [AuthController::class, 'verifyaccount'])->name('verify-password');
    Route::post('/password-changed', [AuthController::class, 'changePassword'])->name('changed-password');

    Route::get('/reprint-admission-letter', [PrintAdmissionLetterController::class, 'reprint_admission_letter'])->name('reprint-admission-letter');
    Route::get('/admin/reprint-admission-letter/{uuid}', [PrintAdmissionLetterController::class, 'print_letter'])->name('admin.reprint-admission-letter');

    Route::group(['prefix' => 'reseult-verfication', 'as' => 'document.'], function () {
        Route::get('/', [DocumentationController::class, 'applicant_documentation'])->name('applicant-documentation');
        Route::get('/status/{uuid}', [DocumentationController::class, 'applicant_result_verified'])->name('documentation-status');
        Route::get('/edit/status/{uuid}', [DocumentationController::class, 'documentation_update'])->name('documentation-status-update');
        Route::post('/save-documentation/{uuid}', [DocumentationController::class, 'store_applicant_documentation'])->name('status-save-documentation');
        Route::post('/update-applicant-documentation/{uuid}', [DocumentationController::class, 'confirm_applicant_documentation'])->name('documentation-update');
        Route::get('/results-generation-report', [DocumentationController::class, 'master_filter_applicant_documentation'])->name('master-filter-documentation');
    });
    Route::group(['prefix' => 'applicant-preview', 'as' => 'correct.'], function () {
        Route::get('/{uuid}', [CorrectApplicantController::class, 'applicant_corrections'])->name('correction-applicant-data');
        Route::post('/applicant/corrections/{uuid}', [CorrectApplicantController::class, 'updateApplicantCorrections'])->name('applicant.corrections.update');
    });
    Route::group(['prefix' => 'aptitude-test-phase', 'as' => 'test.'], function () {
        Route::post('/notify-bulk-qualified', [AptitudeController::class, 'notifyBulkQualified'])->name('bulk.qualified.applicants');
        Route::post('/send-notify-bulk-qualified-interview', [AptitudeController::class, 'notifyInterviewBulkQualified'])->name('bulk.qualified.applicants.for.interview');
        Route::get('/', [AptitudeController::class, 'applicant_aptitude'])->name('applicant-aptitude-test');
        Route::post('/save-aptitude-test', [AptitudeController::class, 'store_applicant_aptitude'])->name('store-applicant-aptitude');
        Route::get('/status/{uuid}', [AptitudeController::class, 'applicant_aptitude_status'])->name('aptitude-test-status');
        Route::get('/edit/aptitude-test/{uuid}', [AptitudeController::class, 'aptitude_update'])->name('aptitude-test-status-update');
        Route::post('/save-aptitude-test/{uuid}', [AptitudeController::class, 'store_applicant_aptitude'])->name('status-save-aptitude-test');
        Route::post('/update-applicant-aptitude-test/{uuid}', [AptitudeController::class, 'confirm_applicant_aptitude'])->name('aptitude-test-update');
        Route::get('/aptitude-generate-report', [AptitudeController::class, 'master_filter_applicant_aptitude'])->name('master-filter-aptitude');
        Route::post('/import-aptitude', [AptitudeController::class, 'import'])->name('import.aptitude');
    });

    Route::group(['prefix' => 'interview', 'as' => 'test.'], function () {
        Route::get('/', [InterviewController::class, 'applicant_interview'])->name('applicant-interview');
        Route::get('/status/{uuid}', [InterviewController::class, 'applicant_interview_status'])->name('interview-status');
        Route::get('/edit/interview/{uuid}', [InterviewController::class, 'interview_update'])->name('interview-status-update');
        Route::post('/save-interview/{uuid}', [InterviewController::class, 'store_applicant_interview'])->name('status-save-interview');
        Route::post('/update-applicant-interview/{uuid}', [InterviewController::class, 'confirm_applicant_interview'])->name('interview-update');
        Route::get('/notify-applicants-with-admission-letter', [InterviewController::class, 'master_filter_applicant_interview'])->name('master-filter-interview');
        Route::post('/pass-applicants-for-admission', [InterviewController::class, 'Interview_Qualified'])->name('pass-applicants-for-admission');
        Route::post('/disqualify-applicants', [InterviewController::class, 'Interview_Disqualified'])->name('disqualify-applicants');

        Route::post('/send-notify-bulk-qualified-admission', [InterviewController::class, 'notifyInterviewBulkQualified'])->name('send-notify-bulk-qualified-admission');
    });

    Route::group(['prefix' => 'agelimit', 'as' => 'set.'], function () {
        Route::get('/', [AgeLimitController::class, 'index'])->name('agelimit-index');
        Route::get('/mech', [AgeLimitController::class, 'Add'])->name('mech-agelimit');
        Route::post('/store', [AgeLimitController::class, 'Store'])->name('store-agelimit');
        Route::get('/edit/{uuid}', [AgeLimitController::class, 'Edit'])->name('edit-agelimit');
        Route::post('/update{uuid}', [AgeLimitController::class, 'Update'])->name('update-agelimit');
        Route::get('/delete{uuid}', [AgeLimitController::class, 'Delete'])->name('delete-agelimit');
        Route::post('/view-agelimit', [AgeLimitController::class, 'index'])->name('view-agelimit');
    });

    Route::group(['prefix' => 'bece-results', 'as' => 'results.'], function () {
        Route::get('/', [BeceResultController::class, 'view'])->name('bece-results-index');
        Route::get('/mech', [BeceResultController::class, 'Add'])->name('mech-bece-results');
        Route::post('/store', [BeceResultController::class, 'Store'])->name('store-bece-results');
        Route::get('/edit/{uuid}', [BeceResultController::class, 'Edit'])->name('edit-bece-results');
        Route::post('/update{uuid}', [BeceResultController::class, 'Update'])->name('update-bece-results');
        Route::get('/delete{uuid}', [BeceResultController::class, 'Delete'])->name('delete-bece-results');
        Route::post('/view-bece-results', [BeceResultController::class, 'index'])->name('view-bece-results');
    });

    Route::group(['prefix' => 'wassce-results', 'as' => 'results.'], function () {
        Route::get('/', [WassceResultController::class, 'view'])->name('wassce-results-index');
        Route::get('/mech', [WassceResultController::class, 'Add'])->name('mech-wassce-results');
        Route::post('/store', [WassceResultController::class, 'Store'])->name('store-wassce-results');
        Route::get('/edit/{uuid}', [WassceResultController::class, 'Edit'])->name('edit-wassce-results');
        Route::post('/update{uuid}', [WassceResultController::class, 'Update'])->name('update-wassce-results');
        Route::get('/delete/{uuid}', [WassceResultController::class, 'Delete'])->name('delete-wassce-results');
        Route::post('/view-wassce-results', [WassceResultController::class, 'index'])->name('view-wassce-results');
    });
    Route::group(['prefix' => 'branches', 'as' => 'bran.'], function () {
        Route::get('/', [BranchController::class, 'View'])->name('branch-index');
        Route::get('/mech', [BranchController::class, 'Add'])->name('mech-branch');
        Route::post('/store', [BranchController::class, 'Store'])->name('store-branch');
        Route::get('/edit/{uuid}', [BranchController::class, 'Edit'])->name('edit-branch');
        Route::post('/update{uuid}', [BranchController::class, 'Update'])->name('update-branch');
        Route::get('/delete{uuid}', [BranchController::class, 'Delete'])->name('delete-branch');
        Route::post('/view-branch', [BranchController::class, 'index'])->name('view-branch');
    });
    Route::prefix('sub-branches')->group(function () {
        Route::get('/', [SubBranchController::class, 'View'])->name('branch-sub-index');
        Route::get('/mech', [SubBranchController::class, 'Add'])->name('mech-sub-branch');
        Route::post('/store', [SubBranchController::class, 'Store'])->name('store-sub-branch');
        Route::get('/edit/{uuid}', [SubBranchController::class, 'Edit'])->name('edit-sub-branch');
        Route::post('/update{uuid}', [SubBranchController::class, 'Update'])->name('update-sub-branch');
        Route::get('/delete{uuid}', [SubBranchController::class, 'Delete'])->name('delete-sub-branch');
        Route::post('/view-sub-branch', [SubBranchController::class, 'index'])->name('view-sub-branch');
    });

    Route::prefix('sub-sub-branches')->group(function () {
        Route::get('/', [SubSubBranchController::class, 'View'])->name('branch-sub-sub-index');
        Route::get('/mech', [SubSubBranchController::class, 'Add'])->name('mech-sub-sub-branch');
        Route::post('/store', [SubSubBranchController::class, 'Store'])->name('store-sub-sub-branch');
        Route::get('/edit/{uuid}', [SubSubBranchController::class, 'Edit'])->name('edit-sub-sub-branch');
        Route::post('/update{uuid}', [SubSubBranchController::class, 'Update'])->name('update-sub-sub-branch');
        Route::get('/delete{uuid}', [SubSubBranchController::class, 'Delete'])->name('delete-sub-sub-branch');
        Route::post('/view-sub-sub-branch', [SubSubBranchController::class, 'index'])->name('view-sub-sub-branch');

        Route::get('/get-sub-branches/{branch_id}', [SubSubBranchController::class, 'getSubBranches']);
    });

    Route::group(['prefix' => 'bece-subjects', 'as' => 'subject.'], function () {
        Route::get('/', [BeceSubjectController::class, 'view'])->name('bece-subject-index');
        Route::get('/mech', [BeceSubjectController::class, 'Add'])->name('mech-bece-subject');
        Route::post('/store', [BeceSubjectController::class, 'Store'])->name('store-bece-subject');
        Route::get('/edit/{uuid}', [BeceSubjectController::class, 'Edit'])->name('edit-bece-subject');
        Route::post('/update{uuid}', [BeceSubjectController::class, 'Update'])->name('update-bece-subject');
        Route::get('/delete{uuid}', [BeceSubjectController::class, 'Delete'])->name('delete-bece-subject');
        Route::post('/view-bece-subject', [BeceSubjectController::class, 'index'])->name('view-bece-subject');
    });

    Route::group(['prefix' => 'wassce-subjects', 'as' => 'subject.'], function () {
        Route::get('/', [WassceSubjectController::class, 'view'])->name('wassce-subject-index');
        Route::get('/mech', [WassceSubjectController::class, 'Add'])->name('mech-wassce-subject');
        Route::post('/store', [WassceSubjectController::class, 'Store'])->name('store-wassce-subject');
        Route::get('/edit/{uuid}', [WassceSubjectController::class, 'Edit'])->name('edit-wassce-subject');
        Route::post('/update{uuid}', [WassceSubjectController::class, 'Update'])->name('update-wassce-subject');
        Route::get('/delete/{uuid}', [WassceSubjectController::class, 'Delete'])->name('delete-wassce-subject');
        Route::post('/view-wassce-subject', [WassceSubjectController::class, 'index'])->name('view-wassce-subject');
    });

    Route::group(['prefix' => 'offering-courses', 'as' => 'arm.'], function () {
        Route::get('/', [OfferingCourseController::class, 'index'])->name('arm-of-service');
        Route::get('/mech', [OfferingCourseController::class, 'Add'])->name('mech-arm-of_service');
        Route::post('/store', [OfferingCourseController::class, 'Store'])->name('store-arm-of_service');
        Route::get('/edit/{uuid}', [OfferingCourseController::class, 'Edit'])->name('edit-arm-of_service');
        Route::post('/update{uuid}', [OfferingCourseController::class, 'Update'])->name('update-arm-of_service');
        Route::get('/delete{uuid}', [OfferingCourseController::class, 'Delete'])->name('delete-arm-of_service');
        Route::post('/view-arm-of_service', [OfferingCourseController::class, 'index'])->name('view-arm-of_service');
    });

    Route::group(['prefix' => 'result-verification-phase', 'as' => 'report.'], function () {
        Route::get('/', [ReportGenerationController::class, 'reports'])->name('report-generation');
        Route::get('/applicant/{uuid}', [ReportGenerationController::class, 'applicant_pdf'])->name('admin-applicant-pdf');
        Route::get('phases/applicant/{uuid}', [ReportGenerationController::class, 'showApplicantPhases'])->name('applicant.view');
        Route::get('/delete/applicant/{uuid}', [ReportGenerationController::class, 'deleteApplicant'])->name('delete-applicant');
        // Admin Preview
        Route::get('/applicant-preview', [ReportGenerationController::class, 'applicant_preview_data'])->name('correct-applicant-data');
    });


    Route::group(['prefix' => 'vetting', 'as' => 'test.'], function () {
        Route::get('/', [VettingController::class, 'applicant_vetting'])->name('applicant-vetting');
        Route::get('/status/{uuid}', [VettingController::class, 'applicant_vetting_status'])->name('vetting-status');
        Route::get('/edit/vetting/{uuid}', [VettingController::class, 'vetting_update'])->name('vetting-status-update');
        Route::post('/save-vetting/{uuid}', [VettingController::class, 'store_applicant_vetting'])->name('status-save-vetting');
        Route::post('/update-applicant-vetting/{uuid}', [VettingController::class, 'confirm_applicant_vetting'])->name('vetting-update');
        Route::get('/vetting-generate-report', [VettingController::class, 'master_filter_applicant_vetting'])->name('master-filter-vetting');
    });

    Route::group(['prefix' => 'body-selection-phase', 'as' => 'bodyselection.'], function () {
        Route::get('/', [BodySelectionController::class, 'applicant_bodyselection'])->name('applicant-body-selection');
        Route::get('/status/{uuid}', [BodySelectionController::class, 'applicant_bodyselection_status'])->name('body-selection-status');
        Route::get('/edit/body-selection/{uuid}', [BodySelectionController::class, 'bodyselection_update'])->name('body-selection-status-update');
        Route::post('/save-body-selection/{uuid}', [BodySelectionController::class, 'store_applicant_bodyselection'])->name('status-save-body-selection');
        Route::post('/update-applicant-body-selection/{uuid}', [BodySelectionController::class, 'confirm_applicant_bodyselection'])->name('body-selection-update');
        Route::get('/bodyselection-generate-report', [BodySelectionController::class, 'master_filter_applicant_bodyselection'])->name('master-filter-body-selection');
    });

    Route::group(['prefix' => 'medicals', 'as' => 'test.'], function () {
        Route::get('/', [MedicalsController::class, 'applicant_medicals'])->name('applicant-medical');
        Route::get('/status/{uuid}', [MedicalsController::class, 'applicant_medicals_status'])->name('medical-status');
        Route::get('/edit/medical/{uuid}', [MedicalsController::class, 'medicals_update'])->name('medical-status-update');
        Route::post('/save-medical/{uuid}', [MedicalsController::class, 'store_applicant_medicals'])->name('status-save-medical');
        Route::post('/update-applicant-medical/{uuid}', [MedicalsController::class, 'confirm_applicant_medicals'])->name('medical-update');
        Route::get('/medical-generate-report', [MedicalsController::class, 'master_filter_applicant_medicals'])->name('master-filter-medicals');
    });
    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseTypeController::class, 'View'])->name('courses-index');
        Route::get('/mech', [CourseTypeController::class, 'Add'])->name('mech-courses');
        Route::post('/store', [CourseTypeController::class, 'Store'])->name('store-courses');
        Route::get('/edit/{uuid}', [CourseTypeController::class, 'Edit'])->name('edit-courses');
        Route::post('/update{uuid}', [CourseTypeController::class, 'Update'])->name('update-courses');
        Route::get('/delete{uuid}', [CourseTypeController::class, 'Delete'])->name('delete-courses');
        Route::post('/view-courses', [CourseTypeController::class, 'index'])->name('view-courses');
        Route::post('/course/toggle-status/{uuid}', [CourseTypeController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('get-commission-types', [CourseTypeController::class, 'getCommissionTypes'])->name('get-commission-types');
        Route::post('get-branches', [CourseTypeController::class, 'getBranches'])->name('get-branches');
        Route::post('get-courses', [CourseTypeController::class, 'getCourses'])->name('get-courses');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesAndPermissionController::class, 'index'])->name('index-roles');
        Route::get('/add', [RolesAndPermissionController::class, 'create'])->name('create-roles');
        Route::post('/store', [RolesAndPermissionController::class, 'store'])->name('store-roles');
        Route::get('/edit/{uuid}', [RolesAndPermissionController::class, 'edit'])->name('edit-roles');
        Route::post('/update', [RolesAndPermissionController::class, 'update'])->name('update-roles');
        Route::get('/delete{uuid}', [RolesAndPermissionController::class, 'destroy'])->name('destroy-roles');
    });


    Route::prefix('account')->group(function () {
        Route::get('/', [AccountingController::class, 'index'])->name('account-dashboard');
        Route::get('/trials-fees-payment', [AccountingController::class, 'trials_fees'])->name('trials-fees-payment');
        // Route::post('/store', [RolesAndPermissionController::class, 'store'])->name('store-roles');
        // Route::get('/edit/{uuid}', [RolesAndPermissionController::class, 'edit'])->name('edit-roles');
        // Route::post('/update', [RolesAndPermissionController::class, 'update'])->name('update-roles');
        // Route::get('/delete{uuid}', [RolesAndPermissionController::class, 'destroy'])->name('destroy-roles');
    });


    Route::prefix('user')->group(function () {
        Route::get('/', [UserAccountController::class, 'index'])->name('index-user');
        Route::get('/add', [UserAccountController::class, 'create'])->name('create-user');
        Route::post('/store', [UserAccountController::class, 'store'])->name('store-user');
        Route::get('/edit/{uuid}', [UserAccountController::class, 'edit'])->name('edit-user');
        Route::post('/update', [UserAccountController::class, 'update'])->name('update-user');
        Route::get('/delete{uuid}', [UserAccountController::class, 'destroy'])->name('destroy-user');

        //Subjects Allocation
        Route::get('/subject-allocation', [UserAccountController::class, 'subject_allocation'])->name('subject-allocation');
        Route::post('/add-user-course', [UserAccountController::class, 'add_subject_allocation'])->name('admin.user.course.add');

        Route::post('/roles/store', [UserAccountController::class, 'storerole'])->name('roles.store');
        Route::post('/roles/assign-permissions', [UserAccountController::class, 'assignpermission'])->name('roles.assign-permissions');

        //Signature
        Route::get('/upload-signature', [UserAccountController::class, 'showSignatureForm'])->name('signature.upload');
        Route::post('/upload-signature', [UserAccountController::class, 'uploadsignature'])->name('signature.store');
    });

    Route::prefix('Profile')->group(function () {
        Route::get('/', [ProfileController::class, 'ProfileView'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
        Route::get('/inactivation{uuid}', [ProfileController::class, 'Inactive'])->name('user.inactive');
        Route::get('/activation{uuid}', [ProfileController::class, 'Active'])->name('user.active');
    });
    Route::prefix('audit-trail')->group(function () {
        Route::get('/user-audit', [AuditController::class, 'Audit'])->name('user-audit-trail');
    });
    Route::prefix('audit-trail')->group(function () {
        Route::get('/logs-activities', [LogactivityController::class, 'login_and_logout_activities'])->name('login_and_logout');
    });

    Route::prefix('faculties')->group(function () {
        Route::get('/', [FacultyController::class, 'index'])->name('view-faculty');
        Route::post('/store', [FacultyController::class, 'Store'])->name('store-faculty');
        Route::get('/edit/{uuid}', [FacultyController::class, 'edit'])->name('edit-faculty');
        Route::post('/faculty/update/{uuid}', [FacultyController::class, 'Update'])->name('update-faculty');
        Route::get('/delete{uuid}', [FacultyController::class, 'destroy'])->name('destroy-faculty');
        Route::post('save-education-data', [FacultyController::class, 'saveEducationData'])->name('saveEducationData');
    });

    Route::prefix('faculty-departments')->group(function () {
        Route::get('/', [DepartmentController::class, 'view'])->name('view-faculty-department');
        Route::post('/store', [DepartmentController::class, 'Store'])->name('store-faculty-department');
        Route::get('/edit/{uuid}', [DepartmentController::class, 'edit'])->name('edit-faculty-department');
        Route::post('/faculty/update/{uuid}', [DepartmentController::class, 'Update'])->name('update-faculty-department');
        Route::get('/delete{uuid}', [DepartmentController::class, 'Delete'])->name('destroy-faculty-department');
        Route::post('faculty-departments', [DepartmentController::class, 'index'])->name('faculty-departments');
    });

    Route::prefix('lecturer')->group(function () {
        Route::get('/', [LecturerController::class, 'lecturer_dashboard'])->name('lecturer-dashboard');
        Route::get('/students', [LecturerController::class, 'students_results'])->name('students-results');
        Route::get('/student-results', [LecturerController::class, 'students_results'])->name('lecturer.students.results');
        Route::get('/download-students/{courseId}/{level}', [LecturerController::class, 'downloadStudents'])->name('lecturer.downloadStudents');
        Route::get('/students/{courseId}/{level}', [LecturerController::class, 'viewStudentsForLecturerSubject'])->name('lecturer.viewStudents');

        // Route::post('/store', [DepartmentController::class, 'Store'])->name('store-faculty-department');
        // Route::get('/edit/{uuid}', [DepartmentController::class, 'edit'])->name('edit-faculty-department');
        // Route::post('/faculty/update/{uuid}', [DepartmentController::class, 'Update'])->name('update-faculty-department');
        // Route::get('/delete{uuid}', [DepartmentController::class, 'Delete'])->name('destroy-faculty-department');
        // Route::post('faculty-departments', [DepartmentController::class, 'index'])->name('faculty-departments');
    });
});

Route::group([
    'namespace' => 'Dashboard',
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => ['admin', 'force.password.change', 'check.signature.status']
], function () {
    Route::get('/', [DashboardController::class, 'welcomedashboard'])->name('index');
    Route::get('/analysis-dashboard', [DashboardController::class, 'index'])->name('analysis-dashboard');
});


// Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'admin'], function () {
//     Route::get('/', [DashboardController::class, 'welcomedashboard'])->name('index');
//     Route::get('/analysis-dashboard', [DashboardController::class, 'index'])->name('analysis-dashboard');
// });
//Admin Routes
//Route::prefix('admin')->group(function () {
