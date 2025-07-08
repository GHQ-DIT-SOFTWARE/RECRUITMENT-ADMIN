<!DOCTYPE html>
<html>
<head>
    <title>Offer of Admission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: justify;
            margin: 50px;
        }
        .logo {
            text-align: center;
            margin-bottom: 5px;
        }
        .logo img {
            width: 80px;
        }
        .school-name {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .school-name .green {
            color: green;
        }
        .school-address {
    width: 350px;
    margin-left: 350px; /* Push block to the right */
    text-align: left;
    font-size: 14px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 25px;
    text-transform: uppercase;
    line-height: 1.6;
    white-space: nowrap;
}

        .letter-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            text-decoration: underline;
        }
        .letter-body {
            font-size: 16px;
            line-height: 1.6;
        }
        .signature {
            margin-top: 25px;
            text-align: left;
            font-size: 16px;
            font-weight: bold;
        }
        .signature-img {
            width: 150px;
            height: auto;
            display: block;
            margin-top: 10px;
        }
        .contact-info {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="logo">
        <img src="{{ public_path('gafnursingandmidfery.png') }}" alt="School Logo">
    </div>
    <div class="school-name">
        GAFCONM
        {{-- GHANA ARMED FORCES COLLEGE OF <br>
        <span class="green">NURSING AND MIDWIFERY</span> --}}
    </div>
    <div class="school-address">
    GHANA ARMED FORCES COLLEGE OF <br>
    NURSING & MIDWIFERY<br>
    NEGHELLI BARRACKS<br>
    ACCRA<br>
    <br>
    {{\Carbon\Carbon::now()->format('d F Y') }}
</div>

    <div class="letter-header">
        OFFER OF TEMPORAL ADMISSION
    </div>

    <div class="letter-body">
    <p>Dear {{ $applicant->surname }} {{ $applicant->first_name }} {{ $applicant->other_names }},</p>

    <p><strong>1.</strong> I have the pleasure to inform you that you have been offered a temporal admission to GAFCONM, 37 Military Hospital to pursue a {{ $applicant->cause_offers }}.</p>

    <p><strong>2.</strong> The College runs two semesters in an academic year. At the end of the academic year, a student whose PA falls below 1.5 shall be withdrawn from the College. Every student must come along with a valid National Health Insurance Scheme (NHIS) card on the reporting day.</p>

    <p><strong>3.</strong> On successful passing of prescribed examinations, you will be awarded a Bachelor of Science in Nursing certificate by the University of Cape Coast (UCC) and licensed to practice as a General Nurse by the Nursing and Midwifery Council of Ghana.</p>

    <p><strong>4.</strong> The College does not grant financial assistance to students. The College is also a non-residential institution.</p>

    <p><strong>5.</strong> You are to submit an acceptance letter to the Principal and pay a non-refundable admission fee of One Thousand Five Hundred Ghana Cedis (GHC 1,500.00) on or before 16<sup>th</sup> September, 2024 into Consolidated Bank Ghana (CBG), Account Name: 37 Military Hospital, Admission Account Number: <strong>1760746100002</strong>, Trade Fair Branch.</p>

    <p><strong>6.</strong> Prospective students are to pay for their school uniforms (females – GHC 620.00 and males – GHC 680.00) on or before 21<sup>st</sup> October, 2024 into the College's Consolidated Bank Ghana (CBG), Account Name: 37 Military Hospital, Admission Account Number: <strong>1760746100002</strong>, Trade Fair Branch.</p>

    <p><strong>7.</strong> You are advised to pay the full First Semester Fees of Two Thousand Two Hundred and Fifty Ghana Cedis (GHC 2,250.00) into the College's Ghana Commercial Bank (GCB) Account, Account Number: <strong>1021130011590</strong>, Account Name: 37 Military Hospital NMTC, GCB Burma Camp Branch.</p>

    <p><strong>8.</strong> <strong>Next Steps:</strong> Kindly check your email for further instructions regarding enrollment, fees, and the commencement date.</p>

    <p><strong>9.</strong> If you have any questions, feel free to contact our admissions office.</p>
        <p>We wish you the very best in your academic journey with us.</p>
       @if ($principal && !empty($principal->signature))
    <div class="signature">
        <img src="{{ public_path($principal->signature) }}" alt="Principal Signature" class="signature-img" style="width: 200px; height: auto;"><br>
        <b>BA ADDAE,</b><br>
        <b>MAJ</b><br>
        <b>Acting Principal</b>
    </div>
@else
    <div class="signature">
        <p><i>Principal's signature not available</i></p>
    </div>
@endif
    </div>

    <div class="contact-info">
        <p>Email: <a href="mailto:info@gafconm.edu.gh">info@gafconm.edu.gh</a> | Phone: +233 302 769 369</p>
        <p>Website: <a href="https://www.gafconm.edu.gh">www.gafconm.edu.gh</a></p>
    </div>

</body>
</html>
