<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letter->subject }}</title>
    <style>
        @page {
            margin: 2.5cm 3cm 2.5cm 2.5cm;
        }
        body {
            font-family: 'Times-Roman', 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 4px 0 0 0;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 9.5pt;
            font-style: italic;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11pt;
        }
        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .recipient {
            margin-top: 15px;
            margin-bottom: 25px;
            font-size: 11pt;
            line-height: 1.5;
        }
        .body-text {
            font-size: 11pt;
            text-align: justify;
        }
        .body-text p {
            margin-bottom: 12px;
            text-indent: 1cm;
            text-align: justify;
            line-height: 1.6;
        }
        /* Elegant callout style for response or key details */
        .body-text div, .body-text blockquote {
            background-color: #f8fafc;
            border-left: 4px solid #1e3a8a;
            padding: 12px 15px;
            margin: 15px 0;
            font-size: 10.5pt;
            border-radius: 4px;
            color: #1e293b;
            text-indent: 0;
            text-align: justify;
        }
        .signature-section {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
        }
        .tte-box {
            margin: 8px 0;
            width: 240px;
            border: 2px dashed #008000;
            padding: 8px 10px;
            background-color: #f6fff6;
            border-radius: 6px;
            text-align: left;
        }
        .tte-title {
            color: #008000;
            font-weight: bold;
            font-family: monospace;
            font-size: 8.5pt;
            display: block;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .tte-body {
            color: #333;
            font-size: 7.5pt;
            display: block;
            font-family: sans-serif;
            line-height: 1.3;
        }
        {!! $css ?? '' !!}
    </style>
</head>
<body>
    @if(!empty($header))
        <div class="header">
            {!! $header !!}
        </div>
    @else
        <div class="header">
            <h2 style="font-size: 11pt; font-weight: normal; margin-bottom: 2px; letter-spacing: 0.5px;">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h2>
            <h2 style="font-size: 12pt; font-weight: bold; margin-bottom: 2px; letter-spacing: 0.5px;">DINAS PENDIDIKAN</h2>
            <h1 style="font-size: 14pt; font-weight: bold; margin-bottom: 5px; color: #1e3a8a;">SMK NEGERI 2 SUMEDANG</h1>
            <p style="font-size: 9pt; margin-bottom: 2px;">{{ settings('contact_address', 'Jl. Arief Rakhman Hakim No. 59, Situ, Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45323') }}</p>
            <p style="font-style: normal; font-size: 9pt; margin-top: 2px;">Email: {{ settings('contact_email', 'smkn2sumedang@yahoo.com') }} | Telp: {{ settings('contact_phone', '(0261) 201531') }}</p>
        </div>
    @endif

    <div class="content">
        <table class="meta-table">
            <tr>
                <td style="width: 12%;">Nomor</td>
                <td style="width: 2%;">:</td>
                <td style="width: 48%;">{{ $letter->letter_number }}</td>
                <td style="width: 38%; text-align: right; font-style: normal;">{{ settings('site_location', 'Kota') }}, {{ $letter->created_at->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Biasa</td>
                <td></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td><strong>Tanggapan Permohonan Informasi Publik</strong></td>
                <td></td>
            </tr>
        </table>

        <div class="recipient">
            Yth. Bapak/Ibu <strong>{{ $letter->complaint->complainant_name }}</strong><br>
            di -<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
        </div>

        <div class="body-text">
            {!! $letter->body !!}
        </div>
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 45%;"></td>
                <td style="width: 55%; text-align: left;">
                    <p style="margin: 0 0 5px 0; line-height: 1.4;">
                        Pejabat Pengelola Informasi dan Dokumentasi<br>
                        <strong>{{ settings('site_name', 'PPID Instansi') }}</strong>
                    </p>
                    
                    @if($letter->signed_at)
                        <div class="tte-box">
                            <span class="tte-title">TANDA TANGAN ELEKTRONIK</span>
                            <span class="tte-body">
                                Ditandatangani oleh:<br>
                                <strong>{{ $letter->signer?->name ?? 'Pejabat PPID' }}</strong><br>
                                Pada: {{ $letter->signed_at->format('d-m-Y H:i') }} WIB
                            </span>
                        </div>
                        @if($letter->signer?->signature_path)
                            <div style="margin-top: -10px; margin-bottom: -10px;">
                                <img src="{{ public_path('storage/' . $letter->signer->signature_path) }}" style="height: 60px; max-width: 160px; object-fit: contain;" alt="Tanda Tangan">
                            </div>
                        @endif
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    
                    <p style="margin: 10px 0 0 0; line-height: 1.4;">
                        <u><strong>{{ $letter->signer?->name ?? 'NAMA PEJABAT PPID' }}</strong></u><br>
                        NIP. {{ $letter->signer?->nip ?? '--------------------' }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    @if(!empty($footer))
        <div style="position: fixed; bottom: 0; left: 0; right: 0;">
            {!! $footer !!}
        </div>
    @endif
</body>
</html>
