<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Events Report - {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .head {
            font-size: 20px;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 1px;
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
            font-style: italic;
            font-size: 12px;
        }
        .totals {
            margin-top: 15px;
            text-align: right;
            font-size: 12px;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="head">The Siblings Catering Services</p>
        <p class="head">Completed Events Report</p>
        <p>Month: {{ $month }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Package</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->user->firstname }} {{ $appointment->user->lastname }}</td>
                    <td>{{ $appointment->package->custompackage->target ?? 'N/A' }} (Php {{ number_format($appointment->package->packagedesc, 2) }})</td>
                    <td>{{ $appointment->edate ? \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') : 'No Event Date Assigned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        @php
            $totalDeposit = $appointments->sum('deposit');
            $totalBalance = $appointments->sum('balance');
            $totalPackagePrice = $appointments->sum(function ($appointment) {
                return $appointment->package->packagedesc ?? 0;
            });
        @endphp
        {{-- <span>Total Deposit: Php {{ number_format($totalDeposit, 2) }}</span>
        <br>
        <span>Total Balance: Php {{ number_format($totalBalance, 2) }}</span>
        <br> --}}
        <span>Total Package Price: Php {{ number_format($totalPackagePrice, 2) }}</span>
    </div>
    
    <div class="footer">
        <p class="foot">{{ \Carbon\Carbon::now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
