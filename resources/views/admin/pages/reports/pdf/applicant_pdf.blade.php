<!DOCTYPE html>
<html>

<head>
    <title>Applicant Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            position: relative;
            width: 100%;
            height: 100vh;
            /* Ensures body covers the full viewport height */
            overflow: hidden;
            /* Prevent scrolling */
        }
        .background {
            position: fixed;
            /* Use fixed to ensure it covers the viewport */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Cover the viewport height */
            background-image: url('{{ public_path('37 school.png') }}');
            background-size: 50px 50px;
            /* Set the size to the image's original size for repetition */
            background-repeat: repeat;
            /* Allow the image to repeat */
            background-position: top left;
            /* Position the first image at the top left */
            z-index: -1;
            /* Ensure it is behind the content */
            opacity: 0.2;
            /* Adjust opacity */
        }
        .content {
            position: relative;
            z-index: 1;
            padding: 0;
            /* Remove padding to use full height */
            margin: 0;
            /* Ensure no margins */
            box-sizing: border-box;
            width: 100%;
            height: 100vh;
            /* Ensure content takes full height of the viewport */
        }
        /* Ensure proper page breaks in printed format */
        @media print {
            body {
                overflow: visible;
                /* Allow overflow for printing */
                height: auto;
                /* Allow the body to grow with content */
            }

            .background {
                position: absolute;
                /* Position it normally for print */
                height: auto;
                /* Allow the height to adjust based on content */
                width: 100%;
                /* Maintain width for print */
            }

            .content {
                page-break-inside: avoid;
                /* Prevent breaks inside content */
                padding: 20px;
                /* Add padding back for print layout */
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 0;
            /* Remove margin to eliminate spacing */
        }

        th,
        td {
            border: none;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        img {
            border: none;
            display: block;
            /* Prevent any extra space below the image */
        }

        .status-right {
            text-align: right;
            padding-right: 20px;
        }

        .image-border {
            border: 2px solid #000;
            border-radius: 4px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="background"></div>
    <div class="content">
        <table>
            <tr>
                <td><b>GHANA ARMED FORCE NURSING AND MIDWIFERY</b></td>
                <td></td>
                <td class="status-right"><b>STATUS:</b> {{ $applied_applicant->qualification }}</td>
            </tr>
            <tr>
                <td><b>ONLINE APPLICATION.</b></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <p style="margin:0"><b>APPLIED AT:</b>
                        {{ \Carbon\Carbon::parse($applied_applicant->created_at)->format('d M, Y h:i A') }}
                    </p>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <p align="center"><b>APPLICATION SUMMARY REPORT</b></p>
        <table class="table-border">
            <tr align="center">
                @php
                    $imagePath = public_path($applied_applicant->applicant_image);
                @endphp
                <td>
                    @if (file_exists($imagePath))
                        <img id="showImage" src="{{ public_path($applied_applicant->applicant_image) }}" alt=""
                            height="170px" width="170px" class="img-thumbnail image-border">
                    @else
                        <img id="showImage" src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}" alt=""
                            width="170px" class="img-thumbnail image-border">
                    @endif
                </td>
            </tr>
        </table>
        <span></span>
        <p style="background-color: #F0FFFF;"><b>Bio Data:</b></p>
        <table class="cont" style="padding:0;">
            <tr>
                <td><b>Surname :</td>/td>
                <td>{{ $applied_applicant->surname }}</td>
                <td>
                </td>
                <td><b>Date of Birth :</b></td>
                <td>{{ \Carbon\Carbon::parse($applied_applicant->date_of_birth)->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td><b>Other Names :</b></td>
                <td>{{ $applied_applicant->other_names }}</td>
                <td></td>
                <td><b>Place of Birth :</b></td>
                <td>{{ $applied_applicant->place_of_birth }}</td>
            </tr>
            <tr>
                <td><b>Height :</b></td>
                <td>{{ $applied_applicant->height }}</td>
                <td></td>
                <td><b>Region :</b></td>
                <td>{{ $applied_applicant->regions->region_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><b>Weight :</b></td>
                <td>{{ $applied_applicant->weight }}</td>
            </tr>
            <tr>
                <td><b>Address :</b></td>
                <td>{{ $applied_applicant->residential_address }}</td>
                <td></td>
                <td><b>Hometown :</b></td>
                <td>{{ $applied_applicant->hometown }}</td>
            </tr>
            <tr>
                <td><b>Email :</b></td>
                <td>{{ $applied_applicant->email }}</td>
                <td></td>
                <td><b>Mobile Number :</b></td>
                <td>{{ $applied_applicant->contact }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Marital Status :</b></td>
                <td>{{ $applied_applicant->marital_status }}</td>
            </tr>
            <tr>
                <td><b>Sex :</b></td>
                <td>{{ $applied_applicant->sex }}</td>
                <td></td>
                <td><b>Language(s)</b></td>
                <td> @php
                    $languages = is_string($applied_applicant->language)
                        ? json_decode($applied_applicant->language, true)
                        : $applied_applicant->language;
                @endphp
                    {{ implode(', ', $languages ?? []) }}</td>
            </tr>
            <tr>
                <td><b>Sports Interest(s) :</b></td>
                <td> @php
                    $sportsInterests = is_string($applied_applicant->sports_interest)
                        ? json_decode($applied_applicant->sports_interest, true)
                        : $applied_applicant->sports_interest;
                @endphp
                    {{ implode(', ', $sportsInterests ?? []) }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <span></span>
        <p class="page-break" style="background-color: #F0FFFF"><b>Educational Data:</b></p>
        <p style="background-color: #DAF7A6; width:  180px;"><b>BECE Results:</b></p>
        <table class="cont" style="padding:0; margin-right: 5px;">
            <tr>
                <td width="280px"><b>{{ $applied_applicant->bece_english }}</b></td>
                <td> {{ $applied_applicant->bece_subject_english_grade }}</td>
                <td width="280px"><b>{{ $applied_applicant->bece_subject_four }}</b></td>
                <td align="left">{{ $applied_applicant->bece_subject_four_grade }}</td>
            </tr>
            <tr>
                <td width="280px"><b>{{ $applied_applicant->bece_mathematics }}</b></td>
                <td>{{ $applied_applicant->bece_subject_maths_grade }}</td>
                <td width="280px"> <b>{{ $applied_applicant->bece_subject_five }}</b></td>
                <td align="left">{{ $applied_applicant->bece_subject_five_grade }}</td>
            </tr>
            <tr>
                <td width="280px"><b>{{ $applied_applicant->bece_subject_three }}</b></td>
                <td>{{ $applied_applicant->bece_subject_three_grade }}</td>
                <td width="280px"><b>{{ $applied_applicant->bece_subject_six }}</b></td>
                <td align="left">{{ $applied_applicant->bece_subject_six_grade }}</td>
            </tr>
        </table>
        <p style="background-color: #DAF7A6; width:  180px;"><b>WASSCE Results:</b></p>
        <table class="cont" style="padding:0; margin-right: 5px;">
            <tr>
                <td width="280px"><b>{{ $applied_applicant->wassce_english }}</b></td>
                <td>{{ $applied_applicant->wassce_subject_english_grade }}</td>
                <td width="280px"><b>{{ $applied_applicant->wassce_subject_four }}</b></td>
                <td align="left">{{ $applied_applicant->wassce_subject_four_grade }}</td>
            </tr>
            <tr>
                <td width="280px"><b>{{ $applied_applicant->wassce_mathematics }}</b></td>
                <td>{{ $applied_applicant->wassce_subject_maths_grade }}</td>
                <td width="280px"> <b>{{ $applied_applicant->wassce_subject_five }}</b></td>
                <td align="left">{{ $applied_applicant->wassce_subject_five_grade }}</td>
            </tr>
            <tr>
                <td width="280px"><b>{{ $applied_applicant->wassce_subject_three }}</b></td>
                <td>{{ $applied_applicant->wassce_subject_three_grade }}</td>
                <td width="280px"><b>{{ $applied_applicant->wassce_subject_six }}</b></td>
                <td align="left">{{ $applied_applicant->wassce_subject_six_grade }}</td>
            </tr>
        </table>
        <p style="background-color: #DAF7A6; width:  180px;"><b>Education Details:</b></p>
        <table class="cont" style="padding:0; margin-right: 5px;">
            <tr>
                <td><b>Secondary School:</b></td>
                <td>{{ $applied_applicant->name_of_secondary_school }}</td>
                <td><b>Year of Completion:</b></td>
                <td align="left">
                    {{ \Carbon\Carbon::parse($applied_applicant->wassce_year_completion)->format('d M, Y') }}
                </td>
            </tr>
            <tr>
                <td><b>WASSCE Index No:</b></td>
                <td>{{ $applied_applicant->wassce_index_number }}</td>
                <td> <b>WASSCE Serial No:</b></td>
                <td align="left">{{ $applied_applicant->wassce_serial_number }}</td>
            </tr>
            <tr>
                <td><b>BECE Index No:</b></td>
                <td>{{ $applied_applicant->bece_index_number }}</td>
                <td><b>Year of Completion:</b></td>
                <td align="left">
                    {{ \Carbon\Carbon::parse($applied_applicant->bece_year_completion)->format('d M, Y') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="8" class="text-center">
                        <label class="custom-control-label">
                            I <b>{{ $applied_applicant->surname }} {{ $applied_applicant->other_names }}</b> declare
                            that all the information given on this form
                            are correct to the best of my knowledge and understand that
                            <span class="text-danger">any false statement or omission may be liable for
                                prosecution.</span>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
</html>
