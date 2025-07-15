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
        $tradesment = Applicant::where('qualification', 'QUALIFIED')
            ->where('trade_type', 'TRADESMEN')
            ->count();

        $qualified_non_tradesmen = Applicant::where('qualification', 'QUALIFIED')
            ->where('trade_type', 'NON-TRADESMEN')
            ->count();
        // Total sum of qualified for both courses
        $total_qualified_applicant = $tradesment + $qualified_non_tradesmen;
        // Count disqualified applicants per course
        $nontradesment = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('trade_type', 'TRADESMEN')
            ->count();
        $disqualified_non_tradesmen = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('trade_type', 'NON-TRADESMEN')
            ->count();
        // Total sum of disqualified for both courses
        $total_disqualified_applicant = $nontradesment + $disqualified_non_tradesmen;
        // Count applicants who have not finished their application (qualification is NULL or empty)
        $incomplete_applications = Applicant::whereNull('qualification')
            ->orWhere('qualification', '')
            ->count();
        // Total sum of all qualified + disqualified + incomplete applications
        $total_applicants = $total_qualified_applicant + $total_disqualified_applicant + $incomplete_applications;
        // Chart Data
        $chartData = [
            'labels' => ['NON-TRADESMEN', 'TRADESMEN'],
            'datasets' => [
                [
                    'data' => [$qualified_non_tradesmen, $tradesment],
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

        // Count qualified ARMY applicants
        $army = Applicant::where('arm_of_service', 'ARMY')
            ->whereYear('created_at', $year)
            ->where('final_checked', 'YES')
            ->count();

        // Count qualified NAVY applicants
        $navy = Applicant::where('arm_of_service', 'NAVY')
            ->whereYear('created_at', $year)
            ->where('final_checked', 'YES')
            ->count();

        // Count qualified AIRFORCE applicants
        $airforce = Applicant::where('arm_of_service', 'AIRFORCE')
            ->whereYear('created_at', $year)
            ->where('final_checked', 'YES')
            ->count();




        // QUALIFIED - TRADESMEN
        $tradesmen_army = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'ARMY')
            ->count();

        $tradesmen_navy = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'NAVY')
            ->count();

        $tradesmen_airforce = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'AIRFORCE')
            ->count();

        // DISQUALIFIED - TRADESMEN
        $disqualified_tradesmen_army = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'ARMY')
            ->count();

        $disqualified_tradesmen_navy = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'NAVY')
            ->count();

        $disqualified_tradesmen_airforce = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'TRADESMEN')
            ->where('arm_of_service', 'AIRFORCE')
            ->count();

        // QUALIFIED - NON-TRADESMEN
        $non_tradesmen_army = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'ARMY')
            ->count();

        $non_tradesmen_navy = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'NAVY')
            ->count();

        $non_tradesmen_airforce = Applicant::where('qualification', 'QUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'AIRFORCE')
            ->count();

        // DISQUALIFIED - NON-TRADESMEN
        $disqualified_non_tradesmen_army = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'ARMY')
            ->count();

        $disqualified_non_tradesmen_navy = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'NAVY')
            ->count();

        $disqualified_non_tradesmen_airforce = Applicant::where('qualification', 'DISQUALIFIED')
            ->where('final_checked', 'YES')
            ->where('trade_type', 'NON-TRADESMEN')
            ->where('arm_of_service', 'AIRFORCE')
            ->count();



        return view('admin.layout.index', compact(
            'tradesment',
            'qualified_non_tradesmen',
            'total_qualified_applicant',
            'nontradesment',
            'disqualified_non_tradesmen',
            'total_disqualified_applicant',
            'total_applicants',
            'incomplete_applications',
            'chartData',
            'disqualified_interview',
            'qualified_interview',
            'disqualified_aptitude',
            'qualified_aptitude',
            'disqualified_results_verification',
            'qualified_results_verification',
            'army',
            'navy',
            'airforce',

            'tradesmen_army',
            'tradesmen_navy',
            'tradesmen_airforce',
            'disqualified_tradesmen_army',
            'disqualified_tradesmen_navy',
            'disqualified_tradesmen_airforce',
            'non_tradesmen_army',
            'non_tradesmen_navy',
            'non_tradesmen_airforce',
            'disqualified_non_tradesmen_army',
            'disqualified_non_tradesmen_navy',
            'disqualified_non_tradesmen_airforce',
            'non_tradesmen_army'
        ));
    }
}
