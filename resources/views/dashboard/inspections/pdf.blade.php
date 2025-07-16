<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inspection Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8pt;
            margin: 10px;
        }

        h1 {
            font-size: 11pt;
            margin: 0 0 4px;
        }

        h2,
        h3,
        h4 {
            font-size: 8pt;
            margin: 5px 0 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px;
            font-size: 8pt;
        }

        .section {
            margin-top: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 70px;
        }

        .logo-left {
            float: left;
        }

        .logo-right {
            float: right;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        hr {
            border: 1px solid #000;
            margin-top: 4px;
            margin-bottom: 4px;
        }

        img.photo {
            width: 200px;
            height: 100px;
            object-fit: cover;
            margin: 0;
            padding: 0;
            border: 1px solid #000;
        }

        td.photo-cell {
            max-width: 100%;
            overflow: hidden;
            padding: 3px;
        }

        p {
            margin: 4px 0;
        }

        .signature {
            position: fixed;
            bottom: 20px;
            right: 40px;
            text-align: right;
            font-size: 8pt;
        }
    </style>
</head>

<body>
    {{-- Letterhead --}}
    <div class="header clearfix">
        <img src="{{ public_path('img/application-logo.webp') }}" class="logo-left">
        <img src="{{ public_path('img/pemprov-sulut.svg') }}" class="logo-right">
        <h1>PT. INSPEKSI ALAT BERAT</h1>
        <p>Jl. 17 Agustus No.69, Manado, North Sulawesi</p>
        <p>Tel: (0431) 123456 - Email: dinasindag@sulutprov.go.id</p>
    </div>
    <hr>

    <h1 style="text-align: center; margin-top: 6px;">INSPECTION REPORT</h1>

    {{-- Inspection Items --}}
    <div class="section">
        <h4>Inspection Details</h4>
        <table style="border: none; padding: 0; margin: 0;">
            <tr>
                <td style="vertical-align: top; width: 50%; border: none; padding: 0; padding-right: 10px;">
                    <table>
                        <tr>
                            <td style="width: 100px;"><strong>Equipment Type</strong></td>
                            <td style="word-wrap: break-word;">{{ $inspection->equipmentType->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Inspector</strong></td>
                            <td style="word-wrap: break-word;">{{ $inspection->inspector->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Serial Number</strong></td>
                            <td>{{ $inspection->equipment->serial_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>Machine Type</strong></td>
                            <td>{{ $inspection->equipment->machine_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Make</strong></td>
                            <td>{{ $inspection->equipment->make }}</td>
                        </tr>
                        <tr>
                            <td><strong>Model</strong></td>
                            <td>{{ $inspection->equipment->model }}</td>
                        </tr>
                        <tr>
                            <td><strong>Year</strong></td>
                            <td>{{ $inspection->equipment->year }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top; width: 50%; border: none; padding: 0;">
                    <table>
                        @if ($inspection->equipmentType->name === 'Elevator')
                            <tr>
                                <td style="width: 100px;"><strong>State ID</strong></td>
                                <td>{{ $inspection->info->state_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Capacity</strong></td>
                                <td>{{ $inspection->info->capacity ?? '-' }}</td>
                            </tr>
                        @else
                            <tr>
                                <td style="width: 100px;"><strong>Report No</strong></td>
                                <td>{{ $inspection->info->report_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Hour Reading</strong></td>
                                <td>{{ $inspection->info->hour_reading ?? '-' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Date</strong></td>
                            <td>{{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Location</strong></td>
                            <td style="word-wrap: break-word;">{{ $inspection->location }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Inspection Items</h4>
        <table style="inspection-items table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 20%;">Category</th>
                    <th style="width: 10%;">Score</th>
                    <th style="width: 70%;">Description</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalScore = 0;
                    $count = count($inspection->items);
                @endphp
                @foreach ($inspection->items as $item)
                    @php $totalScore += $item->score; @endphp
                    <tr>
                        <td style="word-wrap: break-word;">{{ $item->equipmentTypeItem->category ?? '-' }}</td>
                        <td style="text-align: center;">{{ $item->score }}</td>
                        <td style="word-wrap: break-word;">{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Average Score:</strong> {{ $count > 0 ? number_format($totalScore / $count, 2) : '-' }}</p>
        <p><strong>Status:</strong>
            {{ $count > 0 && $totalScore / $count >= 90 ? 'Operationally Feasible' : 'Not Operationally Feasible' }}
        </p>
    </div>

    {{-- Problems / Repairs --}}
    @if ($inspection->problems->count())
        <div class="section">
            <h4 style="color: red">Problems / Repairs</h4>
            @foreach ($inspection->problems as $problem)
                <p>{{ $problem->notes }}</p>
                @if ($problem->photos->count())
                    <table style="table-layout: fixed; width: 100%;">
                        @php $photos = $problem->photos; @endphp
                        @foreach ($photos->chunk(3) as $chunk)
                            <tr>
                                @foreach ($chunk as $photo)
                                    <td class="photo-cell" style="text-align: center;">
                                        <img src="{{ public_path('storage/' . $photo->photo_url) }}"
                                            alt="Problem photo" class="photo">
                                    </td>
                                @endforeach

                                {{-- Jika kurang dari 3 kolom, tambahkan sel kosong untuk jaga layout --}}
                                @for ($i = $chunk->count(); $i < 3; $i++)
                                    <td class="photo-cell"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endforeach
        </div>
    @endif

    <div class="signature">
        <p>Manado, {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d F Y') }}</p>
        <p><strong>Inspector</strong></p>
        <br><br><br>
        <p><strong>{{ $inspection->inspector->name }}</strong></p>
    </div>
</body>

</html>
