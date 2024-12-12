<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelle Events Report - {{ $month }}</title>
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
        <h3>Cancelled Events Report</h3>
        <p>Month: {{ $month }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Package</th>
                <th>Reason</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->user->firstname }} {{ $appointment->user->lastname }}</td>
                    <td>{{ $appointment->package->custompackage->target ?? 'N/A' }} (Php {{ number_format($appointment->package->packagedesc, 2) }})</td>
                    <td>{{ $appointment->reason}}</td>
                    <td>{{ $appointment->edate ? \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') : 'No Event Date Assigned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p class="foot">Date printed: {{ \Carbon\Carbon::now()->format('F j, Y') }} | Page: </p>
    </div>
</body>
</html>
