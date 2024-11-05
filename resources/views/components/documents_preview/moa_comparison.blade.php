<?php 
        $memorandum = $document->memorandum;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOA PDF</title>
    <style>
        h2{
            font-size: 18px;
            
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
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
            text-indent: -30px;  /* Indent the number out of the paragraph */
            padding-left: 30px;  /* Offset the paragraph text to align after the number */
        }

        .numbered-paragraphChild {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.5;
            text-indent: 0px;  /* Indent the number out of the paragraph */
            padding-left: 35px;  /* Offset the paragraph text to align after the number */
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
        height: 100vh; /* Full viewport height */
        text-align: center;
        }
    </style>
</head>
<body>
    {{-- Page 1: Front Page --}}
    <div id="page1">
        <div class="page-center">
            <h2 class="text-center">ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)</h2>
            <h2 class="text-center">AND</h2>
            <h2 class="text-center">{{strtoupper($document->proposalForm->institution_name)}} ({{strtoupper($document->proposalForm->country)}})</h2>
            <br><br><br>
            <h2 class="text-center">MEMORANDUM OF AGREEMENT FOR {{strtoupper($memorandum->partnership_title)}}</h2>
        </div>
    </div>

    {{-- Page 2: Introduction and Witnesseth --}}
    <div id="page2">
        <div style="page-break-after: always;"></div>
        <h2 class="text-center">MEMORANDUM OF AGREEMENT</h2>
        <p class="leading-paragraph">KNOW ALL MEN BY THESE PRESENTS:</p>
        <p class="indented-paragraph">
            This Memorandum of Agreement is executed on <span class="bold">{{$memorandum->sign_date}}</span>, in <span
                class="bold">{{$memorandum->sign_location}}</span>, by and between:
        </p>

        <p class="indented-paragraph">
            <span class="bold">ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)</span>, a higher
            education institution duly organized and existing under the laws of the Republic of the
            Philippines, with principal address at MacArthur Highway, Angeles City, Philippines,
            duly represented herein by its President,
            <span class="bold">DR. JOSEPH EMMANUEL L. ANGELES </span>(hereafter referred to as
            <span class="bold">"AUF"</span>).
        </p>

        <p class="text-center">and</p>

        <p class="indented-paragraph">
            <span class="bold"> {{ strtoupper($document->proposalForm->institution_name) }}
                ({{ $document->proposalForm->country }})</span>,
            {{ $document->proposalForm->institution_overview }} Herein represented by its {{$document->proposalForm->institution_head_title}},
            <span class="bold">
                {{ strtoupper($document->proposalForm->institution_head) }}</span>, (hereafter
            referred to as <span
                class="bold">"{{ $document->proposalform->institution_name_acronym }}"</span>).
        </p>

        <br>
        <h2 class="bold text-center"> WITNESSETH THAT: </h2>
        @foreach($whereasDiff as $clause)
                @if($clause['status'] === 'removed')
                    <p class="indented-paragraph"> <span class="removed">WHEREAS, {{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span> </p>
                @elseif($clause['status'] === 'added')
                <p class="indented-paragraph"> <span class="added">WHEREAS, {{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span> </p>
                @elseif($clause['status'] === 'changed')
                <p class="indented-paragraph"> <span class="removed">WHEREAS, {{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">WHEREAS, {{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span> </p>
                @elseif($clause['status'] === 'unchanged')
                <p class="indented-paragraph"> <span class="unchanged">WHEREAS, {{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span> </p>
                @endif
        @endforeach
        
        @include('components.memorandum._witnessethSection2', ['link' => $document])
    </div>

    {{-- Page 3: Article 1 --}}
    <div id="page3">
        <br>
        <h2 class="text-center">ARTICLE 1<br>PROGRAM OVERVIEW</h2>
        
        @php $subCounter1 = 1; @endphp <!-- Counter for Article 1 numbering (1.1, 1.2, ...) -->
        
        @foreach($diffArticle1 as $clause)
            <p class="numbered-paragraph"> <!-- Applying "numbered-paragraph" class as specified -->
                <span class="clause-number">1.{{ $subCounter1 }}</span> <!-- Format as 1.1, 1.2, ... -->
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter1++; @endphp <!-- Increment the sub-counter for Article 1 -->
        @endforeach
    </div>

    {{-- Page 4: Article 2 --}}
    <div id="page4">
        <br>
        <h2 class="text-center">ARTICLE 2<br>REPRESENTATION AND WARRANTIES</h2>
        <p class="numbered-paragraph">2.1. The AUF hereby represents and warrants that:</p>
        
        <!-- Static numbered-paragraphChild items under 2.1 -->
        <p class="numbered-paragraphChild">2.1.1. It is a duly organized educational corporation under the laws of the Republic of the Philippines.</p>
        <p class="numbered-paragraphChild">2.1.2. It is a recognized institution of higher learning duly authorized by the regulatory authorities of the Republic of the Philippines to offer degree and post­ degree programs and to carry on its business as it is being conducted.</p>
        <p class="numbered-paragraphChild">2.1.3. It has qualified faculty members to teach the academic programs covered by this MOA.</p>
        <p class="numbered-paragraphChild">2.1.4. It has sufficient number of personnel who shall ensure the smooth implementation of this MOA.</p>
        <p class="numbered-paragraphChild">2.1.5. It has the necessary educational facilities and learning resources suitable for the academic programs to be offered pursuant to this MOA.</p>
        <p class="numbered-paragraphChild">2.1.6. Its entry into and performance, and the transactions contemplated by, this MOA do not and will not conflict with: (i) any law applicable to the AUF; (ii) its constitutional documents; or (iii) any agreement or instrument binding upon it or any of its assets.</p>
        <p class="numbered-paragraphChild">2.1.7. The signatory to this MOA is duly authorized by its governing Board to validly enter into this MOA.</p>
        
        <p class="numbered-paragraph">2.2. The {{$document->proposalForm->institution_name_acronym}} hereby represents and warrants that:</p>
    
        @php $subCounter2 = 1; @endphp <!-- Counter for Article 2 additional numbering (2.2.1, 2.2.2, ...) -->
        
        @foreach($diffArticle2 as $clause)
            <p class="numbered-paragraphChild"> <!-- Applying "numbered-paragraphChild" class as specified -->
                <span class="clause-number">2.2.{{ $subCounter2 }}</span> <!-- Format as 2.2.1, 2.2.2, ... -->
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter2++; @endphp <!-- Increment the sub-counter for Article 2 -->
        @endforeach
    </div>
    
    {{-- Page 5: Article 3 --}}
    <div id="page5">
        <br>
        <h2 class="text-center">ARTICLE 3<br>SCOPE OF COLLABORATION</h2>
        
        @php $subCounter3 = 1; @endphp <!-- Counter for Article 3 numbering (3.1, 3.2, ...) -->
        
        @foreach($diffArticle3 as $clause)
            <p class="numbered-paragraph"> <!-- Applying "numbered-paragraph" class as specified -->
                <span class="clause-number">3.{{ $subCounter3 }}</span> <!-- Format as 3.1, 3.2, ... -->
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter3++; @endphp <!-- Increment the sub-counter for Article 3 -->
        @endforeach
    </div>

    {{-- Page 6: Article 4 --}}
    <div id="page6">
        <br>
        <h2 class="text-center"> ARTICLE 4<br>RESPONSIBILITIES OF AUF </h2>
        @php $subCounter = 1; @endphp
        
        @foreach($diffArticle4 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">4.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 7: Article 5 --}}
    <div id="page7">
        <br>
        <h2 class="text-center"> ARTICLE 5<br>RESPONSIBILITIES OF {{$document->proposalForm->institution_name_acronym}} </h2>
        @php $subCounter = 1; @endphp
        
        @foreach($diffArticle5 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">5.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 8: Article 6 --}}
    <div id="page8">
        <br>
        <h2 class="text-center"> ARTICLE 6<br>RESPONSIBILITIES OF AUF AND {{$document->proposalForm->institution_name_acronym}} </h2>
        @php $subCounter = 1; @endphp
        
        @foreach($diffArticle6 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">6.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 9: Article 7 --}}
    <div id="page9">
        <br>
        <h2 class="text-center"> ARTICLE 7 <br> INTELLECTUAL PROPERTY RIGHTS </h2>
        <p class="numbered-paragraph"> 7.1. Intellectual property will include any property defined as such by the Intellectual Property Code of the Philippines (RA 8293) and other international agreements to which the Philippines is a signatory; </p>
        <p class="numbered-paragraph"> 7.2. Any intellectual property owned by the Parties prior to this Agreement will continue to be owned by them. Neither Party shall use any confidential information or data to create intellectual property without the express written approval of the other Party; </p>
        <p class="numbered-paragraph"> 7.3. Any intellectual property independently created by any of the Parties during the period covered by this Agreement will be exclusively owned by the Party responsible therefore; </p>
        <p class="numbered-paragraph"> 7.4. In case of joint creation, intellectual property will belong to the Parties jointly in proportion to their contribution; </p>
        <p class="numbered-paragraph"> 7.5. Other than the academic programs covered by this MOA, none of the Parties shall use the name, logo, trademark or other intellectual property of the other Party for any advertising, marketing, endorsement or any other purposes without the prior written consent of such other Party. </p>
        @php $subCounter = 6; @endphp
        
        @foreach($diffArticle7 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">7.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 10: Article 8 --}}
    <div id="page10">
        <br>
        <h2 class="text-center"> ARTICLE 8<br>EMPLOYMENT RELATIONS </h2>
        @php $subCounter = 1; @endphp
        
        @foreach($diffArticle8 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">8.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 11: Article 9 --}}
    <div id="page11">
        <br>
        <h2 class="text-center"> ARTICLE 9<br>EXCLUSIVITY </h2>
        <p class="numbered-paragraph"> 9.1. The AUF shall not enter into a separate MOA with any foreign educational institution on any of the academic programs covered by this MOA during its existence, and within two (2) years from its termination. </p>
        <p class="numbered-paragraph"> 9.2. The {{$document->proposalForm->institution_name_acronym}} shall not likewise enter into a separate MOA with any other educational institution in the Philippines on any of the academic programs covered by this MOA during its existence, and within two (2) years from its termination. </p>
        @php $subCounter = 3; @endphp
        
        @foreach($diffArticle9 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">9.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 12: Article 10 --}}
    <div id="page12">
        <br>
        <h2 class="text-center"> ARTICLE 10<br>MATERIAL ADVERSE CHANGE CLAUSE </h2>
        <p class="numbered-paragraph"> 10.1. Any change in the circumstances of any of the Parties that would adversely affect its ability to perform any of its obligations specified in this MOA, or render any of its warranties ineffectual, shall be communicated to the other Party within five (5) days from such change of its circumstances. </p>
        <p class="numbered-paragraph"> 10.2. The Party concerned shall immediately address such change in its circumstance. Nonetheless, in case the same cannot be remedied, the other Party has the option to terminate this MOA upon giving Notice to the other Party the circumstances of which have materially changed. </p>
        @php $subCounter = 3; @endphp
        
        @foreach($diffArticle10 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">10.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 13: Article 11 --}}
    <div id="page13">
        <br>
        <h2 class="text-center"> ARTICLE 11<br>CONFIDENTIALITY </h2>
        <p class="numbered-paragraph">11.1. Except as required by the regulatory authorities or by the courts of each of the Parties, or upon written consent by any of the Parties, any confidential or proprietary information in relation to, or arising out of, this MOA shall not be shared to any third parties;</p>
        <p class="numbered-paragraph">11.2. The confidential nature of said information is not diminished by the fact that it was already submitted to the regulatory authorities.</p>
        @php $subCounter = 3; @endphp
        
        @foreach($diffArticle11 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">11.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 14: Article 12 --}}
    <div id="page14">
        <br>
        <h2 class="text-center"> ARTICLE 12<br>COMPLIANCE WITH LAW </h2>
        <p class="numbered-paragraph">12.1. The Parties shall comply with all applicable laws, rules and regulations that are in effect at the time of the effectivity of this Agreement. These shall include, but not limited to, those relating to employment, practice of profession, repatriation of income, quality standards. Any subsequent amendments to these laws, rules, and regulations are deemed incorporated into this Agreement.</p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle12 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">12.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 15: Article 13 --}}
    <div id="page15">
        <br>
        <h2 class="text-center"> ARTICLE 13<br>NON-ASSIGNMENT OF RIGHTS </h2>
        <p class="numbered-paragraph">13.1. No Party may assign this Agreement or any rights or obligations under this Agreement to any person or entity without the prior written consent of the other Party. Any assignment in violation of this provision shall be null and void.</p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle13 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">13.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 16: Article 14 --}}
    <div id="page16">
        <br>
        <h2 class="text-center"> ARTICLE 14<br>SEVERABILITY </h2>
        <p class="numbered-paragraph">14.1. The provisions of this Agreement are severable, and if any provision of this Agreement is found to be invalid, void or unenforceable, the remaining provisions will remain in full force and effect.</p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle14 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">14.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 17: Article 15 --}}
    <div id="page17">
        <br>
        <h2 class="text-center">ARTICLE 15<br>EFFECTIVITY</h2>
        <p class="numbered-paragraph">
            15.1. This Agreement shall take effect on the date of signing by the Parties of this document and shall
            thereafter be in full force and effect for a period of {{$memorandum->validity_period}},
            unless earlier terminated before the lapse of the {{$memorandum->validity_period}}, with the
            consent of all parties provided a thirty (30) day notice in writing by the initiating party shall have
            been fully served to the other parties. The Agreement shall be deemed automatically renewed unless terminated
            by either party in writing at least six (6) months prior to the intended date of termination.
        </p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle15 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">15.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 18: Article 16 --}}
    <div id="page18">
        <br>
        <h2 class="text-center">ARTICLE 16<br>AMENDMENTS</h2>
        <p class="numbered-paragraph">
            16.1. Any amendments to this MOA may be proposed by any of the Parties, and shall be effective upon approval by the President or Head of the Institution of both Parties, unless a specific date of effectivity is provided by the Parties.
        </p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle16 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">16.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 19: Article 17 --}}
    <div id="page19">
        <br>
        <h2 class="text-center">ARTICLE 17<br>GOVERNING LAW</h2>
        <p class="numbered-paragraph">
            17.1. This MOA shall be governed by the laws of the Republic of the Philippines. Any violation or dispute that may arise from this Agreement shall be brought before the proper court in the Philippines, subject to the Dispute Resolution under clause 18. The Parties agree that the foregoing governing law, jurisdiction and forum selection have been concluded as a result of arms-length negotiations and are not overly onerous or burdensome to either Party.
        </p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle17 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">17.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 20: Article 18 --}}
    <div id="page20">
        <br>
        <h2 class="text-center">ARTICLE 18<br>DISPUTE RESOLUTION</h2>
        <p class="numbered-paragraph">
            18.1. Parties shall make every effort to resolve amicably and by mutual consultation any and all disputes or differences arising between the parties in connection with the implementation of the Agreement. Should such dispute not be resolved amicably, it shall be submitted to arbitration in the Philippines, with the Philippines as the seat of arbitration according to the provision of R.A. 876, otherwise known as the “Arbitration Law” and R.A. 9285, otherwise known as “Alternative Dispute Resolution Act of 2004.” Provided, however, that by mutual agreement, the parties may agree in writing to resort to other alternative modes of dispute resolution.
        </p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle18 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">18.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 21: Article 19 --}}
    <div id="page21">
    <br>
    <h2 class="text-center">ARTICLE 19<br>VENUE OF ACTION</h2>
    <p class="numbered-paragraph">
        19.1. In cases of disputes when both mediation and arbitration fail, the parties submit to the exclusive jurisdiction of the proper courts of Angeles City, Philippines.
    </p>
    @php $subCounter = 2; @endphp
        
        @foreach($diffArticle19 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">19.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 22: Article 20 --}}
    <div id="page22">
        <br>
        <h2 class="text-center">ARTICLE 20<br>NOTICES</h2>
        <p class="numbered-paragraph">
            20.1. All notices required or permitted under this Agreement must be in writing and delivered by mail (postage prepaid) or by hand delivery to the address of the party receiving the notice listed below.
        </p>
        <p class="numbered-paragraph">
            20.2. Notice may also be delivered by facsimile sent to the facsimile number of the receiving party listed below, provided that the original notice is promptly sent to the recipient by mail (postage prepaid) or by hand delivery. Notices sent by email are ineffective.
        </p>
        <p class="numbered-paragraph">
            20.3. Notices shall only be effective when received by the recipient during its regular business hours.
        </p>
        @php $subCounter = 4; @endphp
        
        @foreach($diffArticle20 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">20.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
        @include('components.memorandum._article20_contacts', ['link' => $document])
    </div>

    {{-- Page 23: Article 21 --}}
    <div id="page23">
        <br>
        <h2 class="text-center">ARTICLE 21<br>SUBSEQUENT AGREEMENTS</h2>
        <p class="numbered-paragraph">
            21.1. The Parties shall provide further details to this Agreement in subsequent written agreements and exchanges of notes to be executed by duly authorized representatives of the Parties.
        </p>
        @php $subCounter = 2; @endphp
        
        @foreach($diffArticle21 as $clause)
            <p class="numbered-paragraph">
                <span class="clause-number">21.{{ $subCounter }}</span> 
    
                @if($clause['status'] === 'removed')
                    <span class="removed">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'added')
                    <span class="added">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @elseif($clause['status'] === 'changed')
                    <span class="removed">{{ is_array($clause['removed']) ? implode(', ', $clause['removed']) : $clause['removed'] }}</span>
                    <span class="added">{{ is_array($clause['added']) ? implode(', ', $clause['added']) : $clause['added'] }}</span>
                @elseif($clause['status'] === 'unchanged')
                    <span class="unchanged">{{ is_array($clause['content']) ? implode(', ', $clause['content']) : $clause['content'] }}</span>
                @endif
            </p>
            
            @php $subCounter++; @endphp
        @endforeach
    </div>

    {{-- Page 24: Last Page --}}
    <div id="page24">
        <div style="page-break-after: always;"></div>
        @include('components.memorandum._lastPage',['link' => $document])
    </div>


</body>
</html>
