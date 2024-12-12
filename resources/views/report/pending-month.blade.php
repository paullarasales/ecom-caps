<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Appointments Report - {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
            font-size: 12px;
            text-transform: capitalize;
        }
        th {
            background-color: #dde38c;
        }
        tbody tr:nth-child(odd) {
        background-color: #f9f9f9; /* Light gray for odd rows */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* White for even rows */
        }
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: right;
        }
        .footer {
            font-style: italic
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>The Siblings Catering Services</h2>
        <h3>Pending Appointments Report</h3>
        <p>Month: {{ $month }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->user->firstname }} {{ $appointment->user->lastname }}</td>
                    <td>{{ $appointment->appointment_datetime ? \Carbon\Carbon::parse($appointment->appointment_datetime)->format('h: i A') : 'No Appointment Time Assigned' }}</td>
                    <td>{{ $appointment->appointment_datetime ? \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y') : 'No Appointment Date Assigned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p class="foot">Date printed: {{ \Carbon\Carbon::now()->format('F j, Y') }} | Page: </p>
    </div>
</body>
</html>
