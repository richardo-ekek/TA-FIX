<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f3f4f6;
            padding: 40px 0;
        }
        .main-content {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .body-content {
            padding: 40px;
            color: #374151;
            line-height: 1.6;
            font-size: 16px;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #111827;
        }
        .alert-box {
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 6px solid;
        }
        .alert-success {
            background-color: #ecfdf5;
            border-color: #10b981;
        }
        .alert-danger {
            background-color: #fef2f2;
            border-color: #ef4444;
        }
        .alert-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .text-success { color: #047857; }
        .text-danger { color: #b91c1c; }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .detail-table td {
            padding: 8px 0;
            vertical-align: top;
            font-size: 15px;
        }
        .detail-label {
            font-weight: bold;
            color: #4b5563;
            width: 35%;
        }
        .detail-value {
            color: #111827;
            font-weight: 500;
        }
        .btn-container {
            text-align: center;
            margin: 40px 0 20px 0;
        }
        .btn {
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px 40px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <center class="wrapper">
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Pusat Layanan Kementerian Luar Negeri</h1>
            </div>

            <!-- Body -->
            <div class="body-content">
                <div class="greeting">
                    Halo, {{ $appointment->user->name ?? $appointment->nama ?? 'Pemohon' }} 👋
                </div>
                <p>Terima kasih telah menggunakan Portal Layanan kami. Berikut adalah hasil tinjauan dari Admin mengenai permohonan janji temu Anda yang bertujuan untuk: <strong>"{{ $appointment->tujuan }}"</strong>.</p>

                <!-- KONDISI JIKA DISETUJUI -->
                @if($appointment->status === 'approved')
                    <div class="alert-box alert-success">
                        <div class="alert-title text-success">✅ PERMOHONAN DISETUJUI</div>
                        <p style="margin-top:0; font-size: 14px; color: #065f46;">Admin kami telah mengkonfirmasi jadwal pertemuan Anda. Berikut adalah detail lengkapnya:</p>
                        
                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">Waktu Pertemuan</td>
                                <td class="detail-value">: {{ \Carbon\Carbon::parse($appointment->tanggal_waktu_pertemuan)->translatedFormat('l, d F Y - H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Mode Pertemuan</td>
                                <td class="detail-value">: <span style="text-transform: capitalize;">{{ $appointment->mode }}</span></td>
                            </tr>

                            <!-- Cek Mode Pertemuan -->
                            @if(strtolower($appointment->mode) === 'daring')
                                <tr>
                                    <td class="detail-label">Tautan pertemuan</td>
                                    <td class="detail-value">: <a href="{{ $appointment->link_meeting }}" style="color: #4f46e5; word-break: break-all;">{{ $appointment->link_meeting ?? 'Tautan belum tersedia' }}</a></td>
                                </tr>
                            @else
                                <tr>
                                    <td class="detail-label">Lokasi Gedung</td>
                                    <td class="detail-value">: {{ $appointment->alamat_pertemuan ?? 'Menunggu konfirmasi ruangan' }}</td>
                                </tr>
                                @if($appointment->link_maps)
                                <tr>
                                    <td class="detail-label">Titik Lokasi</td>
                                    <td class="detail-value">: <a href="{{ $appointment->link_maps }}" style="color: #4f46e5;">Buka Peta Lokasi</a></td>
                                </tr>
                                @endif
                            @endif
                        </table>

                        <!-- Catatan Tambahan (Jika Ada) -->
                        @if($appointment->keterangan_tambahan)
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #a7f3d0;">
                                <strong style="color: #065f46; font-size: 14px;">Catatan Tambahan:</strong>
                                <p style="margin: 5px 0 0 0; font-size: 14px; font-style: italic; color: #047857;">"{{ $appointment->keterangan_tambahan }}"</p>
                            </div>
                        @endif
                    </div>
                    <p>Mohon pastikan Anda hadir tepat waktu sesuai dengan jadwal yang telah disepakati.</p>

                <!-- KONDISI JIKA DITOLAK -->
                @elseif($appointment->status === 'rejected')
                    <div class="alert-box alert-danger">
                        <div class="alert-title text-danger">❌ PERMOHONAN DITOLAK</div>
                        <p style="margin: 10px 0 0 0; color: #991b1b;">Mohon maaf, permohonan janji temu Anda tidak dapat kami proses saat ini dengan alasan sebagai berikut:</p>
                        
                        <div style="margin-top: 15px; padding: 15px; background-color: #fee2e2; border-radius: 6px;">
                            <span style="font-style: italic; color: #7f1d1d;">"{{ $appointment->alasan_penolakan ?: 'Jadwal pimpinan penuh atau terdapat kendala teknis operasional.' }}"</span>
                        </div>
                    </div>
                    <p>Anda dapat mengajukan permohonan ulang dengan jadwal yang berbeda melalui portal kami.</p>

                <!-- KONDISI JIKA MASIH PENDING (Opsional/Jaga-jaga) -->
                @else
                    <div class="alert-box" style="background-color: #fffbeb; border-color: #f59e0b; border-left: 6px solid #f59e0b;">
                        <div class="alert-title" style="color: #b45309;">⏳ SEDANG DIPROSES</div>
                        <p style="margin:0; color: #92400e;">Permohonan Anda masih dalam tahap peninjauan. Mohon menunggu informasi selanjutnya.</p>
                    </div>
                @endif

                <!-- TOMBOL MENUJU DASHBOARD USER -->
                <div class="btn-container">
                    <a href="{{ route('user.dashboard') }}" class="btn" style="color: white !important;">Buka Dashboard Saya</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p style="margin: 0;">Email ini dibuat secara otomatis oleh sistem.</p>
                <p style="margin: 5px 0 0 0;">Mohon untuk tidak membalas ke alamat email ini.</p>
            </div>
        </div>
    </center>
</body>
</html>