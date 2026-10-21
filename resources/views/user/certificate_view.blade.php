<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kelulusan — {{ $course->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Great+Vibes&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #c5a85c;
            --gold-light: #e5c982;
            --navy: #0b1325;
            --border-color: #cbd5e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f1f5f9;
            font-family: 'Outfit', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            color: #0f172a;
        }

        /* Action bar above certificate */
        .action-bar {
            width: 100%;
            max-width: 950px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: #ffffff;
            padding: 12px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #7c5cbf, #9b78e0);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(124, 92, 191, 0.25);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(124, 92, 191, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: #475569;
            border: 1px solid #cbd5e1;
            box-shadow: none;
        }

        .btn-outline:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #94a3b8;
            box-shadow: none;
            transform: none;
        }

        /* Certificate outer layout */
        .certificate-container {
            background: #ffffff;
            width: 100%;
            max-width: 950px;
            aspect-ratio: 1.414 / 1; /* A4 Landscape aspect ratio */
            padding: 40px;
            position: relative;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Elaborate double border design */
        .cert-outer-border {
            border: 20px solid var(--navy);
            width: 100%;
            height: 100%;
            position: relative;
            padding: 24px;
        }

        .cert-inner-border {
            border: 2px solid var(--gold);
            width: 100%;
            height: 100%;
            position: relative;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            background: radial-gradient(circle, rgba(255,255,255,1) 70%, rgba(248,250,252,0.6) 100%);
        }

        /* Corners designs */
        .cert-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 4px solid var(--gold);
            z-index: 10;
        }
        .corner-tl { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .corner-tr { top: -2px; right: -2px; border-left: none; border-bottom: none; }
        .corner-bl { bottom: -2px; left: -2px; border-right: none; border-top: none; }
        .corner-br { bottom: -2px; right: -2px; border-left: none; border-top: none; }

        /* Header elements */
        .cert-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-box img {
            height: 32px;
            object-contain: fit;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .logo-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1;
        }

        .logo-subtitle {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            font-weight: 700;
        }

        /* Main certificate titles */
        .cert-title-section {
            text-align: center;
            margin-top: 15px;
        }

        .cert-main-title {
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: var(--navy);
            font-family: 'Outfit', sans-serif;
        }

        .cert-subtitle {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--gold);
            font-weight: 700;
            margin-top: 5px;
        }

        /* Recipient and award text */
        .cert-body {
            text-align: center;
            margin: 20px 0;
            width: 100%;
        }

        .cert-present-text {
            font-size: 13px;
            color: #64748b;
            font-style: italic;
        }

        .cert-name {
            font-family: 'Great Vibes', cursive;
            font-size: 46px;
            color: var(--navy);
            margin: 10px 0;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 8px;
            display: inline-block;
            min-width: 60%;
        }

        .cert-reason {
            font-size: 13px;
            color: #475569;
            line-height: 1.6;
            max-width: 80%;
            margin: 0 auto;
        }

        .cert-course-name {
            font-weight: 800;
            color: var(--navy);
            font-size: 15px;
        }

        /* Signatures and Seals section */
        .cert-footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 10px;
            padding: 0 20px;
        }

        .cert-sign-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
            position: relative;
        }

        .signature-img {
            height: 48px;
            object-contain: fit;
            margin-bottom: 2px;
        }

        .signature-line {
            width: 100%;
            height: 1px;
            background: #cbd5e1;
            margin-bottom: 6px;
        }

        .signer-name {
            font-size: 11px;
            font-weight: 700;
            color: var(--navy);
        }

        .signer-role {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Gold metallic stamp seal */
        .cert-seal-block {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: -5px;
        }

        .cert-seal {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--gold-light) 0%, var(--gold) 100%);
            border: 3px dashed #ffffff;
            box-shadow: 0 4px 10px rgba(197, 168, 92, 0.4), inset 0 0 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cert-seal::before {
            content: '';
            position: absolute;
            width: 66px;
            height: 66px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.6);
        }

        .seal-text {
            font-size: 8px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            line-height: 1.1;
        }

        /* Certificate validation details */
        .cert-validation {
            position: absolute;
            bottom: 28px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 74px;
            font-family: 'Fira Code', monospace;
            font-size: 8px;
            color: #94a3b8;
        }

        .validation-link {
            color: #64748b;
            text-decoration: none;
        }

        /* PRINT STYLES - Crucial for window.print() */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
                margin: 0;
                display: block;
            }

            .action-bar {
                display: none !important;
            }

            .certificate-container {
                box-shadow: none !important;
                border: none !important;
                width: 297mm; /* Exact A4 Landscape Width */
                height: 210mm; /* Exact A4 Landscape Height */
                page-break-inside: avoid;
                page-break-after: avoid;
                position: absolute;
                top: 0;
                left: 0;
                margin: 0;
                padding: 20px;
            }

            .cert-outer-border {
                border-width: 15px !important;
            }

            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- ACTION BAR -->
    <div class="action-bar">
        <a href="{{ route('user.courses.results', $course->id) }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div>
            <button onclick="window.print()" class="btn">
                <i class="fas fa-print"></i> Cetak / Simpan ke PDF
            </button>
        </div>
    </div>

    <!-- CERTIFICATE CONTAINER -->
    <div class="certificate-container">
        
        <div class="cert-outer-border">
            <div class="cert-inner-border">
                
                <!-- Inner Corners -->
                <div class="cert-corner corner-tl"></div>
                <div class="cert-corner corner-tr"></div>
                <div class="cert-corner corner-bl"></div>
                <div class="cert-corner corner-br"></div>

                <!-- CERTIFICATE HEADER -->
                <div class="cert-header">
                    <div class="logo-box">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                        <div class="logo-text">
                            <span class="logo-title">talentgroup.id</span>
                            <span class="logo-subtitle">Academy</span>
                        </div>
                    </div>
                </div>

                <!-- TITLES -->
                <div class="cert-title-section">
                    <h2 class="cert-main-title">Sertifikat Kelulusan</h2>
                    <div class="cert-subtitle">Certificate of Completion</div>
                </div>

                <!-- BODY -->
                <div class="cert-body">
                    <p class="cert-present-text">Sertifikat ini secara resmi dianugerahkan kepada:</p>
                    <h1 class="cert-name">{{ $user->name }}</h1>
                    <p class="cert-reason">
                        Atas kelulusan dan penguasaan menyeluruh pada modul materi pembelajaran:<br>
                        <span class="cert-course-name">"{{ $course->title }}"</span><br>
                        yang diselenggarakan oleh platform pembelajaran interaktif talentgroup.id.
                    </p>
                </div>

                <!-- SIGNATURES AND SEALS -->
                <div class="cert-footer">
                    <!-- Instructor -->
                    <div class="cert-sign-block">
                        <!-- Simulated Digital Signature -->
                        <div style="font-family: 'Great Vibes', cursive; font-size: 26px; color: #7c5cbf; height: 48px; display: flex; align-items: center; justify-content: center;">
                            talentgroup.id
                        </div>
                        <div class="signature-line"></div>
                        <span class="signer-name">System Instructor</span>
                        <span class="signer-role">Akademik</span>
                    </div>

                    <!-- Seal -->
                    <div class="cert-seal-block">
                        <div class="cert-seal">
                            <div class="seal-text">
                                OFFICIAL<br>SEAL<br>VERIFIED
                            </div>
                        </div>
                    </div>

                    <!-- Founder -->
                    <div class="cert-sign-block">
                        <!-- Simulated Digital Signature for Founder -->
                        <div style="font-family: 'Great Vibes', cursive; font-size: 26px; color: #c5a85c; height: 48px; display: flex; align-items: center; justify-content: center;">
                            Adrian Firmansyah
                        </div>
                        <div class="signature-line"></div>
                        <span class="signer-name">Adrian Firmansyah</span>
                        <span class="signer-role">Founder & CEO</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- VALIDATION METADATA (ABSOLUTE PLACEMENT) -->
        <div class="cert-validation">
            <span>KODE SERTIFIKAT: {{ $certificate->certificate_code }}</span>
            <span>DITERBITKAN PADA: {{ $certificate->issued_at->format('d F Y') }}</span>
            <span class="validation-link">VERIFIKASI DI: talentgroup.id/verify</span>
        </div>

    </div>

</body>
</html>
