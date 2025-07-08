<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\ApplicantPreview;

use App\Http\Controllers\Controller;
use App\Models\AgeLimit;
use App\Models\Applicant;
use App\Models\BECERESULTS;
use App\Models\BECESUBJECT;
use App\Models\District;
use App\Models\Region;
use App\Models\WASSCERESULTS;
use App\Models\WASSCESUBJECT;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CorrectApplicantController extends Controller
{
    public function applicant_corrections($uuid)
    {
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.resultsverfication.preview', compact('applied_applicant'));
    }

    public function updateApplicantCorrections(Request $request, $uuid)
    {
        // Retrieve the applicant using the UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        $disqualificationReasons = [];
        // Update applicant's data based on request input
        $applied_applicant->update($request->all());
        // Get the latest age limit date based on the commission type
        $latestAgeLimitDate = AgeLimit::where('commission_type', $applied_applicant->commission_type)
            ->orderBy('agelimit_date', 'desc')
            ->value('agelimit_date');
        if (!$latestAgeLimitDate) {
            $disqualificationReasons[] = 'No age limit date found for your commission type.';
        } else {
            $ageAtDeadline = Carbon::parse($applied_applicant->date_of_birth)->diffInYears(Carbon::parse($latestAgeLimitDate));
            $exactAgeAtDeadline = Carbon::parse($applied_applicant->date_of_birth)->diff(Carbon::parse($latestAgeLimitDate));
            $applied_applicant->age = $ageAtDeadline;
            $applied_applicant->save();
        }
        // Calculate BMI and classify it
        $bmi = $this->calculateBmi($applied_applicant);
        $bmiClassification = $this->classifyBmi($bmi);
        // Commission type-specific validation
        if ($applied_applicant->commission_type === 'REGULAR') {
            // MILITARY POLICE height requirement
            if ($applied_applicant->branches->branch === 'MILITARY POLICE') {
                $height = (float) $applied_applicant->height;
                if (($applied_applicant->sex === 'MALE' && $height < 5.9) || ($applied_applicant->sex === 'FEMALE' && $height < 5.7)) {
                    $disqualificationReasons[] = 'Height requirement minimum 5.9 feet for males and 5.7 feet for females.';
                }
            }
            // General height requirements
            if (isset($applied_applicant->height)) {
                $height = number_format((float) $applied_applicant->height, 1);
                if (($applied_applicant->sex === 'MALE' && $height < 5.6) || ($applied_applicant->sex === 'FEMALE' && $height < 5.2)) {
                    $disqualificationReasons[] = 'Height requirement minimum 5.6 feet for males and 5.2 feet for females.';
                }
            }
            // Age check
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 26)) {
                $disqualificationReasons[] = 'Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }

            // Marital status check
            if ($applied_applicant->marital_status === 'MARRIED') {
                $disqualificationReasons[] = 'Married applicants are disqualified.';
            }

            // BMI check
            if ($bmi >= 25) {
                $disqualificationReasons[] = 'Applicant is classified as ' . $bmiClassification . ' with a BMI of ' . number_format($bmi, 2) . '. This classification disqualifies you from proceeding.';
            }

            // Programme-specific validation
            if ($applied_applicant->arm_of_service === 'NAVY' && $applied_applicant->branches->branch === 'EXECUTIVE') {
                if ($applied_applicant->programme === 'GEOGRAPHY' || $applied_applicant->programme === 'GEOLOGY') {
                    if ($applied_applicant->secondary_course_offered !== 'SCIENCE') {
                        $disqualificationReasons[] = 'Applicants from the EXECUTIVE branch with ' . $applied_applicant->programme . ' as a program of study must have a secondary course in SCIENCE.';
                    }
                }
            }

            // Additional checks for other branches and programmes
            // Example for AIRFORCE
            if ($applied_applicant->arm_of_service === 'AIRFORCE') {
                if (in_array($applied_applicant->branches->branch, ['PILOT', 'AVIONICS', 'AIR TRAFFIC CONTROL OPERATORS']) && $applied_applicant->programme === 'COMPUTER SCIENCE') {
                    if ($applied_applicant->secondary_course_offered !== 'SCIENCE') {
                        $disqualificationReasons[] = 'Applicants from the ' . $applied_applicant->branches->branch . ' branch with COMPUTER SCIENCE as a program of study must have a secondary course in SCIENCE.';
                    }
                }
            }
        } elseif ($applied_applicant->commission_type === 'SHORT SERVICE') {
            // Short Service-specific validation
            if ($applied_applicant->branches->branch === 'ARCHITECT' && isset($ageAtDeadline) && $ageAtDeadline <= 40) {
                $disqualificationReasons[] = 'Applicants for the Architect branch in Short Service must be over 40 years old. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            } elseif (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 30)) {
                $disqualificationReasons[] = 'Applicant is over the age limit of 30 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }

            // Professional experience checks for certain branches
            $this->checkProfessionalExperience($applied_applicant, $disqualificationReasons);
        }

        // Check exam results
        $this->checkExamResults($applied_applicant, $disqualificationReasons);

        // Update applicant status or take any necessary action
        if (!empty($disqualificationReasons)) {
            $applied_applicant->qualification = 'DISQUALIFIED';
            $applied_applicant->disqualification_reason = implode(', ', $disqualificationReasons);
        } else {
            $applied_applicant->qualification = 'QUALIFIED';
        }
        $applied_applicant->save();
        return redirect()->back()->with([
            'success' => 'Applicant corrections updated successfully.',
            'disqualification_reasons' => $disqualificationReasons,
        ]);

    }

    protected function checkProfessionalExperience($applied_applicant, &$disqualificationReasons)
    {
        $professionalExperienceYears = (int) $applied_applicant->year_of_professional_experience;

        // Check for branches requiring specific experience
        if (in_array($applied_applicant->branches->branch, ['LEGAL', 'MEDICAL OFFICERS AND DENTAL SURGEONS', 'SPECIALIST NURSE', 'CERTIFIED REGISTERED ANAESTHETISTS'])) {
            if ($professionalExperienceYears < 1) {
                $disqualificationReasons[] = 'Applicants for the Short Service must have at least 1 year of professional experience. You only have ' . $professionalExperienceYears . ' year(s) of experience.';
            }
        } elseif (in_array($applied_applicant->branches->branch, ['CHAPLAIN', 'IMAM'])) {
            if ($professionalExperienceYears < 4) {
                $disqualificationReasons[] = 'Applicants for the CHAPLAIN or IMAM branch in Short Service must have at least 4 years of professional experience. You only have ' . $professionalExperienceYears . ' year(s) of experience.';
            }
        } elseif (in_array($applied_applicant->branches->branch, ['ENGINEER CORPS', 'MECHANICAL', 'AVIONICS', 'ARMAMENT'])) {
            if ($professionalExperienceYears < 2) {
                $disqualificationReasons[] = 'Applicants for the branch Short Service must have at least 2 years of professional experience. You only have ' . $professionalExperienceYears . ' year(s) of experience.';
            }
        }
    }
    protected function calculateBmi($applied_applicant)
    {
        $heightInMeters = (float) $applied_applicant->height * 0.3048;
        $weightInKg = (float) $applied_applicant->weight;
        if ($heightInMeters > 0) {
            $bmi = $weightInKg / ($heightInMeters * $heightInMeters);
            return $bmi;
        }
        return 0;
    }
    protected function checkExamResults($applied_applicant, &$disqualificationReasons)
    {
        $examTypes = [
            'exam_type_one',
            'exam_type_two',
            'exam_type_three',
            'exam_type_four',
            'exam_type_five',
            'exam_type_six',
        ];
        // Fetch subject names from the database or predefined list
        $subjectMappings = $this->getSubjectMappings($applied_applicant);
        $examSubjects = array_keys($subjectMappings);
        // Track failed subjects to avoid repetition
        $failedSubjects = [];
        $this->checkBeceGrades($applied_applicant, $disqualificationReasons, $failedSubjects);
        foreach ($examTypes as $index => $examType) {
            $examTypeValue = $applied_applicant->{$examType};
            if ($examTypeValue === 'WASSCE' || $examTypeValue === 'PRIVATE') {
                $this->checkWassceAndPrivateGrades($applied_applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            } elseif ($examTypeValue === 'A LEVEL') {
                $this->checkALevelGrades($applied_applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            }
        }
    }
    protected function checkBeceGrades($applicant, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrades = ['7', '8', '9'];
        // Define subject name mapping for the BECE subjects
        $subjectNameMapping = [
            'bece_english' => $applicant->bece_english,
            'bece_mathematics' => $applicant->bece_mathematics,
            'bece_subject_three' => $applicant->bece_subject_three,
            'bece_subject_four' => $applicant->bece_subject_four,
            'bece_subject_five' => $applicant->bece_subject_five,
            'bece_subject_six' => $applicant->bece_subject_six,
        ];
        $beceSubjects = [
            'bece_english' => $applicant->bece_subject_english_grade,
            'bece_mathematics' => $applicant->bece_subject_maths_grade,
            'bece_subject_three' => $applicant->bece_subject_three_grade,
            'bece_subject_four' => $applicant->bece_subject_four_grade,
            'bece_subject_five' => $applicant->bece_subject_five_grade,
            'bece_subject_six' => $applicant->bece_subject_six_grade,
        ];

        foreach ($beceSubjects as $columnName => $grade) {
            $subjectName = $subjectNameMapping[$columnName] ?? $columnName;
            if (in_array($grade, $failingGrades)) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
    protected function getSubjectMappings($applicant)
    {
        return [
            'wassce_english_grade' => $applicant->wassce_english,
            'wassce_mathematics_grade' => $applicant->wassce_mathematics,
            'wassce_subject_three_grade' => $applicant->wassce_subject_three,
            'wassce_subject_four_grade' => $applicant->wassce_subject_four,
            'wassce_subject_five_grade' => $applicant->wassce_subject_five,
            'wassce_subject_six_grade' => $applicant->wassce_subject_six,
        ];
    }

    protected function classifyBmi($bmi)
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            return 'Normal weight';
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
    protected function checkWassceAndPrivateGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrades = ['D7', 'E8', 'F9'];
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if (in_array($grade, $failingGrades)) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
    // Method to check A LEVEL exam grades
    protected function checkALevelGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrade = 'E';
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if ($grade === $failingGrade) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
}
