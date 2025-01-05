<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .main {
            margin: 0 50px;
        }
        .header {
            text-align: center;
        }
        .head {
            font-size: 24px;
            margin: 0 0 4px 0;
        }
        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            text-transform: capitalize;
            table-layout: fixed;
        }
        .appointment-table td {
            padding: 2px;
            text-align: left;
            font-size: 12px;
            word-wrap: break-word; /* Ensures content wraps within cells */
        }
        .appointment-table td:first-child {
            font-weight: normal;
        }
        .title {
            font-size: 18px;
            margin: 10px 0;
        }
        .break {
            border: 1px dashed #000;
            margin: 10px 0;
        }
        .pay {
            font-size: 12px;
            text-align: justify;
        }
        .minimum {
            text-decoration: underline;
        }
        .name {
            margin: 0 0 0 40px;
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
        .con {
            border: 3px solid #b7982f;
            font-size: 20px;
            margin: 15px 170px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="head"><strong>The Siblings Catering Services</strong></p>
        <p class="con">Contract / Booking Agreement</p>
    </div>

    <div class="main">
        <p class="title"><strong>Client Information</strong></p>
        <table class="appointment-table">
            <tr>
                <td>Name :</td>
                <td>{{ $appointment->user->firstname }} {{ $appointment->user->lastname }}</td>
            </tr>
            <tr>
                <td>Phone :</td>
                <td>{{$appointment->user->phone}}</td>
            </tr>
            <tr>
                <td>Address :</td>
                <td>{{$appointment->user->address}}, {{$appointment->user->city}}</td>
            </tr>
        </table>

        <p class="title"><strong>Event Information</strong></p>
        <table class="appointment-table">
            <tr>
                <td>Location/Venue :</td>
                <td>{{ ucfirst($appointment->location) }}</td>
            </tr>
            <tr>
                <td>Date :</td>
                <td>{{ \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td>Time :</td>
                <td>{{ $appointment->etime }}</td>
            </tr>
            <tr>
                <td>Type :</td>
                <td>{{ $appointment->type }}</td>
            </tr>
            <tr>
                <td>Theme :</td>
                <td>{{ $appointment->theme }}</td>
            </tr>
            <tr>
                <td>Package :</td>
                <td>
                    @if($appointment->package && $appointment->package->packagetype == 'Custom')
                        {{ $package->customPackage->target }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Total Amount :</td>
                <td>Php {{ number_format($package->discountedprice, 2) }}</td>
            </tr>
            <tr>
                <td>Balance :</td>
                <td>Php {{ number_format($appointment->balance, 2) }}</td>
            </tr>
            <tr>
                <td>Deposit :</td>
                <td>Php {{ number_format($appointment->deposit, 2) }}</td>
            </tr>
        </table>

        <hr class="break">
        <div class="pay">
            <p>Payment Terms</p>
            <ul>
                <li>A non-refundable, non-transferable deposit minimum of (20%) <span class="minimum">Php {{ number_format($package->discountedprice * 0.20, 2) }}</span> is required to book your event for an available date.</li>
                <li>Full Payment must be completed on the day of event.</li>
            </ul>
            <p>NOTE: CANCELLATION IS STRICTLY PROHIBITED, However, in Terms of Uncertain Circumstances: We allow rescheduling of the event</p>
            <p>Therefore, the minimum deposit will not be subjected to reimbursement.</p>
        </div>
        <hr class="break">
        <div class="pay">
            <p>The following person is responsible for all debts and full payment of this event.</p>
            <p>Name: __________________________</p>
            <p>Signature: __________________________</p>
            <p>Date: __________________________</p>
            <br>
            <p>Accepted by:</p>
            <p>Name: __________________________</p>
            <p>Signature: __________________________</p>
            <p>Date: __________________________</p>
        </div>
        <hr class="break">
        <div class="pay">
            <table class="appointment-table">
                {{-- <p>For more information, please contact us at:</p> --}}
                <tr>
                    <td>Phone :</td>
                    <td>09052336855 / 09395728979</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        Ms. Cheska Mae Rosario / Mr. Mark Christian Rosario
                    </td>
                </tr>
                <tr>
                    <td>Facebook :</td>
                    <td>The Siblings Catering Services</td>
                </tr>
                <tr>
                    <td>Instagram :</td>
                    <td>thesiblingscateringservices</td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td>thesiblingscateringservices@gmail.com</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p class="foot">Date printed: {{ \Carbon\Carbon::now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
