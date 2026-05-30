<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; padding: 20px; }
        .container { background-color: #ffffff; max-width: 600px; margin: 0 auto; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #4f46e5; color: white; padding: 25px; text-align: center; }
        .content { padding: 30px; color: #374151; line-height: 1.6; }
        .status-box { display: inline-block; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .status-approved { background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .details { background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .footer { background-color: #f9fafb; color: #6b7280; text-align: center; padding: 20px; font-size: 12px; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Pusat Komando Layanan</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $appointment->user->name ?? 'Pengguna' }}</strong> 👋</p>
            <p>Permohonan janji temu Anda telah ditinjau oleh tim Admin kami. Berikut adalah rincian pembaruan status Anda:</p>
            
            <div class="details">
                <p style="margin-top:0;"><strong>Tujuan Pertemuan:</strong><br>{{ $appointment->tujuan }}</p>
                <p><strong>Status:</strong><br>
                    @if($appointment->status == 'approved')
                        <span class="status-box status-approved">Disetujui</span>
                    @elseif($appointment->status == 'rejected')
                        <span class="status-box status-rejected">Ditolak</span>
                    @else
                        <span class="status-box">Menunggu</span>
                    @endif
                </p>

                @if($appointment->status == 'approved')
                    <p style="margin-bottom:0;"><strong>Jadwal yang Ditetapkan:</strong><br>
                    {{ \Carbon\Carbon::parse($appointment->waktu_disetujui)->format('d M Y, H:i') }} WIB</p>
                @elseif($appointment->status == 'rejected')
                    <p style="margin-bottom:0;"><strong>Alasan Penolakan:</strong><br>
                    {{ $appointment->alasan_penolakan ?: 'Maaf, jadwal penuh atau terdapat kendala teknis lainnya.' }}</p>
                @endif
            </div>

            @if($appointment->status == 'approved')
                <p>Silakan datang tepat waktu sesuai dengan jadwal yang telah ditetapkan di atas.</p>
            @endif

            <p>Terima kasih,<br><strong>Tim Admin Portal</strong></p>
        </div>
        <div class="footer">
            Email ini dibuat secara otomatis oleh sistem. Mohon untuk tidak membalas ke alamat email ini.
        </div>
    </div>
</body>
</html>