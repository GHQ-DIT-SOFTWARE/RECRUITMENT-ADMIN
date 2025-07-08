<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use App\Models\Interview;
use App\Models\ResultVerification;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcomedashboard()
    {
        return view('admin.pages.homedash');
    }


    public function index()
    {


        // Count qualified applicants per course
        $qualified_bsc_nursing = Applicant::where('qualification', 'QUALIFIED')
            ->where('cause_offers', 'BSC NURSING')
            ->count();

        $qualified_bsc_midwifery = Applicant::where('qualification', 'QUALIFIED')
            ->where('cause_offers', 'BSC MIDWIFERY')
            ->count();
        // Total sum of qualified for both courses
        $total_qualified_courses = $qualified_bsc_nursing + $qualified_bsc_midwifery;
        // Count disqualified applicants per course
        $disqualified_bsc_nursing = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('cause_offers', 'BSC NURSING')
            ->count();
        $disqualified_bsc_midwifery = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('cause_offers', 'BSC MIDWIFERY')
            ->count();
        // Total sum of disqualified for both courses
        $total_disqualified_courses = $disqualified_bsc_nursing + $disqualified_bsc_midwifery;
        // Count applicants who have not finished their application (qualification is NULL or empty)
        $incomplete_applications = Applicant::whereNull('qualification')
            ->orWhere('qualification', '')
            ->count();
        // Total sum of all qualified + disqualified + incomplete applications
        $total_applicants = $total_qualified_courses + $total_disqualified_courses + $incomplete_applications;
        // Chart Data
        $chartData = [
            'labels' => ['BSC MIDWIFERY', 'BSC NURSING'],
            'datasets' => [
                [
                    'data' => [$qualified_bsc_midwifery, $qualified_bsc_nursing],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                ],
            ],
        ];
        $year = now()->year;

        $qualified_results_verification = ResultVerification::where('result_verified', 'QUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        $disqualified_results_verification = ResultVerification::where('result_verified', 'DISQUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        $qualified_aptitude = Aptitude::where('aptitude_status', 'QUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        $disqualified_aptitude = Aptitude::where('aptitude_status', 'DISQUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        $qualified_interview = Interview::where('interview_status', 'QUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        $disqualified_interview = Interview::where('interview_status', 'DISQUALIFIED')
            ->whereYear('created_at', $year)
            ->count();

        // Count qualified applicants per course
        $regular = Applicant::where('entrance_type', 'REGULAR')->whereYear('created_at', $year)
            ->count();
        // Count qualified applicants per course
        $top_up = Applicant::where('entrance_type', 'TOP UP')->whereYear('created_at', $year)
            ->count();

        return view('admin.layout.index', compact(
            'qualified_bsc_nursing',
            'qualified_bsc_midwifery',
            'total_qualified_courses',
            'disqualified_bsc_nursing',
            'disqualified_bsc_midwifery',
            'total_disqualified_courses',
            'total_applicants',
            'incomplete_applications',
            'chartData',
            'disqualified_interview',
            'qualified_interview',
            'disqualified_aptitude',
            'qualified_aptitude',
            'disqualified_results_verification',
            'qualified_results_verification',
            'regular',
            'top_up'
        ));
    }
}
