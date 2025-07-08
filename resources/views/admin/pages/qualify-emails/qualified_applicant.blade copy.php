
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
        /* Centered Logo */
        .logo {
            text-align: center;
            margin-bottom: 5px;
        }
        .logo img {
            width: 80px; /* Adjust size as needed */
        }
        /* School Name Styling */
        .school-name {
    text-align: center;
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 25px; /* Increased space */
     }
        .school-name .green {
            color: green;
        }
        /* School Address */
    .school-address {
    text-align: right;
    font-size: 14px;
    font-weight: bold;
    margin-top: 10px; /* Ensure spacing from school name */
    margin-bottom: 25px;
    }

        /* Letter Header */
        .letter-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            text-decoration: underline;
        }
        /* Letter Body */
        .letter-body {
            font-size: 16px;
            line-height: 1.6;
        }
        /* Signature */
        .signature {
    margin-top: 25px;
    text-align: left;
    font-size: 16px;
    font-weight: bold;
}
        .signature-img {
    width: 150px; /* Adjust size as needed */
    height: auto;
    display: block;
    margin-top: 10px;
}
        /* Contact Information (Centered) */
        .contact-info {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- School Logo at the Top (Centered) -->
    <div class="logo">
        <img src="{{ public_path('371.png') }}" alt="School Logo">
    </div>

    <!-- School Name (Under Logo, "NURSING AND MIDWIFERY" in Green) -->
    <div class="school-name">
        GHANA ARMED FORCES COLLEGE OF <br>
        <span class="green">NURSING AND MIDWIFERY</span>
    </div>

    <!-- School Address (Aligned Right) -->
    <div class="school-address">
        GAFCONM<br>
        P.O. Box 123, Accra, Ghana<br>
        Email: info@gafcomm.edu.gh<br>
        Tel: +233 123 456 789
    </div>

    <!-- Letter Header (Centered & Underlined) -->
    <div class="letter-header">
      OFFER OF TEMPORAL ADMISSION
    </div>

    <!-- Letter Body -->
    <div class="letter-body">
        <p>Dear {{ $applicant->surname }} {{ $applicant->other_names }},</p>

        <p>We are pleased to inform you that you have successfully <strong>QUALIFIED</strong> for admission into the Ghana Armed Forces College of Nursing and Midwifery (GAFCONM). Congratulations on this achievement! Below are your admission details:</p>
        <p><strong>Full Name:</strong> {{ $applicant->surname }} {{ $applicant->other_names }}<br>
        <strong>Index Number:</strong> {{ $applicant->applicant_serial_number }}<br>
        <strong>Course Offered:</strong> {{ $applicant->cause_offers }}</p>


        <p><strong>Next Steps:</strong> Kindly check your email for further instructions regarding enrollment, fees, and the commencement date.</p>

        <p>If you have any questions, feel free to contact our admissions office.</p>

        <div class="signature">
            <img src="{{ public_path('signature.jpg') }}" alt="Signature" class="signature-img"><br>
            Best Regards, <br>
            <strong>Admissions Office</strong> <br>
            GAFCONM
        </div>
    </div>

    <!-- Centered Contact Information -->
    <div class="contact-info">
        <p>Email: <a href="mailto:info@gafconm.edu.gh">info@gafconm.edu.gh</a> | Phone: +233 123 456 789</p>
        <p>Website: <a href="https://www.gafconm.edu.gh">www.gafconm.edu.gh</a></p>
    </div>

</body>
</html>
