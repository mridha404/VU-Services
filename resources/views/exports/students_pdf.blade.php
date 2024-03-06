<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Report</title>
    <style>
        /* Define your PDF styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .highlight {
            background-color: #ffc107;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Students Report</h1>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Roll Number</th>
                    <th>Department</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->rollnumber }}</td>
                        <td>{{ $student->department->department_name }}</td>
                        <td class="{{ $student->balance < 0 ? 'highlight' : '' }}">{{ $student->balance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total Students: {{ $students->count() }}</p>
    </div>
</body>

</html>
