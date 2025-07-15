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
    Route::post('/bodyselection', [ApiBodySelectionController::class, 'applicant_body_selection_table'])->name('api-applicant-body-selection');

    Route::post('/medical-test', [ApiMedicalsController::class, 'applicant_medicals'])->name('api-applicant-medicals');
    Route::post('/vetting-test', [ApiVettingController::class, 'applicant_vettings'])->name('api-applicant-vettings');
});
Route::prefix('api')->group(function () {
    Route::post('/api-main-report', [ReportController::class, 'applicant_reports_table'])->name('generate-applicant-report');
    Route::post('/api-applicant-correction', [PreviewApplicantController::class, 'applicant_master_preview_data'])->name('generate-applicant-correction');
});
Route::prefix('user-logs-activities')->group(function () {
    Route::post('/api-user-logs-activities', [UserLogActivitiesController::class, 'index'])->name('api-user-logs-activities');
    Route::post('/api-audit-logs', [UserAuditTrailActivitiesController::class, 'index'])->name('api-audit-logs');
});
