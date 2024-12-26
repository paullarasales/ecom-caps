<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Appointments Reports</title>
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
            font-size: 20px;
            margin: 0;
        }
        
        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            text-transform: capitalize;
        }

        .appointment-table td {
            padding: 2px;
            text-align: left;
            font-size: 13px
        }

        .appointment-table td:first-child {
            font-weight: bold;
        }

        ul {
            list-style-type: disc;
            padding-left: 50px;
            font-size: 14px;
        }
        li {
            margin: 5px 0;
            text-transform: capitalize;
        }
        .title {
            font-size: 18px;
            margin: 20px 0;
        }
        .title .tent {
            font-style: italic;
        }
        .pack {
            margin: 0 40px;
        }
        .package {
            font-size: 13px;
        }
        .pack p {
            text-transform: capitalize;
            font-size: 13px;
            margin: 8px 0;;
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
    </style>
</head>
<body>
    <div class="header">
        <p class="head"><strong>The Siblings Catering Services</strong></p>
        <p class="head">Pending</p>
    </div>

    <div class="main">
        <p class="title"><strong>User Information</strong></p>
        <table class="appointment-table">
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $appointment->user->firstname }} {{ $appointment->user->lastname }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{$appointment->user->phone}}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{$appointment->user->address}}, {{$appointment->user->city}}</td>
            </tr>
        </table>
        

        <p class="title"><strong>Event Information</strong></p>
        <table class="appointment-table">
            <tr>
                <td><strong>Location:</strong></td>
                <td>{{ ucfirst($appointment->location) }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Time:</strong></td>
                <td>{{ $appointment->etime }}</td>
            </tr>
            <tr>
                <td><strong>Type:</strong></td>
                <td>{{ $appointment->type }}</td>
            </tr>
            <tr>
                <td><strong>Theme:</strong></td>
                <td>{{ $appointment->theme }}</td>
            </tr>
        </table>

        <p class="title"><strong>Package :</strong> @if($appointment->package && $appointment->package->packagetype == 'Custom')
            {{ $package->customPackage->target }} 
            (Php {{ number_format($package->packagedesc, 2) }})
            @elseif($package && $package->packagetype == 'Normal')
            {{ $package->packagename }} 
            (Php {{ number_format($package->packagedesc, 2) }})
            <span class="tent">Tentative</span>
            @endif
        </p>
        <div class="pack">
            @if($package)
                {{-- <p class="package"><strong>Package Type:</strong> {{ $package->customPackage->target }}</p>
                <p class="package"><strong>Price :</strong> Php {{ number_format($package->packagedesc, 2) }}</p> --}}
            @if($package && $package->packagetype == 'Normal')
                <!-- Normal Package Inclusions -->
                @if (isset($package->packageinclusion))
                    @foreach (json_decode($package->packageinclusion) as $inclusion)
                        <li>{{ $inclusion }}</li>
                    @endforeach
                @else
                    <li>No inclusions available</li>
                @endif
                <br>
                <hr>
                <p class="text-center">This is just preferred package type</p>
            @elseif($package && $package->packagetype == 'Custom')
            <p>
                <strong>Pax:</strong> 
                {{ $customPackage->person ?? 'Not specified' }}
            </p>
                @if (isset($package->customPackage->items) && count($package->customPackage->items) > 0)
                    @php
                        $groupedItems = collect($package->customPackage->items)->groupBy(function ($item) {
                            $itemType = $item->item_type;
                            if ($itemType === 'clown') {
                                                            $itemType = 'Clown/Emcee';  // Replace here
                                                        }
                            return in_array($itemType, ['beef', 'pork', 'chicken', 'veggie', 'others']) ? 'Dishes' : $itemType;
                        });
                    @endphp

                    @foreach ($groupedItems as $itemType => $items)
                        @if (in_array($itemType, ['Dishes', 'food_pack', 'food_cart']))
                            <!-- For Dishes, food_pack, and food_cart, display as list -->
                            <p>
                                <strong>
                                {{ str_replace('_', ' ', $itemType) }}
                                </strong>
                            </p>
                            <ul>
                                @foreach ($items as $item)
                                    <li>
                                        {{ $item->item_name }}
                                        @if ($item->item_type === 'food_pack')
                                            ({{ $item->quantity ?? 'N/A' }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <!-- For other item types, display as paragraph -->
                            <p>
                                <strong>{{ str_replace('_', ' ', $itemType) }}:</strong> 
                                @foreach ($items as $item)
                                    {{ $item->item_name }}
                                @endforeach
                            </p>
                        @endif
                    @endforeach
                @else
                    <p>No custom items available</p>
                @endif
            @else
                <p class="text-gray-700">No custom items available</p>
            @endif
            @else
                <p>No package details available.</p>
            @endif
        </div>
    </div>



    <div class="footer">
        <p class="foot">{{ \Carbon\Carbon::now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
