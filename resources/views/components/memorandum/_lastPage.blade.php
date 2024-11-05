<style>
    table {
        width: 90%; /* Set the width of the table */
        margin: 0 auto; /* Center the table */
        border-collapse: collapse; /* Optional: for better table styling */
        table-layout: fixed; /* Set fixed layout */
        font-size: 14px;
    }
    th, td {
        border: 1px solid #000; /* Add borders to table cells */
        padding: 8px; /* Add some padding */
        text-align: left; /* Align text to the left */
    }
    th {
        text-align: center; /* Center align the header text */
    }
    th:first-child, td:first-child {
        width: 50%; /* Set the first column to 50% */
    }
    th:last-child, td:last-child {
        width: 50%; /* Set the second column to 50% */
    }
</style>

<p class="indented-paragraph"> <span class="bold">IN WITNESS WHEREOF</span>, the parties hereto have set their hands on the date and place stated above.</p>

<table>
    <thead>
        <tr>
            <th>PHILIPPINES <br> ANGELES UNIVERSITY FOUNDATION</th>
            <th>{{$link->proposalForm->country}}<br>{{$link->proposalForm->institution_name}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>By:
                <br><br><br>
                <p class="text-center" style="margin: 0"><span class="bold">DR. JOSEPH E. L. ANGELES</span></p>
                <p class="text-center italic" style="margin:0">University President</p>
            </td>
            <td>By:
                <br><br><br>
                <p class="text-center" style="margin: 0"><span class="bold">{{$link->proposalForm->institution_head}}</span></p>
                <p class="text-center italic" style="margin:0">{{$link->proposalForm->institution_head_title}}</p>
            </td>
        </tr>
        <tr>
            <td>
                Date:
            </td>
            <td>
                Date:
            </td>
        </tr>
    </tbody>
</table>