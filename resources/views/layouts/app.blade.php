<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'TalentGroup.id')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('tg/assets/60-2-img-logo.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans (ultra crisp & modern), Inter, & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Local Fonts & Core Styles from tg-website -->
    <link rel="stylesheet" href="{{ asset('tg/fonts.css') }}">
    
    <!-- Tailwind & Alpine & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Immediate Theme Initialization Script (Prevent White Flash/FOUC on reload) -->
    <script>
        (function() {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                if (document.body) document.body.classList.add('dark');
            }
        })();
    </script>

    <style>
        :root {
            /* TalentGroup Core Tokens - Light by Default (clean, readable, user-friendly) */
            --bg: #f8fafc;
            --bg2: #ffffff;
            --bg3: #f1f5f9;
            --surface: #ffffff;
            --surface2: #f8fafc;
            --blue: #0047b3;
            --blue-dark: #00408c;
            --blue-light: #e6f0ff;
            --ink: #0b2447;
            --body: #334155;
            --muted: #64748b;
            --line: #d5deee;
            --canvas: #f8fafc;
            --green: #0f8a5f;
            
            /* Alias for existing view compatibility */
            --text: #0f172a;
            --text2: #334155;
            --text3: #64748b;
            --border: #d5deee;
            --php: #0047b3;
            --php2: #2563eb;
            --cyan: #0047b3;
            --cyan2: #0284c7;
            --orange: #ea580c;
            --orange2: #f97316;
            --panel: var(--surface);
            --sidebar-width: 270px;
            --topbar-height: 68px;
            --card-shadow: 0 4px 16px rgba(11, 36, 71, 0.05);
        }

        .dark, body.dark {
            /* Elegant Deep Navy & Icy Blue Luxury Palette */
            --bg: #070e1e;
            --bg2: #0c1731;
            --bg3: #122144;
            --surface: #0e1c3b;
            --surface2: #152750;
            --text: #f8fafc;
            --text2: #e2e8f0;
            --text3: #94a3b8;
            --border: #1d3768;
            --blue: #38bdf8;
            --blue-dark: #7dd3fc;
            --blue-light: rgba(56, 189, 248, 0.15);
            --ink: #ffffff;
            --body: #e2e8f0;
            --muted: #94a3b8;
            --line: #1d3768;
            --canvas: #070e1e;
            --php: #38bdf8;
            --php2: #60a5fa;
            --cyan: #38bdf8;
            --cyan2: #7dd3fc;
            --card-shadow: 0 8px 30px rgba(0, 15, 45, 0.55);
        }

        * {
            -webkit-tap-highlight-color: transparent;
            margin: 0; padding: 0; box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        html, body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', 'Outfit', system-ui, sans-serif;
            letter-spacing: -0.015em;
        }

        button, input, select, textarea, table {
            font-family: inherit;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg3); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* App Shell & Sidebar */
        .sidebar-container {
            position: fixed;
            top: 0; bottom: 0; left: 0;
            width: var(--sidebar-width);
            background: var(--bg2);
            border-right: 1px solid var(--border);
            z-index: 1001;
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(11, 36, 71, 0.03);
        }

        .main-layout {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
        }

        .topbar-header {
            position: fixed;
            top: 0; right: 0;
            left: var(--sidebar-width);
            height: var(--topbar-height);
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            transition: left 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(11, 36, 71, 0.03);
        }

        body.dark .topbar-header {
            background: rgba(17, 28, 56, 0.95);
        }

        .main-content {
            margin-top: var(--topbar-height);
            flex: 1;
            padding: 32px 28px;
            position: relative;
        }

        /* Collapsed States */
        .sidebar-collapsed .sidebar-container {
            transform: translateX(-100%);
        }
        .sidebar-collapsed .main-layout {
            margin-left: 0;
        }
        .sidebar-collapsed .topbar-header {
            left: 0;
        }

        /* Mobile Sidebar */
        @media(max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
            }
            .main-layout {
                margin-left: 0;
            }
            .topbar-header {
                left: 0;
                padding: 0 16px;
            }
            .sidebar-open-mobile .sidebar-container {
                transform: translateX(0);
            }
            .sidebar-open-mobile .sidebar-overlay {
                display: block;
            }
            .main-content {
                padding: 20px 16px;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 36, 71, 0.5);
            z-index: 1000;
            backdrop-filter: blur(3px);
        }

        /* Brand Styling */
        .dashboard-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .dashboard-brand strong {
            font-size: 18px;
            font-weight: 800;
            color: var(--blue);
            letter-spacing: -0.3px;
        }

        /* Navigation Menu Links */
        .nav-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text2);
            border-radius: 10px;
            transition: all 0.2s ease;
            margin: 2px 14px;
            text-decoration: none;
        }
        .nav-menu-link:hover {
            color: var(--blue);
            background: var(--blue-light);
        }
        .nav-menu-link.active {
            color: var(--blue);
            background: var(--blue-light);
            font-weight: 700;
            border-left: 4px solid var(--blue);
        }

        /* Card & Panel Styling */
        .cyber-card, .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            box-shadow: var(--card-shadow);
            position: relative;
        }
        .cyber-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 8px 24px rgba(0, 71, 179, 0.08);
        }

        /* Prototype & Empty State Box - Adaptive Light & Dark (Bukan putih polos) */
        .empty-prototype-box {
            background: linear-gradient(180deg, #edf4ff 0%, #e2eeff 100%) !important;
            border: 2px dashed #93c5fd !important;
            border-radius: 16px;
            color: var(--body);
            transition: all 0.25s ease;
        }
        .empty-prototype-box .empty-icon-wrap {
            background: #ffffff !important;
            color: var(--blue) !important;
            border: 1.5px solid #bfdbfe !important;
            box-shadow: 0 4px 12px rgba(0, 71, 179, 0.08) !important;
        }
        .empty-prototype-box h2,
        .empty-prototype-box h3 {
            color: var(--ink) !important;
        }
        .empty-prototype-box p {
            color: var(--text2) !important;
        }

        /* Button Styling from tg-website */
        .btn, .cyber-btn, .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            min-height: 42px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: var(--blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 13.5px;
            line-height: 1.2;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 71, 179, 0.2);
        }
        .btn:hover, .cyber-btn:hover, .btn-primary:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 71, 179, 0.3);
            color: #ffffff;
        }
        .btn:active, .cyber-btn:active {
            transform: translateY(1px);
        }

        .btn-gradient {
            background: linear-gradient(136deg, #0047b3, #2563eb);
            color: #ffffff !important;
            border: none;
            box-shadow: 0 4px 14px rgba(0, 71, 179, 0.25);
        }

        .btn-outline, .btn.btn-outline, .cyber-btn.outline, .btn-ghost {
            background: var(--surface) !important;
            border: 1.5px solid var(--border) !important;
            color: var(--ink) !important;
            box-shadow: none !important;
        }
        .btn-outline:hover, .btn.btn-outline:hover, .cyber-btn.outline:hover, .btn-ghost:hover {
            border-color: var(--blue) !important;
            color: var(--blue) !important;
            background: var(--blue-light) !important;
        }

        /* Dedicated Resilient Action Buttons (Never pure white in dark mode) */
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            line-height: 1.2;
            border: 1px solid transparent;
        }
        .btn-action-outline {
            background: var(--surface);
            border-color: var(--border);
            color: var(--ink);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .btn-action-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
            transform: translateY(-1px);
        }
        .btn-action-primary {
            background: linear-gradient(136deg, #0047b3, #2563eb);
            color: #ffffff !important;
            box-shadow: 0 3px 10px rgba(0, 71, 179, 0.25);
        }
        .btn-action-primary:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }
        .btn-action-amber {
            background: #fef3c7;
            border-color: #fde68a;
            color: #b45309;
        }
        .btn-action-amber:hover {
            background: #fde68a;
            color: #92400e;
            transform: translateY(-1px);
        }
        .btn-action-danger {
            background: #fff1f2;
            border-color: #fecdd3;
            color: #e11d48;
        }
        .btn-action-danger:hover {
            background: #ffe4e6;
            color: #be123c;
            transform: translateY(-1px);
        }

        /* Modern Adaptive Alerts (Never blinding white in dark mode) */
        .app-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 13px 18px;
            border-radius: 14px;
            margin-bottom: 22px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
            animation: alertSlideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes alertSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .app-alert.alert-success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #6ee7b7;
            color: #065f46;
        }
        .app-alert.alert-success .alert-icon-box {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
        }
        .app-alert.alert-error {
            background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
            border: 1px solid #fda4af;
            color: #9f1239;
        }
        .app-alert.alert-error .alert-icon-box {
            background: #f43f5e;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(244, 63, 94, 0.35);
        }

        .btn-small {
            min-height: 34px;
            padding: 6px 16px;
            font-size: 12.5px;
        }

        /* Inputs & Forms */
        .cyber-input, input[type="text"], input[type="email"], input[type="password"], input[type="url"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px 14px;
            background: #ffffff;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        body.dark .cyber-input, body.dark input, body.dark select, body.dark textarea {
            background: #111c38;
            color: #f8fafc;
        }
        .cyber-input:focus, input:focus, select:focus, textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 71, 179, 0.15);
        }

        /* Inputs with Icons (Mencegah teks menimpa icon orang & kunci) */
        .has-icon-left, input.has-icon-left, input[type="text"].has-icon-left, input[type="password"].has-icon-left, input[type="email"].has-icon-left, input.pl-9, input.pl-10, input.pl-11 {
            padding-left: 42px !important;
        }
        .has-icon-right, input.has-icon-right, input[type="password"].has-icon-right, input.pr-10, input.pr-11 {
            padding-right: 42px !important;
        }

        /* Badges / Pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
        }
        .pill.solid {
            background: var(--blue);
            color: #ffffff;
        }
        .pill.success-outline {
            border: 1px solid #0f8a5f;
            color: #0f8a5f;
            background: #ecfdf5;
        }
        .pill.blue-soft {
            background: #e6f0ff;
            color: #0047b3;
            border: 1px solid #bfdbfe;
        }
        .pill.pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        /* Stepper matching tg-website (Lebih Besar & Jelas) */
        .stepper {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 20px;
            margin: 22px 0 28px 0;
            padding: 0;
            flex-wrap: wrap;
        }
        .stepper li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--muted);
            transition: all 0.2s ease;
        }
        body.dark .stepper li {
            color: #94a3b8;
        }
        .stepper li span {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg3);
            border: 2px solid var(--border);
            font-size: 13px;
            font-weight: 800;
            color: var(--muted);
            transition: all 0.2s ease;
        }
        .stepper li.active {
            color: var(--blue);
            font-weight: 800;
        }
        body.dark .stepper li.active {
            color: #38bdf8;
        }
        .stepper li.active span {
            background: var(--blue);
            border-color: var(--blue);
            color: #ffffff;
            box-shadow: 0 0 14px rgba(0, 113, 227, 0.4);
        }
        body.dark .stepper li.active span {
            background: #0284c7;
            border-color: #38bdf8;
            box-shadow: 0 0 16px rgba(56, 189, 248, 0.5);
        }
        .stepper li.completed span {
            background: #10b981;
            border-color: #10b981;
            color: #ffffff;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        thead th {
            background: var(--bg3);
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }
        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 13.5px;
            color: var(--text);
        }
        tbody tr:hover {
            background: rgba(0, 71, 179, 0.02);
        }

        /* Dark mode switch */
        .switch-theme-btn {
            width: 50px;
            height: 26px;
            border-radius: 9999px;
            background: var(--bg3);
            border: 1.5px solid var(--border);
            position: relative;
            cursor: pointer;
            transition: all 0.3s;
        }
        .switch-theme-indicator {
            position: absolute;
            top: 2px; left: 2px;
            width: 19px; height: 19px;
            border-radius: 50%;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            transition: transform 0.3s ease;
        }
        /* ==============================================================
           NIGHT MODE / DARK MODE COMPREHENSIVE LUXURY BLUE SYSTEM
           Menyesuaikan seluruh komponen agar TIDAK putih, melainkan
           biru gelap elegan dengan aksen Icy Blue bercahaya (High Contrast & Legible)
           ============================================================== */
        body.dark {
            background-color: var(--bg) !important;
            color: var(--text) !important;
        }

        /* 1. Global Card & Container Overrides (Hilangkan putih silau) */
        body.dark .bg-white,
        body.dark .cyber-card,
        body.dark .panel {
            background-color: #0d1b38 !important;
            border-color: #1d3768 !important;
            color: #f0f6ff !important;
            box-shadow: 0 8px 24px rgba(0, 15, 45, 0.45) !important;
        }

        body.dark .cyber-card:hover,
        body.dark .panel:hover {
            border-color: #38bdf8 !important;
            box-shadow: 0 12px 30px rgba(0, 15, 45, 0.6), 0 0 16px rgba(56, 189, 248, 0.15) !important;
        }

        /* 2. Admin & Header Banners */
        .admin-header-banner {
            background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        }
        body.dark .admin-header-banner,
        body.dark .cyber-card[style*="linear-gradient"] {
            background: linear-gradient(135deg, #0f244d 0%, #0a1733 100%) !important;
            border-color: #23457d !important;
            box-shadow: 0 10px 30px rgba(0, 15, 45, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.08) !important;
        }

        body.dark .empty-prototype-box {
            background: linear-gradient(180deg, #0b1730 0%, #071022 100%) !important;
            border: 2px dashed #1d3768 !important;
            box-shadow: inset 0 2px 14px rgba(0, 10, 30, 0.45) !important;
        }
        body.dark .empty-prototype-box .empty-icon-wrap {
            background: #112142 !important;
            color: #38bdf8 !important;
            border-color: #23457d !important;
            box-shadow: 0 4px 16px rgba(0, 15, 45, 0.5) !important;
        }
        body.dark .empty-prototype-box h2,
        body.dark .empty-prototype-box h3 {
            color: #ffffff !important;
        }
        body.dark .empty-prototype-box p {
            color: #94a3b8 !important;
        }

        /* 3. Tables di Night Mode */
        body.dark table {
            border-color: #1d3768 !important;
        }
        body.dark thead th {
            background: #132448 !important;
            color: #7dd3fc !important; /* Biru terang keputihan yang elegan */
            border-bottom: 1.5px solid #23457d !important;
        }
        body.dark tbody td {
            background: transparent !important;
            border-bottom: 1px solid #182e56 !important;
            color: #e2e8f0 !important;
        }
        body.dark tbody tr:hover {
            background: rgba(56, 189, 248, 0.08) !important;
        }

        /* 4. Buttons & Action Buttons di Night Mode */
        .dark .btn-outline,
        .dark .btn.btn-outline,
        .dark .cyber-btn.outline,
        .dark .btn-ghost,
        body.dark .btn-outline, 
        body.dark .btn.btn-outline, 
        body.dark .cyber-btn.outline, 
        body.dark .btn-ghost {
            background: #0f203f !important;
            border: 1.5px solid #23457d !important;
            color: #93c5fd !important; /* Icy Blue cerah */
            box-shadow: 0 2px 8px rgba(0, 15, 45, 0.3) !important;
        }
        .dark .btn-outline:hover,
        .dark .btn.btn-outline:hover,
        .dark .cyber-btn.outline:hover,
        .dark .btn-ghost:hover,
        body.dark .btn-outline:hover, 
        body.dark .btn.btn-outline:hover, 
        body.dark .cyber-btn.outline:hover, 
        body.dark .btn-ghost:hover {
            background: #1a386a !important;
            border-color: #38bdf8 !important;
            color: #ffffff !important;
            box-shadow: 0 0 16px rgba(56, 189, 248, 0.25) !important;
        }
        .dark .btn-gradient,
        body.dark .btn-gradient {
            background: linear-gradient(136deg, #0284c7, #2563eb) !important;
            box-shadow: 0 4px 16px rgba(2, 132, 199, 0.35) !important;
        }

        .dark .btn-action-outline,
        body.dark .btn-action-outline {
            background: #0f2244 !important;
            border-color: #23457d !important;
            color: #93c5fd !important;
        }
        .dark .btn-action-outline:hover,
        body.dark .btn-action-outline:hover {
            background: #1a386a !important;
            border-color: #38bdf8 !important;
            color: #ffffff !important;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.3) !important;
        }
        .dark .btn-action-primary,
        body.dark .btn-action-primary {
            background: linear-gradient(136deg, #0284c7, #2563eb) !important;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35) !important;
        }
        .dark .btn-action-amber,
        body.dark .btn-action-amber {
            background: rgba(245, 158, 11, 0.15) !important;
            border-color: rgba(245, 158, 11, 0.35) !important;
            color: #fbbf24 !important;
        }
        .dark .btn-action-amber:hover,
        body.dark .btn-action-amber:hover {
            background: rgba(245, 158, 11, 0.25) !important;
            border-color: #fbbf24 !important;
            color: #ffffff !important;
        }
        .dark .btn-action-danger,
        body.dark .btn-action-danger {
            background: rgba(244, 63, 94, 0.15) !important;
            border-color: rgba(244, 63, 94, 0.35) !important;
            color: #fda4af !important;
        }
        .dark .btn-action-danger:hover,
        body.dark .btn-action-danger:hover {
            background: rgba(244, 63, 94, 0.28) !important;
            border-color: #fb7185 !important;
            color: #ffffff !important;
            box-shadow: 0 0 12px rgba(244, 63, 94, 0.3) !important;
        }

        /* Modern Adaptive Alerts di Night Mode */
        .dark .app-alert.alert-success,
        body.dark .app-alert.alert-success {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.5) 0%, rgba(6, 95, 70, 0.3) 100%) !important;
            border: 1px solid rgba(52, 211, 153, 0.35) !important;
            color: #a7f3d0 !important;
            box-shadow: 0 8px 24px rgba(6, 78, 59, 0.25) !important;
        }
        .dark .app-alert.alert-success .alert-icon-box,
        body.dark .app-alert.alert-success .alert-icon-box {
            background: #059669 !important;
            color: #ffffff !important;
            box-shadow: 0 0 16px rgba(52, 211, 153, 0.4) !important;
        }
        .dark .app-alert.alert-error,
        body.dark .app-alert.alert-error {
            background: linear-gradient(135deg, rgba(136, 19, 55, 0.5) 0%, rgba(159, 18, 57, 0.3) 100%) !important;
            border: 1px solid rgba(251, 113, 133, 0.35) !important;
            color: #fecdd3 !important;
            box-shadow: 0 8px 24px rgba(136, 19, 55, 0.25) !important;
        }
        .dark .app-alert.alert-error .alert-icon-box,
        body.dark .app-alert.alert-error .alert-icon-box {
            background: #e11d48 !important;
            color: #ffffff !important;
        }

        /* 5. List Items, Forms & Sub-containers (Slate Opacity, Dropzones, etc) */
        body.dark [class*="bg-slate-50"],
        body.dark [class*="bg-slate-100"],
        body.dark .bg-slate-50,
        body.dark .bg-slate-100,
        body.dark .bg-slate-200 {
            background-color: #0b1733 !important;
            border-color: #1d3768 !important;
            color: #f0f6ff !important;
        }
        body.dark [class*="bg-slate-50"]:hover,
        body.dark .bg-slate-50:hover,
        body.dark .bg-slate-100:hover {
            background-color: #11234c !important;
            border-color: #38bdf8 !important;
        }

        /* 6. Metric Cards Icon Box, Alerts & Badges */
        body.dark .bg-blue-100,
        body.dark [class*="bg-blue-100"] {
            background-color: rgba(56, 189, 248, 0.2) !important;
            color: #38bdf8 !important;
            border-color: rgba(56, 189, 248, 0.35) !important;
        }
        body.dark .bg-blue-50 {
            background-color: rgba(56, 189, 248, 0.16) !important;
            color: #38bdf8 !important;
            border-color: rgba(56, 189, 248, 0.35) !important;
        }
        body.dark .bg-purple-50 {
            background-color: rgba(168, 85, 247, 0.16) !important;
            color: #c084fc !important;
            border-color: rgba(168, 85, 247, 0.35) !important;
        }
        body.dark .bg-amber-50,
        body.dark [class*="bg-amber-50"] {
            background-color: rgba(245, 158, 11, 0.14) !important;
            color: #fde68a !important;
            border-color: rgba(245, 158, 11, 0.35) !important;
        }
        body.dark .text-amber-800,
        body.dark [class*="text-amber-800"],
        body.dark [class*="text-amber-900"] {
            color: #fde68a !important;
        }
        body.dark .border-amber-200,
        body.dark [class*="border-amber-200"] {
            border-color: rgba(245, 158, 11, 0.35) !important;
        }
        body.dark .bg-emerald-50 {
            background-color: rgba(16, 185, 129, 0.16) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.35) !important;
        }
        body.dark .text-emerald-700 {
            color: #34d399 !important;
        }
        body.dark .border-emerald-200 {
            border-color: rgba(16, 185, 129, 0.35) !important;
        }

        /* 7. Pills & Badges */
        body.dark .pill.blue-soft {
            background: rgba(56, 189, 248, 0.16) !important;
            color: #38bdf8 !important;
            border-color: rgba(56, 189, 248, 0.4) !important;
        }
        body.dark .pill.success-outline {
            background: rgba(16, 185, 129, 0.16) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.4) !important;
        }
        body.dark .pill.pending {
            background: rgba(245, 158, 11, 0.16) !important;
            color: #fbbf24 !important;
            border-color: rgba(245, 158, 11, 0.4) !important;
        }

        /* 8. Topbar Header, Mobile Hamburger, & Sidebar */
        body.dark .topbar-header {
            background: rgba(10, 20, 44, 0.95) !important;
            border-bottom: 1px solid #1d3768 !important;
        }
        body.dark .sidebar-container {
            background: #09132b !important;
            border-right: 1px solid #1d3768 !important;
        }
        body.dark .nav-menu-link {
            color: #cbd5e1 !important;
        }
        body.dark .nav-menu-link:hover {
            color: #38bdf8 !important;
            background: rgba(56, 189, 248, 0.12) !important;
        }
        body.dark .nav-menu-link.active {
            color: #ffffff !important;
            background: linear-gradient(90deg, rgba(56, 189, 248, 0.22) 0%, rgba(56, 189, 248, 0.05) 100%) !important;
            border-left: 4px solid #38bdf8 !important;
        }

        .mono { font-family: 'Fira Code', monospace; }

        @guest
        .main-layout {
            margin-left: 0 !important;
        }
        .main-content {
            margin-top: 0 !important;
            padding: 0 !important;
        }
        @endguest
    </style>
</head>

<body x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false', mobileSidebarOpen: false }" 
      :class="{ 'sidebar-collapsed': !sidebarOpen || !{{ Auth::check() ? 'true' : 'false' }}, 'sidebar-open-mobile': mobileSidebarOpen }">

    @auth
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" @click="mobileSidebarOpen = false"></div>

    <!-- Navigation Sidebar Container -->
    <aside class="sidebar-container">
        <!-- Logo Branding Header -->
        <div class="p-5 border-b border-[var(--border)] flex items-center justify-between">
            <a href="{{ route('home') }}" class="dashboard-brand">
                <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" class="w-8 h-8 object-contain" alt="TalentGroup">
                <div>
                    <strong>TalentGroup</strong>
                    <div class="text-[9px] uppercase font-bold text-[var(--muted)] tracking-wider">Ruang Edukasi</div>
                </div>
            </a>
            
            <!-- Mobile Close Button -->
            <button @click="mobileSidebarOpen = false" class="md:hidden text-[var(--muted)] hover:text-[var(--text)] text-lg p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation Menus -->
        <nav class="flex-1 overflow-y-auto py-4 flex flex-col gap-1">
            @if (auth()->user()->isAdmin())
                <!-- Admin Panel Menus -->
                <div class="px-5 py-2 text-[10px] uppercase tracking-wider text-[var(--muted)] font-extrabold">Panel Admin</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-menu-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-5 text-sm text-[var(--blue)]"></i> Dashboard Admin
                </a>
                <a href="{{ route('admin.courses.index') }}" class="nav-menu-link {{ Route::is('admin.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group w-5 text-sm text-[var(--blue)]"></i> Kelola Kursus
                </a>
                <a href="{{ route('admin.modules.index') }}" class="nav-menu-link {{ Route::is('admin.modules.*') || Route::is('admin.module-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open w-5 text-sm text-[var(--blue)]"></i> Kelola Modul (Docs)
                </a>
                <a href="{{ route('admin.prototypes.index') }}" class="nav-menu-link {{ Route::is('admin.prototypes.*') ? 'active' : '' }}">
                    <i class="fas fa-cube w-5 text-sm text-[var(--blue)]"></i> Kelola Prototype
                </a>
                <a href="{{ route('admin.prototype-settings.index') }}" class="nav-menu-link {{ Route::is('admin.prototype-settings.*') ? 'active' : '' }}">
                    <i class="fas fa-robot w-5 text-sm text-[var(--blue)]"></i> Pengaturan AI & Host
                </a>
                <a href="{{ route('admin.referral-codes.index') }}" class="nav-menu-link {{ Route::is('admin.referral-codes.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-5 text-sm text-[var(--blue)]"></i> Kode Referral
                </a>
                <a href="{{ route('modules.index') }}" target="_blank" class="nav-menu-link">
                    <i class="fas fa-external-link-alt w-5 text-sm text-[var(--orange)]"></i> Buka Reader Modul
                </a>
            @else
                <!-- User Panel Menus -->
                <div class="px-5 py-2 text-[10px] uppercase tracking-wider text-[var(--muted)] font-extrabold">Ruang Belajar</div>
                <a href="{{ route('user.dashboard') }}" class="nav-menu-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large w-5 text-sm text-[var(--blue)]"></i> Dashboard
                </a>
                <a href="{{ route('user.prototypes.create') }}" class="nav-menu-link {{ Route::is('user.prototypes.*') ? 'active' : '' }}">
                    <i class="fas fa-cloud-upload-alt w-5 text-sm text-[var(--blue)]"></i> Upload Prototype AI
                </a>
                <a href="{{ route('modules.index') }}" class="nav-menu-link {{ Route::is('modules.*') ? 'active' : '' }}">
                    <i class="fas fa-book-reader w-5 text-sm text-[var(--blue)]"></i> Modul Dokumentasi
                </a>
                <a href="{{ route('user.courses.index') }}" class="nav-menu-link {{ Route::is('user.courses.index') || Route::is('user.courses.show') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-5 text-sm text-[var(--blue)]"></i> Kursus Katalog
                </a>
                <a href="{{ route('user.my-courses') }}" class="nav-menu-link {{ Route::is('user.my-courses') || Route::is('user.courses.learn') || Route::is('user.courses.content') ? 'active' : '' }}">
                    <i class="fas fa-laptop-code w-5 text-sm text-[var(--blue)]"></i> Kursus Saya
                </a>
                <a href="{{ route('user.transactions.index') }}" class="nav-menu-link {{ Route::is('user.transactions.index') || Route::is('user.balance-history') ? 'active' : '' }}">
                    <i class="fas fa-history w-5 text-sm text-[var(--blue)]"></i> Histori Aktivitas
                </a>
            @endif
            
            <div class="border-t border-[var(--border)] my-3 mx-4"></div>
            <div class="px-5 py-2 text-[10px] uppercase tracking-wider text-[var(--muted)] font-extrabold">Akun</div>
            
            <a href="{{ route('user.profile') }}" class="nav-menu-link {{ Route::is('user.profile') ? 'active' : '' }}">
                <i class="fas fa-user-cog w-5 text-sm text-[var(--blue)]"></i> Pengaturan Profil
            </a>
        </nav>

        <!-- Bottom Sidebar Block (Theme Switcher & Profile avatar card) -->
        <div class="p-4 border-t border-[var(--border)] mt-auto flex flex-col gap-3 bg-[var(--bg3)]">
            <!-- Theme Mode Toggle -->
            <div class="flex items-center justify-between px-2">
                <span class="text-[11px] text-[var(--muted)] font-bold">Tema Tampilan</span>
                <button id="themeToggle" class="switch-theme-btn" aria-label="Toggle Theme">
                    <div class="switch-theme-indicator" id="toggleCircle">
                        <i class="fas fa-sun" id="sunIcon"></i>
                        <i class="fas fa-moon hidden" id="moonIcon"></i>
                    </div>
                </button>
            </div>

            <!-- Profile Info Badge -->
            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white border border-[var(--border)] shadow-sm">
                <img src="{{ auth()->user()->avatar_url }}" 
                     class="w-9 h-9 rounded-full object-cover border border-[var(--border)]" 
                     alt="Avatar">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-[var(--ink)] truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-[var(--muted)] truncate font-mono">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <button type="submit" class="text-[var(--muted)] hover:text-red-600 transition-colors p-1" title="Logout">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Layout System -->
    <div class="main-layout">
        @auth
        <!-- Top Sticky Header -->
        <header class="topbar-header">
            <!-- Sidebar Collapse Buttons & Title -->
            <div class="flex items-center gap-2.5 sm:gap-4 min-w-0 flex-1 mr-2">
                <!-- Desktop Sidebar Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)" 
                        class="hidden md:flex w-9 h-9 items-center justify-center rounded-lg border border-[var(--border)] hover:border-[var(--blue)] hover:text-[var(--blue)] text-[var(--text2)] transition-colors bg-white shadow-sm flex-shrink-0"
                        title="Toggle Sidebar">
                    <i class="fas" :class="sidebarOpen ? 'fa-angle-double-left' : 'fa-angle-double-right'"></i>
                </button>
                
                <!-- Mobile Burger Menu Button -->
                <button @click="mobileSidebarOpen = true" 
                        class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg border border-[var(--border)] text-[var(--text)] bg-white shadow-sm flex-shrink-0"
                        title="Open Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h1 class="text-xs sm:text-sm font-bold text-[var(--ink)] truncate" title="@yield('title', 'Ruang Belajar')">
                    @yield('title', 'Ruang Belajar')
                </h1>
            </div>

            <!-- Topbar Right section -->
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <!-- Theme Toggle Button (Topbar for Mobile & Desktop) -->
                <button id="topbarThemeToggle" class="switch-theme-btn flex-shrink-0" aria-label="Toggle Night Mode" title="Ganti Mode Tampilan (Night / Day)">
                    <div class="switch-theme-indicator">
                        <i class="fas fa-sun topbar-sun"></i>
                        <i class="fas fa-moon topbar-moon hidden"></i>
                    </div>
                </button>
                <a href="{{ route('home') }}" class="text-xs font-bold text-[var(--blue)] bg-[var(--blue-light)] px-3 py-1.5 rounded-lg hover:underline hidden sm:inline-flex items-center gap-1.5 flex-shrink-0">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('user.profile') }}" class="flex items-center justify-center flex-shrink-0 hover:opacity-85 transition-opacity" title="Pengaturan Profil">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         class="w-8 h-8 rounded-full object-cover border-2 border-[var(--blue)] flex-shrink-0 shrink-0 aspect-square" 
                         alt="Avatar">
                </a>
            </div>
        </header>
        @endauth

        <!-- Main Workspace Pane -->
        <main class="main-content">
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="app-alert alert-success" id="globalAlertSuccess">
                    <div class="flex items-center gap-3">
                        <div class="alert-icon-box w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold uppercase tracking-wider opacity-85">Sukses:</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('globalAlertSuccess').remove()" class="opacity-60 hover:opacity-100 transition p-1 text-base leading-none text-current" title="Tutup">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="app-alert alert-error" id="globalAlertError">
                    <div class="flex items-center gap-3">
                        <div class="alert-icon-box w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold uppercase tracking-wider opacity-85">Gagal:</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('globalAlertError').remove()" class="opacity-60 hover:opacity-100 transition p-1 text-base leading-none text-current" title="Tutup">&times;</button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="app-alert alert-error" id="globalAlertValidation">
                    <div class="flex items-start gap-3 w-full">
                        <div class="alert-icon-box w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-bold uppercase tracking-wider opacity-85 mb-1">Perhatian Diperlukan:</div>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" onclick="document.getElementById('globalAlertValidation').remove()" class="opacity-60 hover:opacity-100 transition p-1 text-base leading-none text-current" title="Tutup">&times;</button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer style="background: var(--bg2); border-top: 1px solid var(--border); padding: 24px 0; text-align: center; margin-top: auto;">
            <div class="max-w-[1260px] mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" class="w-5 h-5 object-contain" alt="Logo">
                    <span class="text-xs font-bold text-[var(--ink)]">TalentGroup.id</span>
                </div>
                <p class="text-xs text-[var(--muted)] font-mono">
                    &copy; {{ date('Y') }} TalentGroup.id. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </footer>
    </div>

    <!-- Theme Mode Switching Script -->
    <script>
        (function() {
            function updateThemeUI(isDark) {
                if (isDark) {
                    document.body.classList.add('dark');
                    document.documentElement.classList.add('dark');
                    document.querySelectorAll('.topbar-sun, #sunIcon').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.topbar-moon, #moonIcon').forEach(el => el.classList.remove('hidden'));
                } else {
                    document.body.classList.remove('dark');
                    document.documentElement.classList.remove('dark');
                    document.querySelectorAll('.topbar-sun, #sunIcon').forEach(el => el.classList.remove('hidden'));
                    document.querySelectorAll('.topbar-moon, #moonIcon').forEach(el => el.classList.add('hidden'));
                }
            }

            const savedTheme = localStorage.getItem('theme') || 'light';
            updateThemeUI(savedTheme === 'dark');

            function initThemeButtons() {
                const toggles = [
                    document.getElementById('themeToggle'),
                    document.getElementById('topbarThemeToggle')
                ].filter(Boolean);

                toggles.forEach(btn => {
                    btn.onclick = function(e) {
                        e.preventDefault();
                        const isCurrentlyDark = document.documentElement.classList.contains('dark') || document.body.classList.contains('dark');
                        const nextDark = !isCurrentlyDark;
                        updateThemeUI(nextDark);
                        localStorage.setItem('theme', nextDark ? 'dark' : 'light');
                    };
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initThemeButtons);
            } else {
                initThemeButtons();
            }
        })();
    </script>

    <!-- Auto-save and draft persistence for all forms and images -->
    <script src="{{ asset('assets/js/form-draft-autosave.js') }}"></script>
</body>

</html>
