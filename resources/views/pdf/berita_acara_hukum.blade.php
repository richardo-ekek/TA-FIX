<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Verifikasi Hukum</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; margin: 2cm; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 16pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header p { font-size: 10pt; margin: 0; font-style: italic; }
        .title { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin-top: 20px; margin-bottom: 5px; text-transform: uppercase; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 25px; }
        .content { text-align: justify; margin-bottom: 30px; }
        .table-meta { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .table-meta td { padding: 4px 0; vertical-align: top; }
        .ttd-box { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .ttd-col { width: 45%; float: right; text-align: center; }
        .stamp { border: 2px solid #1e3a8a; color: #1e3a8a; padding: 10px; border-radius: 8px; display: inline-block; margin: 10px 0; font-family: Arial, sans-serif; font-size: 9pt; font-weight: bold; text-transform: uppercase; background-color: #f0fdf4; border-color: #16a34a; color: #16a34a; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <div class="header">
        <h1>Kementerian Luar Negeri Republik Indonesia</h1>
        <h2>Portal Kebijakan & Layanan Pertemuan</h2>
        <p>Jl. Taman Pejambon No. 6, Senen, Jakarta Pusat 10410 | Email: portal.kebijakan@kemlu.go.id</p>
    </div>

    <div class="title">Berita Acara Hasil Verifikasi Hukum</div>
    <div class="nomor">Nomor: BA-HK/{{ date('Y/m') }}/{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}</div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>, Tim Hukum Kementerian Luar Negeri Republik Indonesia telah melaksanakan pemeriksaan dan verifikasi aspek legalitas terhadap draf dokumen kebijakan operasional dengan rincian sebagai berikut:</p>

        <table class="table-meta">
            <tr>
                <td style="width: 25%;"><strong>Jenis Dokumen</strong></td>
                <td style="width: 5%;">:</td>
                <td style="width: 70%;">{{ strtoupper($tipe) }}</td>
            </tr>
            <tr>
                <td><strong>Perihal / Judul</strong></td>
                <td>:</td>
                <td>{{ $data->perihal }}</td>
            </tr>
            <tr>
                <td><strong>Diajukan Oleh</strong></td>
                <td>:</td>
                <td>{{ $data->admin->name ?? 'Admin Operasional' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pengajuan</strong></td>
                <td>:</td>
                <td>{{ $data->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td><strong>Catatan Legalitas</strong></td>
                <td>:</td>
                <td>{{ $catatan ?: 'Seluruh klausul dan konsideran hukum telah sesuai dengan ketentuan perundang-undangan yang berlaku.' }}</td>
            </tr>
        </table>

        <p>Berdasarkan hasil tinjauan tersebut, Tim Hukum menyatakan bahwa draf dokumen kebijakan di atas <strong>MEMENUHI SYARAT LEGALITAS DAN LAYAK (APPROVED)</strong> untuk diteruskan kepada Pimpinan (Super Admin) guna proses pengesahan akhir.</p>
        <p>Demikian Berita Acara ini dibuat secara otomatis oleh Sistem Portal Terpadu (SPA) untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- KOLOM TANDA TANGAN OTOMATIS -->
    <div class="ttd-box">
        <div class="ttd-col">
            <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><strong>Tim Hukum / Verifikator Legal,</strong></p>
            
            <!-- STEMPEL / TANDA TANGAN DIGITAL OTOMATIS -->
            <div class="stamp">
                [ TANDA TANGAN DIGITAL SAH ]<br>
                VERIFIED BY SYSTEM<br>
                <span style="font-size: 7pt; font-weight: normal;">ID: {{ md5(auth()->id() . $data->id . time()) }}</span>
            </div>

            <p><u><strong>{{ auth()->user()->name }}</strong></u><br>NIP. {{ auth()->user()->profile->nip ?? '198001012005011001' }}</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>