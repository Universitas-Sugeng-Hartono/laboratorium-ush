<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label QR Code Inventaris Alat - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <style>
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .no-print-bar {
            max-width: 900px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        .btn-print {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .labels-grid {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .label-card {
            background: white;
            border: 2px solid #222;
            border-radius: 6px;
            padding: 10px;
            display: flex;
            gap: 12px;
            align-items: center;
            page-break-inside: avoid;
        }

        .label-qr {
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .label-qr svg {
            width: 100%;
            height: 100%;
        }

        .label-details {
            flex-grow: 1;
            overflow: hidden;
        }

        .label-institution {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1a365d;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-bottom: 4px;
        }

        .label-code {
            font-size: 13px;
            font-weight: 800;
            color: #d90429;
            margin-bottom: 2px;
            font-family: monospace;
        }

        .label-name {
            font-size: 12px;
            font-weight: 700;
            color: #111;
            line-height: 1.25;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .label-lab {
            font-size: 10px;
            color: #4a5568;
            margin-bottom: 2px;
        }

        .label-meta {
            font-size: 9px;
            color: #718096;
            display: flex;
            justify-content: space-between;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .no-print-bar {
                display: none;
            }

            .labels-grid {
                max-width: 100%;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .label-card {
                border: 1.5px solid #000;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <strong>Label Stiker Inventaris Laboratorium</strong>
            <span style="color: #666; font-size: 13px; margin-left: 8px;">(Total: {{ $alats->count() }} label siap cetak)</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('alat.index') }}" class="btn-back">Kembali</a>
            <button onclick="window.print()" class="btn-print">
                 Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <div class="labels-grid">
        @foreach($alats as $item)
        <div class="label-card">
            <div class="label-qr">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($item->qr_code_payload) !!}
            </div>
            <div class="label-details">
                <div class="label-institution">UNIVERSITAS SUGENG HARTONO - FTHB</div>
                <div class="label-code">{{ $item->kode ?? '-' }}</div>
                <div class="label-name">{{ $item->alat }}</div>
                <div class="label-lab">
                    📍 {{ $item->labId->laboratorium ?? 'Laboratorium Umum' }}
                    @if($item->lokasi_penyimpanan)
                        ({{ $item->lokasi_penyimpanan }})
                    @endif
                </div>
                <div class="label-meta">
                    <span>Kondisi: <strong>{{ ucfirst(str_replace('_', ' ', $item->kondisi ?? 'baik')) }}</strong></span>
                    <span>Tgl: {{ date('m/Y') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</body>
</html>
