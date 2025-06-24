<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Tanda Anggota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .card {
            width: 85.6mm;
            height: 54mm;
            margin: 0 auto 8px auto;
            border: 1px solid #276749;
            background-color: #e6ffee;
        }
        .header {
            background-color: #1e6641;
            color: white;
            padding: 8px;
            font-weight: bold;
        }
        .header-table {
            width: 100%;
        }
        .org-name {
            font-size: 14px;
            text-transform: uppercase;
        }
        .member-id {
            background-color: white;
            color: #000;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
            text-align: center;
        }
        .title {
            text-align: center;
            padding: 5px 0;
            color: #276749;
            font-weight: bold;
            font-size: 14px;
            background-color: #e6ffee;
            border-bottom: 1px solid #d3f5de;
        }
        .photo {
            width: 60px;
            height: 75px;
            border: 1px solid #276749;
            background-color: #f0fff4;
            vertical-align: top;
        }
        .info-label {
            color: #276749;
            font-weight: bold;
            width: 35%;
            vertical-align: top;
            padding: 2px 0;
        }
        .info-value {
            color: #333;
            vertical-align: top;
            padding: 2px 0;
        }
        .signature {
            border-top: 1px solid #d3f5de;
            padding: 4px 0;
        }
        .signature-line {
            border-top: 1px solid #276749;
            width: 60px;
            margin-top: 8px;
        }
        .signature-title {
            font-size: 7px;
            text-align: center;
            margin-top: 2px;
        }
        .back-card {
            width: 85.6mm;
            height: 54mm;
            margin: 10px auto 0 auto;
            border: 1px solid #276749;
            background-color: #e6ffee;
        }
        .back-header {
            text-align: center;
            padding: 5px;
            color: #276749;
            font-weight: bold;
            border-bottom: 1px solid #d3f5de;
        }
        .rules {
            padding: 8px;
        }
        .rules-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .rules-list {
            margin: 0;
            padding-left: 20px;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #276749;
            padding: 5px;
            font-size: 8px;
            color: #276749;
        }
    </style>
</head>
<body>
    <!-- Kartu Sisi Depan -->
    <table class="card">
        <tr>
            <td class="header" colspan="2">
                <table class="header-table">
                    <tr>
                        <td width="80%" class="org-name">PITALOKA AMS</td>
                        <td width="20%" class="member-id">{{ $member->member_id }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="title">KARTU TANDA ANGGOTA</td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0 10px;">
                <table width="100%">
                    <tr>
                        <td width="30%" style="padding: 8px 15px 8px 0; vertical-align: top;">
                            <div class="photo">
                                @if($member->photo)
                                    <img src="{{ public_path('storage/' . $member->photo) }}" alt="Foto Anggota" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="text-align: center; padding-top: 30px; color: #888;">Tidak Ada Foto</div>
                                @endif
                            </div>
                        </td>
                        <td width="70%" style="vertical-align: top;">
                            <table width="100%">
                                <tr>
                                    <td class="info-label">Nama</td>
                                    <td class="info-value">: {{ $member->name }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">Distrik</td>
                                    <td class="info-value">: {{ $member->district?->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">Tgl Daftar</td>
                                    <td class="info-value">: {{ $member->registration_date ? $member->registration_date->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">Berlaku s/d</td>
                                    <td class="info-value">: {{ $member->expiry_date?->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 5px 50px;">
                <table width="100%">
                    <tr>
                        <td width="50%" align="center">
                            <div class="signature-line"></div>
                            <div class="signature-title">Ketua Umum</div>
                        </td>
                        <td width="50%" align="center">
                            <div class="signature-line"></div>
                            <div class="signature-title">Sekretaris</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Kartu Sisi Belakang -->
    <table class="back-card">
        <tr>
            <td class="back-header">Kartu ini adalah bukti keanggotaan resmi di Pitaloka AMS</td>
        </tr>
        <tr>
            <td class="rules">
                <div class="rules-title">KETENTUAN:</div>
                <ol class="rules-list">
                    <li>Kartu ini adalah hak milik Pitaloka AMS dan hanya diberikan kepada anggota resmi.</li>
                    <li>Pemegang kartu wajib mematuhi peraturan dan kode etik organisasi.</li>
                    <li>Jika menemukan kartu ini harap mengembalikan ke alamat sekretariat.</li>
                    <li>Kartu ini tidak dapat dipindahtangankan kepada orang lain.</li>
                    <li>Segera laporkan jika terjadi kehilangan atau kerusakan kartu.</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px 10px;">
                <table width="100%">
                    <tr>
                        <td width="20%" style="background-color: #ecc94b; width: 25px; height: 25px;"></td>
                        <td width="80%" align="right">
                            <div style="font-size: 9px; font-weight: bold; color: #276749;">
                                {{ $member->member_id }}<br>{{ $member->member_id }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="footer">Pitaloka AMS - Jawa Barat</td>
        </tr>
    </table>
</body>
</html>
