<!DOCTYPE html>
<html>
<head>
    <title>List of Employees</title>
</head>
<body>
    <h1>List of Employees</h1>
    <ul>
        @foreach ($employees as $employee)
            <li>{{ $employee['full_name'] }} - {{ $employee['email'] }}</li>
        @endforeach
    </ul>
</body>
</html>





