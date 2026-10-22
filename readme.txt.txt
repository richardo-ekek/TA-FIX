README Dokumentasi TA SPA Kemlu
Sistem Portal Terpadu (SPA) Kebijakan, Berita & Janji Temu - Kementerian Luar Negeri RI

Aplikasi web berbasis Laravel yang dikelola untuk mengatur dokumen kerja sama (MoU/PKS), kebijakan TIK, publikasi berita, serta layanan janji temu dengan keamanan berlapis dan akuntabilitas pimpinan (Audit Trail).

Fitur Utama & Keamanan:

1.  Manajemen Dokumen (MoU/PKS & TIK)
2.  Integrasi Berita & AI (Groq Llama 3 & NewsData.io)
3.  Layanan Janji Temu (Appointment Booking)
4.  Keamanan Aplikasi (reCAPTCHA v3, Audit Trail, RBAC, Password Hashing)

Informasi Akun Pengujian:

  - Super Admin: richardo@test.com / password: tikusbakar
  - Admin: opungmangatur@gmail.com / password: kucingbakar
  - Tim Hukum: richardogilbertmanalu@gmail.com / password: lengkuasbakar
  - User: manalu.fams@gmail.com / password: bawangbakar

Panduan Instalasi Lokal:

1.  Clone repository & composer install
2.  Sesuaikan file .env dengan database db_portal_kebijakan
3.  php artisan key:generate
4.  Import file db_portal_kebijakan.sql
5.  php artisan serve