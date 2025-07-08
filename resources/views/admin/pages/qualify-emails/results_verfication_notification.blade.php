<!DOCTYPE html>
<html>
<head>
    <title>Aptitude Test Invitation</title>
</head>
<body>
    <p>Dear {{ $applicant->surname }} {{ $applicant->other_names }},</p>
   <p>You are requiredv to report for Aptitude Test</p>
<p><strong>Scheduled for the following details:</strong></p>
<ul>
    <li><strong>Date:</strong> {{ $date }}</li>
    <li><strong>Time:</strong> {{ $time }}</li>
    <li><strong>Venue:</strong> {{ $venue }}</li>
</ul>
<p>We wish you the best of luck!</p>
<p>Kind regards,<br>
{{ config('app.name') }} Team</p>
</body>
</html>
