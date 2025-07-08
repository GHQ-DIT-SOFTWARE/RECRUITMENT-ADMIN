<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\OfferingCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\QualifiedApplicantMail;
use App\Models\StudentLogin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InterviewController extends Controller
{
    public function applicant_interview()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.interview.report', compact('data'));
    }

    public function applicant_interview_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.interview.index', compact('applied_applicant'));
    }

    public function master_filter_applicant_interview()
    {
        $data = Interview::get();
        return view('admin.pages.phases.interview.master_interview', compact('data'));
    }

    public function interview_update($uuid)
    {
        // Retrieve the interview record
        $interview = Interview::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($interview->applicant_id);
        return view('admin.pages.phases.interview.update', compact('applied_applicant', 'interview'));
    }


    public function store_applicant_interview(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'interview_status' => 'required',
            'interview_marks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $interview = Interview::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$interview) {
            return back()->with('error', 'No interview  record found for this applicant. Please check the documentation phase.');
        }
        // Check if interview_status is already set (not null)
        if (!is_null($interview->interview_status)) {
            // If interview_status is already set, prevent updating and return an error
            return back()->with('error', 'interview  status has already been set and cannot be updated.');
        }
        // If interview_status is null, allow updating the record
        $interview->update([
            'interview_status' => $validatedData['interview_status'],
            'interview_marks' => $validatedData['interview_marks'],
        ]);
        return back()->with('success', 'Applicant Interview status updated successfully.');
    }

    public function confirm_applicant_interview(Request $request, $uuid)
    {
        $applied_applicant = Interview::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        $applied_applicant->interview_status = $request->interview_status;
        $applied_applicant->interview_marks = $request->interview_marks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
    }

    public function Interview_Qualified(Request $request)
    {
        $qualifiedIds = $request->input('record_ids', []);
        if (!empty($qualifiedIds)) {
            Interview::whereIn('applicant_id', $qualifiedIds)->update(['interview_status' => 'QUALIFIED']);

            $qualifiedApplicants = Interview::with('applicant')->whereIn('applicant_id', $qualifiedIds)->get();

            foreach ($qualifiedApplicants as $applicant) {
                if ($applicant->applicant) {
                    // Step 1: Get new sequential student index number
                    $originalSerial = $applicant->applicant->applicant_serial_number;
                    $newIndexNumber = $this->generateSequentialStudentIndex($originalSerial);

                    // Step 2: Get course ID
                    $course = OfferingCourse::where('cause_offers', $applicant->applicant->cause_offers)->first();
                    $courseId = $course ? $course->id : null;

                    // Step 3: Generate login
                    $code = mt_rand(100000, 999999);
                    $hashedPassword = Hash::make($code);

                    StudentLogin::updateOrCreate(
                        ['index_number' => $newIndexNumber],
                        [
                            'student_id'        => $applicant->applicant->id,
                            'code'              => $code,
                            'default_password'  => $hashedPassword,
                            'changed_password'  => '',
                            'fees'              => '3000',
                            'amount_paid'       => '3000',
                        ]
                    );

                    Student::firstOrCreate(
                        ['index_number' => $newIndexNumber],
                        [
                            'surname'             => $applicant->applicant->surname,
                            'other_names'         => $applicant->applicant->other_names,
                            'first_name'          => $applicant->applicant->first_name,
                            'sex'                 => $applicant->applicant->sex,
                            'contact'             => $applicant->applicant->contact,
                            'course_id'           => $courseId,
                            'marital_status'      => $applicant->applicant->marital_status,
                            'applicant_image'     => $applicant->applicant->applicant_image,
                            'email'               => $applicant->applicant->email,
                            'residential_address' => $applicant->applicant->residential_address,
                            'digital_address'     => $applicant->applicant->digital_address,
                            'date_of_birth'       => $applicant->applicant->date_of_birth,
                        ]
                    );
                }
            }
        }

        return redirect()->route('test.applicant-interview')->with([
            'message' => 'Applicants processed successfully!',
            'alert-type' => 'success'
        ]);
    }

    private function generateSequentialStudentIndex($serial)
    {
        // Expecting format: B-NUR-25-001
        $parts = explode('-', $serial);

        if (count($parts) === 4) {
            $prefix = strtoupper($parts[0] . $parts[1]); // e.g., B + NUR = BNUR
            $year = $parts[2]; // e.g., 25
            $basePrefix = $prefix . $year; // BNUR25

            // Find the last student index_number that starts with this prefix
            $lastStudent = Student::where('index_number', 'LIKE', $basePrefix . '%')
                ->orderBy('index_number', 'desc')
                ->first();
            if ($lastStudent && preg_match('/(\d{4})$/', $lastStudent->index_number, $matches)) {
                $lastNumber = (int)$matches[1];
                $nextNumber = str_pad((string)($lastNumber + 1), 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '0001';
            }

            // if ($lastStudent && preg_match('/(\d{4})$/', $lastStudent->index_number, $matches)) {
            //     $lastNumber = (int)$matches[1]; // Extract the last 4 digits
            //     $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            // } else {
            //     $nextNumber = '0001';
            // }

            return $basePrefix . $nextNumber; // e.g., BNUR250001
        }

        return null; // Invalid serial
    }



    // public function Interview_Qualified(Request $request)
    // {
    //     $qualifiedIds = $request->input('record_ids', []);
    //     if (!empty($qualifiedIds)) {
    //         // Update interview status
    //         Interview::whereIn('applicant_id', $qualifiedIds)->update(['interview_status' => 'QUALIFIED']);
    //         // Fetch the full applicant details
    //         $qualifiedApplicants = Interview::with('applicant')->whereIn('applicant_id', $qualifiedIds)->get();
    //         foreach ($qualifiedApplicants as $applicant) {
    //             if ($applicant->applicant) { // Ensure the relationship exists
    //                 // Find the course ID based on course name (cause_offers)
    //                 $course = OfferingCourse::where('cause_offers', $applicant->applicant->cause_offers)->first();
    //                 $courseId = $course ? $course->id : null; // Get ID or set null if not found
    //                 // Insert into Student table
    //                 $code = mt_rand(100000, 999999);
    //                 $hashedPassword = Hash::make($code);
    //                 StudentLogin::updateOrCreate(
    //                     ['index_number' => $applicant->applicant->applicant_serial_number],
    //                     [
    //                         'student_id'        => $applicant->applicant->id,
    //                         'code'             => $code,
    //                         'default_password' => $hashedPassword,
    //                         'changed_password' => '', // Or same as default if needed
    //                         'fees' => '3000',
    //                         'amount_paid' => '3000',
    //                     ]
    //                 );


    //                 Student::firstOrCreate(
    //                     ['index_number' => $applicant->applicant->applicant_serial_number],
    //                     [
    //                         'surname'             => $applicant->applicant->surname,
    //                         'other_names'         => $applicant->applicant->other_names,
    //                         'first_name'          => $applicant->applicant->first_name,
    //                         'sex'                 => $applicant->applicant->sex,
    //                         'contact'             => $applicant->applicant->contact,
    //                         'course_id'           => $courseId, // ✅ Save course ID
    //                         'marital_status'      => $applicant->applicant->marital_status,
    //                         'applicant_image'     => $applicant->applicant->applicant_image,
    //                         'email'               => $applicant->applicant->email,
    //                         'residential_address' => $applicant->applicant->residential_address,
    //                         'digital_address'     => $applicant->applicant->digital_address,
    //                         'date_of_birth'       => $applicant->applicant->date_of_birth,
    //                     ]
    //                 );
    //                 // Mail::to($applicant->applicant->email)->send(new QualifiedApplicantMail($applicant->applicant));
    //             }
    //         }
    //     }
    //     return redirect()->route('test.applicant-interview')->with([
    //         'message' => 'Applicants processed successfully!',
    //         'alert-type' => 'success'
    //     ]);
    // }

    public function notifyInterviewBulkQualified(Request $request)
    {
        Log::info('NotifyQualifiedApplicants hit', $request->all()); // or dd($request->all());
        $date = $request->input('date');
        // Retrieve all result verifications marked as 'QUALIFIED' and not yet notified
        $verifications = Interview::with('applicant')
            ->where('interview_status', 'QUALIFIED')
            ->whereNull('notified_at') // Only unnotified applicants
            ->get();
        Log::info('Total result verifications found: ' . $verifications->count());
        $notifiedCount = 0;
        // Loop through each verification and send notifications
        foreach ($verifications as $verification) {
            $applicant = $verification->applicant;
            if ($applicant) {
                Log::info('Notifying applicant: ' . ($applicant->surname ?? 'N/A'));

                Mail::to($applicant->email)->send(new QualifiedApplicantMail($applicant));
                send_sms(
                    $applicant->contact,
                    "Dear Applicant, congratulations! You have passed the interview. Kindly check your email for your admission letter. Good luck!"
                );

                $verification->notified_at = now();
                $verification->save();
                $notifiedCount++;
            } else {
                Log::warning('No applicant found for verification ' . $verification->id);
            }
        }

        Log::info('Qualified applicants notified: ' . $notifiedCount);

        return response()->json([
            'message' => $notifiedCount . ' applicants notified.'
        ]);
    }

    public function Interview_Disqualified(Request $request)
    {
        $disqualifiedIds = $request->input('record_ids', []); // Fix parameter name
        if (!empty($disqualifiedIds)) {
            Interview::whereIn('applicant_id', $disqualifiedIds)->update(['interview_status' => 'DISQUALIFIED']);
            return response()->json(['success' => true, 'message' => 'Applicants successfully disqualified!']);
        }
        return response()->json(['success' => false, 'message' => 'No applicants selected.'], 400);
    }
}
