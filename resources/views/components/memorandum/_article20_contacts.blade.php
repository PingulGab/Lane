<h2 class="indented-paragraph"> ANGELES UNIVERSITY FOUNDATION </h2>
<p class="indented-paragraph-list">i. Address: President’s Office, AUF Main Campus, McArthur Highway, Angeles City, Pampanga</p>
<p class="indented-paragraph-list">ii. Phone/Fax: 045 625 2888</p>
<p class="indented-paragraph-list">iii. Email: president@auf.edu.ph</p>
<br>
<h2 class="indented-paragraph"> {{$link->proposalForm->institution_name}} </h2>
<p class="indented-paragraph-list">i. Address: {{$link->proposalForm->address}}</p>
@if($link->proposalForm->mobile_number && $link->proposalForm->telephone_number)
    <p class="indented-paragraph-list">ii. Phone/Fax: {{$link->proposalForm->mobile_number}} / {{$link->proposalForm->telephone_number}}</p>
@elseif($link->proposalForm->telephone_number)
    <p class="indented-paragraph-list">ii. Phone/Fax: {{$link->proposalForm->telephone_number}}</p>
@else
    <p class="indented-paragraph-list">ii. Phone/Fax: {{$link->proposalForm->mobile_number}}</p>
@endif
<p class="indented-paragraph-list">iii. Email: {{$link->proposalForm->email}} </p>