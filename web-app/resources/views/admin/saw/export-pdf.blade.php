<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Ranking Kafe Terbaik</title>

    <style>
        @page{
            margin: 28px 40px;
        }

        body{
            font-family: "Times New Roman", Times, serif;
            color: #222;
            margin: 0;
            font-size: 14px;
        }

        .page{
            width: 100%;
        }

        .page + .page{
            page-break-before: always;
        }

        .header{
            text-align: center;
            margin-bottom: 12px;
            line-height: 1.1;
        }

        .header h1{
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header p{
            margin: 3px 0 0 0;
            font-size: 14px;
        }

        .tanggal{
            text-align: right;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .table-wrapper{
            width: 86%;
            margin: 0 auto;
        }

        .table-wrapper.next-page{
            margin-top: 40px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td{
            border: 1px solid #bfbfbf;
            padding: 8px 12px;
        }

        table th{
            text-align: center;
            font-weight: bold;
            background: #fff;
        }

        table td:nth-child(1),
        table td:nth-child(3){
            text-align: center;
        }

        table td:nth-child(2){
            text-align: left;
        }

        .footer{
            position: fixed;
            bottom: 8px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>

@php

    $page1 = $hasilRanked->slice(0, 26);

    $page2 = $hasilRanked->slice(26, 28);

    $page3 = $hasilRanked->slice(54, 28);

    $page4 = $hasilRanked->slice(82, 28);

    $pages = [
        $page1,
        $page2,
        $page3,
        $page4
    ];

@endphp

@foreach($pages as $index => $page)

    @if($page->count() > 0)

    <div class="page">

        @if($index == 0)

            <div class="header">
                <h1>Laporan Ranking Kafe Terbaik</h1>

                <p>
                    Metode Simple Additive Weighting (SAW) —
                    Sistem Ngafein Malang
                </p>
            </div>

            <div class="tanggal">
                Dicetak pada : {{ $tanggal }}
            </div>

        @endif

        <div class="table-wrapper {{ $index > 0 ? 'next-page' : '' }}">

            <table>
                <thead>
                    <tr>
                        <th width="20%">Ranking</th>
                        <th width="60%">Nama Kafe</th>
                        <th width="20%">Skor</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($page as $item)

                        <tr>
                            <td>
                                {{ $item['ranking'] }}
                            </td>

                            <td>
                                {{ $item['nama_kafe'] }}
                            </td>

                            <td>
                                {{ number_format($item['skor'], 4) }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>

    </div>

    @endif

@endforeach

<div class="footer">
    Sistem Pendukung Keputusan Pemilihan Kafe — Ngafein Malang
</div>

</body>
</html>