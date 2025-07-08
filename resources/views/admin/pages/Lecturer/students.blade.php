<table class="table">
    <thead>
        <tr>
            <th>Index No.</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Course ID</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->index_number }}</td>
                <td>{{ $student->surname }} {{ $student->first_name }} {{ $student->other_names }}</td>
                <td>{{ $student->contact }}</td>
                <td>{{ $student->course_id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
