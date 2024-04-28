<!DOCTYPE html>
<html>
<head>
    <title>List of New Employees</title>
</head>
<body>
    @if ($employees->isNotEmpty())
        <h1>List of New Employees</h1>
        <ul>
            @foreach ($employees as $employee)
                <li>{{ $employee['full_name'] }} - {{ $employee['email'] }}</li>
            @endforeach
        </ul>
    @else
        <h1>No new employees</h1>
        <p>No new employees have been added in the last twenty-four hours</p>
    @endif
</body>
</html>





