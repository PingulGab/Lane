<?php

$path = public_path('images/auf_logo.png'); // Corrected path for the image
$imageData = base64_encode(file_get_contents($path));
$aufLogo = 'data:image/png;base64,' . $imageData;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Add your styles here */
        @page {
            margin: 100px 25px;
            /* Adjust margins for the header */
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: #f5f5f5;
            color: #333;
            text-align: center;
            line-height: 50px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        h1,
        h2 {
            font-size: 18px;
        }

        .leading-paragraph {
            text-align: justify;
            margin-bottom: 15px;
        }

        .indented-paragraph {
            text-indent: 35px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .indented-paragraph-list {
            padding-left: 50px;
            margin-bottom: 0px;
            line-height: 1;
        }

        .numbered-paragraph {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.5;
            text-indent: -30px;
            /* Indent the number out of the paragraph */
            padding-left: 30px;
            /* Offset the paragraph text to align after the number */
        }

        .numbered-paragraphChild {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.5;
            text-indent: 0px;
            /* Indent the number out of the paragraph */
            padding-left: 35px;
            /* Offset the paragraph text to align after the number */
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .page-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* Full viewport height */
            text-align: center;
        }

        label {
            display: block;
        }

        /* General Table Styling */
        .proposalTbl {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            font-size: 18px !important;
        }

        /* Header row styling */
        .proposalTbl th,
        .proposalTbl td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        /* Title row styling */
        .proposalTbl th {
            background-color: #002060;
            color: white;
            font-weight: bold;
        }

        /* Column Headers */
        .section-title {
            font-weight: bold;
            width: 40%;
            font-size: 18px;
        }

        /* Subheaders with merged cells */
        .subheader {
            font-weight: bold;
            vertical-align: top;
            text-align: left;
            width: 20%;
            font-size: 18px;
        }

        /* Instructions text */
        .instructions {
            font-style: italic;
            font-size: 12px;
            margin: 0px;
            padding: 0px;
        }

        /* Special row for title of the part */
        .part-title {
            background-color: #002060;
            color: white;
            text-align: left;
            font-weight: bold;
            padding: 8px;
            font-size: 18px;
        }

        .textarea {
            width: 100%;
        }
    </style>
</head>

<body>
    <div style="width: 100%; text-align: center; margin-top: -30px;">
        <div style="display: inline-block; vertical-align: top; width: 100px;">
            <img src="{{ $aufLogo }}" style="height: 100px;">
        </div>
        <div
            style="display: inline-block; vertical-align: top; text-align: center; margin-left: 20px; margin-top: 20px;">
            <h1 style="margin: 0;"> ANGELES UNIVERSITY FOUNDATION </h1>
            <h2 style="margin: 0;"> OFFICE OF GLOBAL RELATIONS </h2>
        </div>
    </div>

    <br>

    <h1 class="text-center"> PARTNERSHIP PROPOSAL FORM </h1>
    <div class="content">
        <p class="leading-paragraph">
            <span class="bold">Directions: </span>
            Please be informed that this “Partnership Proposal Form”
            is intended for prospective international institutions that intend to partner with Angeles University
            Foundation,
            Philippines. The data gathered from this form will be processed in accordance with the
            <a href="https://privacy.auf.edu.ph/"> University’s Privacy Policy</a>.
            Please accomplish this form to give us an overview of the proposed partnership between your institution and
            the AUF.
            Once you have filled out this form, please send it to the OGR email address,
            <a href="mailto:ogr@auf.edu.ph">ogr@auf.edu.ph</a>.
            We will review your proposal
            and notify you of the next steps to be taken. For any inquiries or clarifications, please feel free to
            contact us at +63 045 625 2888 local 1783.
        </p>

        <table class="proposalTbl">
            <!-- Part I -->
            <tr>
                <th colspan="3" class="part-title">PART I. INSTITUTION’S BACKGROUND</th>
            </tr>
            <tr>
                <td class="section-title" colspan="1">NAME OF THE INSTITUTION</td>
                <td colspan="2"> {{ $partnership->proposalForm->institution_name }} </td>
            </tr>
            <tr>
                <td class="section-title" colspan="1">COUNTRY</td>
                <td colspan="2">{{ $partnership->proposalForm->country }}</td>
            </tr>
            <tr>
                <td class="section-title" colspan="1">TYPE OF INSTITUTION</td>
                <td colspan="2">{{ $partnership->proposalForm->type_of_institution }}</td>
            </tr>

            <!-- Contact Information -->
            <tr>
                <td class="section-title" rowspan="5" colspan="1">CONTACT INFORMATION OF INSTITUTION</td>
                <td class="subheader" colspan="1">EMAIL ADDRESS</td>
                <td colspan="1">{{ $partnership->proposalForm->email }}</td>
            </tr>
            <tr>
                <td class="subheader" colspan="1">TELEPHONE NO.</td>
                <td colspan="1">{{ $partnership->proposalForm->telephone_number }}</td>
            </tr>
            <tr>
                <td class="subheader" colspan="1">MOBILE NO.</td>
                <td colspan="1">{{ $partnership->proposalForm->mobile_number }}</td>
            </tr>
            <tr>
                <td class="subheader" colspan="1">WEBSITE</td>
                <td colspan="1">{{ $partnership->proposalForm->website }}</td>
            </tr>
            <tr>
                <td class="section-title" colspan="1">ADDRESS</td>
                <td colspan="1">{{ $partnership->proposalForm->address }}</td>
            </tr>

            <!-- Overview of the Institution -->
            <tr>
                <td class="section-title" colspan="1">OVERVIEW OF THE INSTITUTION</td>
                <td colspan="2">{{ $partnership->proposalForm->institution_overview }}</td>
            </tr>

            <!-- Local & International Accreditation -->
            <tr>
                <td class="section-title" colspan="1">LOCAL & INTERNATIONAL ACCREDITATION</td>
                <td colspan="2">
                    <ul>
                        <?php
                        $accreditations = json_decode($partnership->proposalForm->institution_accreditation, true) ?? [];
                        ?>
                        <?php foreach ($accreditations as $accreditation): ?>
                        <li><?= htmlspecialchars($accreditation) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>

            <!-- Part II -->
            <tr>
                <th colspan="3" class="part-title">PART II. INSTITUTION’S LINKAGES AND PARTNERS</th>
            </tr>
            <tr>
                <td class="section-title" colspan="1">NAME OF INSTITUTION</td>
                <td class="section-title" colspan="1">NATURE OF PARTNERSHIP</td>
                <td class="section-title" colspan="1">VALIDITY PERIOD</td>
            </tr>
            @if($partnership->proposalForm->partnerLinkages->isEmpty())
            <!-- If no partner linkages, render one empty row -->
            <tr>
                <td colspan="1">
                    .
                </td>
                <td colspan="1">
                    .
                </td>
                <td colspan="1">
                    .
                </td>
            </tr>
        @else
            <?php
            $partnerLinkages = $partnership->proposalForm->partnerLinkages ?? [];
            ?>
            <?php foreach ($partnerLinkages as $linkage): ?>
            <tr>
                <td colspan="1"><?= htmlspecialchars($linkage->institution_name) ?></td>
                <td colspan="1"><?= htmlspecialchars($linkage->nature_of_partnership) ?></td>
                <td colspan="1"><?= htmlspecialchars($linkage->validity_period) ?></td>
            </tr>
            <?php endforeach; ?>
        @endif
        </table>
        <div style="page-break-after: always;"></div>
        <table class="proposalTbl">
            <!-- Part III -->
            <tr>
                <th colspan="3" class="part-title">PART III. PROPOSED PARTNERSHIP</th>
            </tr>

            <!-- Target Participant & Level -->
            <tr>
                <?php
                $storedTargetParticipant = $partnership->proposalForm->target_participant;
                $storedTargetLevel = $partnership->proposalForm->target_level;
                ?>
                <td class="section-title" rowspan="2">TARGET PARTICIPANT & LEVEL</td>
                <td colspan="2">
                    <input type="radio" name="target_participant" value="Student" <?php echo $storedTargetParticipant === 'Student' ? 'checked' : 'disabled'; ?>> Student<br>
                    <input type="radio" name="target_participant" value="Faculty" <?php echo $storedTargetParticipant === 'Faculty' ? 'checked' : 'disabled'; ?>> Faculty<br>
                    <input type="radio" name="target_participant" value="Researcher" <?php echo $storedTargetParticipant === 'Researcher' ? 'checked' : 'disabled'; ?>>
                    Researcher<br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="radio" id="elementary" name="target_level" value="Elementary" <?php echo $storedTargetLevel === 'Elementary' ? 'checked' : 'disabled'; ?>>
                    Elementary<br>

                    <input type="radio" id="junior_high_school" name="target_level" value="Junior High School"
                        <?php echo $storedTargetLevel === 'Junior High School' ? 'checked' : 'disabled'; ?>> Junior High School<br>

                    <input type="radio" id="senior_high_school" name="target_level" value="Senior High School"
                        <?php echo $storedTargetLevel === 'Senior High School' ? 'checked' : 'disabled'; ?>> Senior High School<br>

                    <input type="radio" id="undergraduate" name="target_level" value="Undergraduate"
                        <?php echo $storedTargetLevel === 'Undergraduate' ? 'checked' : 'disabled'; ?>> Undergraduate<br>

                    <input type="radio" id="graduate_school" name="target_level" value="Graduate School"
                        <?php echo $storedTargetLevel === 'Graduate School' ? 'checked' : 'disabled'; ?>> Graduate School<br>
                    <input type="radio" id="esl" name="target_level" value="Certification Program (ESL)"
                        <?php echo $storedTargetLevel === 'Certification Program (ESL)' ? 'checked' : 'disabled'; ?>> Certification Program (ESL)<br>
                </td>
            </tr>


            <!-- Target Program or Course -->
            <tr>
                <td class="section-title" colspan="1">TARGET PROGRAM OR COURSE:</td>
                <td colspan="2">{{ $partnership->proposalForm->institutionalUnit->name }}</td>
            </tr>
            <!-- Type of Partnership -->
            <?php
            $selected_type_of_partnership = $partnership->proposalForm->type_of_partnership;
            ?>
            <tr>
                <td class="section-title" colspan="3">TYPE OF PARTNERSHIP:</td>
            </tr>

            <tr>
                <td colspan="1">
                    <span class="bold">Non-Degree Program</span><br><br>
                    <input type="radio" name="type_of_partnership" value="English as Second Language (ESL)"
                        <?php echo $selected_type_of_partnership == 'English as Second Language (ESL)' ? 'checked' : 'disabled'; ?>>
                    English as Second Language (ESL) <br>

                    <input type="radio" name="type_of_partnership" value="Audit Class / Sit-in Class"
                        <?php echo $selected_type_of_partnership == 'Audit Class / Sit-in Class' ? 'checked' : 'disabled'; ?>>
                    Audit Class / Sit-in Class<br>

                    <input type="radio" name="type_of_partnership" value="Study and Tour Program"
                        <?php echo $selected_type_of_partnership == 'Study and Tour Program' ? 'checked' : 'disabled'; ?>>
                    Study and Tour Program<br>

                    <input type="radio" name="type_of_partnership" value="Conference / Seminar"
                        <?php echo $selected_type_of_partnership == 'Conference / Seminar' ? 'checked' : 'disabled'; ?>>
                    Conference / Seminar<br>

                    <input type="radio" name="type_of_partnership" value="Non-Degree Program - Others"
                        id="non-degree-others" <?php echo strpos($selected_type_of_partnership, 'Non-Degree Program - ') === 0 ? 'checked' : 'disabled'; ?>>
                    Others

                    <!-- Show the input box only if 'Others' was selected -->
                    <input type="text" id="non-degree-input" name="non_degree_other_value"
                        placeholder="Please specify" value="<?php echo strpos($selected_type_of_partnership, 'Non-Degree Program - ') === 0 ? substr($selected_type_of_partnership, 18) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Non-Degree Program - ') === 0 ? '' : 'display: none;'; ?>"
                        disabled>

                    <span class="bold"><br><br>Research Program</span><br><br>
                    <input type="radio" name="type_of_partnership" value="Collaborative Research"
                        <?php echo $selected_type_of_partnership == 'Collaborative Research' ? 'checked' : 'disabled'; ?>>
                    Collaborative Research<br>

                    <input type="radio" name="type_of_partnership" value="Capacity Building Program"
                        <?php echo $selected_type_of_partnership == 'Capacity Building Program' ? 'checked' : 'disabled'; ?>>
                    Capacity Building Program<br>

                    <input type="radio" name="type_of_partnership" value="Research Dissemination Program"
                        <?php echo $selected_type_of_partnership == 'Research Dissemination Program' ? 'checked' : 'disabled'; ?>>
                    Research Dissemination Program<br>

                    <input type="radio" name="type_of_partnership" value="Research Utilization Program"
                        <?php echo $selected_type_of_partnership == 'Research Utilization Program' ? 'checked' : 'disabled'; ?>>
                    Research Utilization Program<br>

                    <input type="radio" name="type_of_partnership" value="Research Program - Others"
                        id="degree-others" <?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? 'checked' : 'disabled'; ?>>
                    Others

                    <!-- Show the input box only if 'Others' was selected -->
                    <input type="text" id="degree-input" name="degree_other_value" placeholder="Please specify"
                        value="<?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? substr($selected_type_of_partnership, 17) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Research Program - ') === 0 ? '' : 'display: none;'; ?>" disabled>
                </td>
                <td colspan="2">
                    <span class="bold">Degree Program</span><br><br>
                    <input type="radio" name="type_of_partnership" value="Academic Franchising"
                        <?php echo $selected_type_of_partnership == 'Academic Franchising' ? 'checked' : 'disabled'; ?>>
                    Academic Franchising<br>

                    <input type="radio" name="type_of_partnership" value="Program Articulation"
                        <?php echo $selected_type_of_partnership == 'Program Articulation' ? 'checked' : 'disabled'; ?>>
                    Program Articulation<br>

                    <input type="radio" name="type_of_partnership" value="Branch or International Campus"
                        <?php echo $selected_type_of_partnership == 'Branch or International Campus' ? 'checked' : 'disabled'; ?>>
                    Branch or International Campus<br>

                    <input type="radio" name="type_of_partnership" value="Double Degree"
                        <?php echo $selected_type_of_partnership == 'Double Degree' ? 'checked' : 'disabled'; ?>>
                        Double Degree<br>

                    <input type="radio" name="type_of_partnership" value="Joint Degree"
                        <?php echo $selected_type_of_partnership == 'Joint Degree' ? 'checked' : 'disabled'; ?>>
                        Joint Degree<br>

                    <input type="radio" name="type_of_partnership" value="Online, Blended, and Distance Learning"
                        <?php echo $selected_type_of_partnership == 'Online, Blended, and Distance Learning' ? 'checked' : 'disabled'; ?>>
                    Online, Blended, and Distance Learning<br>

                    <input type="radio" name="type_of_partnership" value="Twinning Arrangements"
                        <?php echo $selected_type_of_partnership == 'Twinning Arrangements' ? 'checked' : 'disabled'; ?>>
                    Twinning Arrangements<br>

                    <input type="radio" name="type_of_partnership" value="Degree Program - Others"
                        id="degree-others" <?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? 'checked' : 'disabled'; ?>>
                    Others

                    <!-- Show the input box only if 'Others' was selected -->
                    <input type="text" id="degree-input" name="degree_other_value" placeholder="Please specify"
                        value="<?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? substr($selected_type_of_partnership, 15) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Degree Program - ') === 0 ? '' : 'display: none;'; ?>" disabled>

                    <span class="bold"><br><br>Mobility Program</span><br><br>
                    <input type="radio" name="type_of_partnership" value="Inbound Student" <?php echo $selected_type_of_partnership == 'Inbound Student' ? 'checked' : 'disabled'; ?>>
                    Inbound Student<br>

                    <input type="radio" name="type_of_partnership" value="Outbound Student" <?php echo $selected_type_of_partnership == 'Outbound Student' ? 'checked' : 'disabled'; ?>>
                    Outbound Student<br>

                    <input type="radio" name="type_of_partnership" value="Inbound Teacher" <?php echo $selected_type_of_partnership == 'Inbound Teacher' ? 'checked' : 'disabled'; ?>>
                    Inbound Teacher<br>

                    <input type="radio" name="type_of_partnership" value="Outbound Teacher" <?php echo $selected_type_of_partnership == 'Outbound Teacher' ? 'checked' : 'disabled'; ?>>
                    Outbound Teacher<br>

                    <input type="radio" name="type_of_partnership" value="Mobility Program - Others"
                        id="degree-others" <?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? 'checked' : 'disabled'; ?>>
                    Others

                    <!-- Show the input box only if 'Others' was selected -->
                    <input type="text" id="degree-input" name="degree_other_value" placeholder="Please specify"
                        value="<?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? substr($selected_type_of_partnership, 18) : ''; ?>" style="<?php echo strpos($selected_type_of_partnership, 'Mobility Program - ') === 0 ? '' : 'display: none;'; ?>" disabled>
                </td>
            </tr>

            <!-- Overview of Proposed Partnership -->
            <tr>
                <td class="section-title">OVERVIEW OF THE PROPOSED PARTNERSHIP:</td>
                <td colspan="2">{{ $partnership->proposalForm->partnership_overview }}</td>
            </tr>

            <!-- Part IV -->
            <tr>
                <th colspan="3" class="part-title">PART IV. CONTACT PERSON</th>
            </tr>

            <!-- Contact Person -->
            <tr>
                <td class="section-title" rowspan="6" colspan="1">CONTACT PERSON / LIAISON OFFICER</td>
                <td colspan="1" class="subheader">NAME</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->name }}</td>
            </tr>
            <tr>
                <td colspan="1" class="subheader">EMAIL ADDRESS</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->email }}</td>
            </tr>
            <tr>
                <td colspan="1" class="subheader">POSITION</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->position }}</td>
            </tr>
            <tr>
                <td colspan="1" class="subheader">OFFICE</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->office }}</td>
            </tr>
            <tr>
                <td colspan="1" class="subheader">TELEPHONE NUMBER</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->telephone_number }}</td>
            </tr>
            <tr>
                <td colspan="1" class="subheader">MOBILE NUMBER</td>
                <td colspan="1">{{ $partnership->proposalForm->contactPerson->mobile_number }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
