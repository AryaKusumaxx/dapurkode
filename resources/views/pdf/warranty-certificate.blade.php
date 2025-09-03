<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Garansi</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .certificate {
            border: 2px solid #000;
            padding: 20px;
            position: relative;
            background-color: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 200px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            color: #333;
        }
        .content {
            margin: 20px 0;
        }
        .content h2 {
            font-size: 18px;
            margin-top: 0;
            color: #333;
            text-transform: uppercase;
        }
        .warranty-id {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 0;
            width: 30%;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            width: 70%;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            display: block;
            width: 200px;
            height: 1px;
            background: #000;
            margin-bottom: 5px;
            float: right;
        }
        .signature-name {
            clear: both;
            font-weight: bold;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            opacity: 0.05;
            color: #000;
            white-space: nowrap;
            pointer-events: none;
        }
        .valid {
            color: #28a745;
            font-weight: bold;
        }
        .expired {
            color: #dc3545;
            font-weight: bold;
        }
        .serial-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 20px 0;
            background-color: #f9f9f9;
            text-align: center;
            font-family: monospace;
            font-size: 16px;
            letter-spacing: 2px;
        }
        .qrcode {
            text-align: center;
            margin-top: 20px;
        }
        .qrcode img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate">
            <div class="watermark">GARANSI RESMI</div>
            
            <div class="header">
                <!-- Logo -->
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/dapurkode.png'))) }}" alt="Logo">
                <h1>Sertifikat Garansi Produk</h1>
            </div>
            
            <div class="warranty-id">
                No. Garansi: <strong>{{ $warranty->id }}</strong>
            </div>
            
            <div class="content">
                <h2>Detail Produk</h2>
                <div class="info-section">
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Nama Produk:</div>
                            <div class="info-value">{{ $product->name }}</div>
                        </div>
                        @if($warranty->orderItem->variant_name)
                        <div class="info-row">
                            <div class="info-label">Varian:</div>
                            <div class="info-value">{{ $warranty->orderItem->variant_name }}</div>
                        </div>
                        @endif
                        @if($warranty->serial_number)
                        <div class="info-row">
                            <div class="info-label">Nomor Seri:</div>
                            <div class="info-value">{{ $warranty->serial_number }}</div>
                        </div>
                        @endif
                        <div class="info-row">
                            <div class="info-label">Tanggal Pembelian:</div>
                            <div class="info-value">{{ $warranty->start_date->format('d F Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <h2>Detail Customer</h2>
                <div class="info-section">
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Nama:</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email:</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        @if($user->phone_number)
                        <div class="info-row">
                            <div class="info-label">Telepon:</div>
                            <div class="info-value">{{ $user->phone_number }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <h2>Detail Garansi</h2>
                <div class="info-section">
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Mulai Berlaku:</div>
                            <div class="info-value">{{ $warranty->start_date->format('d F Y') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Berakhir Pada:</div>
                            <div class="info-value">{{ $warranty->end_date->format('d F Y') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status:</div>
                            <div class="info-value">
                                @if($warranty->isActive())
                                    <span class="valid">Aktif</span>
                                @else
                                    <span class="expired">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        @if($warranty->isActive() && $remainingDays > 0)
                        <div class="info-row">
                            <div class="info-label">Sisa Masa Garansi:</div>
                            <div class="info-value">{{ $remainingDays }} hari</div>
                        </div>
                        @endif
                    </div>
                </div>
                
                @if($warranty->extensions->count() > 0)
                <h2>Riwayat Perpanjangan</h2>
                <div class="info-section">
                    <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                            <th>Tanggal Perpanjangan</th>
                            <th>Durasi</th>
                            <th>Status</th>
                        </tr>
                        @foreach($warranty->extensions as $extension)
                        <tr>
                            <td>{{ $extension->created_at->format('d M Y') }}</td>
                            <td>{{ $extension->months }} bulan</td>
                            <td>
                                @if($extension->isPaid())
                                    Lunas
                                @else
                                    Pending
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
                <div class="serial-box">
                    {{ strtoupper(md5($warranty->id . $warranty->start_date)) }}
                </div>
            </div>
            
            <div class="footer">
                <p>Dokumen ini adalah bukti resmi kepemilikan garansi produk. Simpan dengan baik untuk klaim garansi.</p>
                <p>Hubungi kami di <strong>support@example.com</strong> atau <strong>(021) 1234-5678</strong> untuk bantuan lebih lanjut.</p>
                
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">Customer Support</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
