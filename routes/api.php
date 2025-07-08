<?php

use App\Http\Controllers\Api\ApplicantPreview\PreviewApplicantController;
use App\Http\Controllers\Api\LogActivities\UserAuditTrailActivitiesController;
use App\Http\Controllers\Api\LogActivities\UserLogActivitiesController;
use App\Http\Controllers\Api\Phases\ApiAptitudeController;
use App\Http\Controllers\Api\Phases\ApiBasicFitnessController;
use App\Http\Controllers\Api\Phases\ApiBodySelectionController;
use App\Http\Controllers\Api\Phases\ApiDocumentationController;
use App\Http\Controllers\Api\Phases\ApiInterviewController;
use App\Http\Controllers\Api\Phases\ApiMedicalsController;
use App\Http\Controllers\Api\Phases\ApiOutDoorLeaderlessController;
use App\Http\Controllers\Api\Phases\ApiVettingController;
use App\Http\Controllers\Api\Report\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Academics
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminCoursePackagingController;
use App\Http\Controllers\Admin\AdminScoresController;
use App\Http\Controllers\Admin\AdminAssignmentController;
use App\Http\Controllers\Useraccount\UserAccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('phases')->group(function () {
    Route::post('/documentation', [ApiDocumentationController::class, 'applicant_documentation_table'])->name('api-applicant-documentation');

    Route::post('/aptitude-test', [ApiAptitudeController::class, 'applicant_aptitude_test'])->name('api-applicant-aptitude-test');

    Route::post('/interview-test', [ApiInterviewController::class, 'applicant_interview'])->name('api-applicant-interview');

    Route::post('/master-documentation-applicant', [ApiDocumentationController::class, 'master_documentation_applicant'])->name('api-master-documentation');
    Route::post('/master-aptitude-applicant', [ApiAptitudeController::class, 'master_aptitude_applicant'])->name('api-master-aptitude');

    Route::post('/master-interview-applicant', [ApiInterviewController::class, 'master_interview_applicant'])->name('api-master-interview');

    Route::post('/api-reprint-admission-letter-applicant', [ApiInterviewController::class, 'reprint_applicant_admission_letter'])->name('api-reprint-admission-letter-applicant');
});
Route::prefix('api')->group(function () {
    Route::post('/api-main-report', [ReportController::class, 'applicant_reports_table'])->name('generate-applicant-report');
    Route::post('/api-applicant-correction', [PreviewApplicantController::class, 'applicant_master_preview_data'])->name('generate-applicant-correction');
});
Route::prefix('user-logs-activities')->group(function () {
    Route::post('/api-user-logs-activities', [UserLogActivitiesController::class, 'index'])->name('api-user-logs-activities');
    Route::post('/api-audit-logs', [UserAuditTrailActivitiesController::class, 'index'])->name('api-audit-logs');
});



//Academics API
Route::get('/admin/get-student-count', [AdminHomeController::class, 'getStudentCount']);
Route::get('/admin/get-student-list', [AdminHomeController::class, 'getStudentList'])->name('api.getStudentList');


//Admin Courses API
Route::get('/courses', [AdminCourseController::class, 'getCourses'])->name('api.courses');
Route::get('/course/{id}', [AdminCourseController::class, 'getCourseById'])->name('api.course.details');
Route::post('admin/course/update/{id}', [AdminCourseController::class, 'update'])->name('admin.course.update');


//Admin Categories API
Route::get('/category', [AdminCategoryController::class, 'getCategory'])->name('api.category');
Route::get('/category/{id}', [AdminCategoryController::class, 'getCategoryById'])->name('api.category.details');
Route::post('admin/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');

//Admin Subject API
Route::get('/subject', [AdminSubjectController::class, 'getSubjects'])->name('api.subjects');
Route::get('/subject/{id}', [AdminSubjectController::class, 'getSubjectById'])->name('api.subject.details');
Route::post('admin/subject/update/{id}', [AdminSubjectController::class, 'update_subject'])->name('admin.subject.update');

//Admin Subject API
Route::get('/material', [AdminSubjectController::class, 'getMaterial'])->name('api.materials');
Route::get('/material/{id}', [AdminSubjectController::class, 'getMaterialById'])->name('api.material.details');
Route::post('admin/material/update/{id}', [AdminSubjectController::class, 'update'])->name('admin.material.update');
//Route::get('/get-subjects', [AdminSubjectController::class, 'getSubjects']);


//Admin Course-Subject Allocation API
Route::get('/allocation', [AdminSubjectController::class, 'getAllocation'])->name('api.allocations');
Route::get('/allocation/{id}', [AdminSubjectController::class, 'getAllocationById'])->name('api.allocation.details');
Route::post('admin/allocation/update/{id}', [AdminSubjectController::class, 'update_allocation'])->name('admin.allocation.update');


//Admin Assignment API
Route::get('/assignment', [AdminAssignmentController::class, 'getAssignment'])->name('api.assignments');
Route::get('/assignment/{id}', [AdminAssignmentController::class, 'getAssignmentById'])->name('api.assignment.details');
Route::post('admin/assignment/update/{id}', [AdminAssignmentController::class, 'update_assignment'])->name('admin.assignment.update');

//Admin Users API
Route::get('/users', [AdminUsersController::class, 'getusers'])->name('api.users');
Route::get('/users/{id}', [AdminUsersController::class, 'getUsersById'])->name('api.users.details');
Route::post('admin/users/update/{id}', [AdminUsersController::class, 'update_users'])->name('admin.users.update');
Route::get('/get-users', [AdminUsersController::class, 'getUsersInfo']);
// Route::get('/user-courses-grouped', [AdminUsersController::class, 'getUserCoursesGrouped'])->name('api.user.courses');
Route::get('/user-courses-grouped', [UserAccountController::class, 'getUserCoursesGrouped'])->name('api.user.courses');



//Admin Course Report
Route::get('/courses/filter', [AdminCourseController::class, 'filterCourses']);

//Admin assignment Report
Route::get('/assignments/filter', [AdminAssignmentController::class, 'filterAssignments']);

//Admin Course Allocation
Route::get('/fetch-allocated-user', [AdminUsersController::class, 'fetch_allocated_user'])->name('api.user.allocation');


//Admin Grading
Route::post('/grade-student', [AdminScoresController::class, 'gradeStudent'])->name('api.gradeStudent');


//Course Packaging
Route::get('/course-packaging', [AdminCoursePackagingController::class, 'fetchPackages'])->name('api.packages');
