<style>
    [data-quiz-protected] {
        -webkit-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
    }

    [data-quiz-protected] img {
        -webkit-user-drag: none !important;
        user-drag: none !important;
        pointer-events: none;
    }

    #quiz-security-shield {
        position: fixed;
        inset: 0;
        z-index: 2147483647;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: #000;
        color: #fff;
        text-align: center;
        cursor: pointer;
    }

    #quiz-security-shield.active {
        display: flex !important;
    }

    #quiz-security-toast {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 2147483646;
        max-width: min(360px, calc(100vw - 40px));
        padding: 12px 16px;
        border: 1px solid #f59e0b;
        border-radius: 12px;
        background: #111827;
        color: #fef3c7;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .35);
        font-size: 12px;
        font-weight: 700;
        opacity: 0;
        transform: translateY(16px);
        pointer-events: none;
        transition: opacity .18s ease, transform .18s ease;
    }

    #quiz-security-toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    @media print {
        html,
        body {
            background: #000 !important;
        }

        body * {
            display: none !important;
            visibility: hidden !important;
        }

        #quiz-security-shield {
            display: block !important;
            visibility: visible !important;
            background: #000 !important;
            color: #000 !important;
        }
    }
</style>

<div id="quiz-security-shield" role="alert" aria-live="assertive">
    <div>
        <i class="fas fa-shield-halved text-3xl mb-3"></i>
        <p class="text-sm font-extrabold">Tampilan latihan disembunyikan untuk melindungi soal.</p>
        <p class="mt-1 text-xs text-slate-300">Kembali ke halaman ini lalu klik untuk melanjutkan.</p>
    </div>
</div>
<div id="quiz-security-toast" role="status" aria-live="polite"></div>

<script>
(() => {
    'use strict';

    const shield = document.getElementById('quiz-security-shield');
    const toast = document.getElementById('quiz-security-toast');
    let toastTimer;

    const showToast = (message) => {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(() => toast.classList.remove('show'), 3200);
    };

    const isProtectedNode = (node) => {
        const element = node instanceof Element ? node : node?.parentElement;
        return Boolean(element?.closest('[data-quiz-protected]'));
    };

    const hasProtectedSelection = () => {
        const selection = window.getSelection?.();
        return Boolean(selection && (isProtectedNode(selection.anchorNode) || isProtectedNode(selection.focusNode)));
    };

    const blackout = (message = 'Tangkapan layar, perekaman, dan pencetakan dinonaktifkan pada latihan.') => {
        if (!shield) return;
        shield.classList.add('active');
        shield.setAttribute('aria-hidden', 'false');
        window.getSelection?.().removeAllRanges();
        showToast(message);
    };

    const restore = () => {
        if (document.hidden || !shield) return;
        shield.classList.remove('active');
        shield.setAttribute('aria-hidden', 'true');
    };

    shield?.addEventListener('click', restore);
    shield?.addEventListener('touchstart', restore, { passive: true });

    ['copy', 'cut', 'contextmenu', 'dragstart'].forEach((eventName) => {
        document.addEventListener(eventName, (event) => {
            if (!isProtectedNode(event.target) && !hasProtectedSelection()) return;
            event.preventDefault();
            event.stopPropagation();
            window.getSelection?.().removeAllRanges();
            showToast('Isi latihan tidak dapat disalin atau diunduh.');
        }, true);
    });

    document.addEventListener('keydown', (event) => {
        const key = String(event.key || '').toLowerCase();
        const command = event.ctrlKey || event.metaKey;
        const protectedAction = isProtectedNode(event.target) || hasProtectedSelection();
        const screenshotShortcut =
            event.key === 'PrintScreen' || event.code === 'PrintScreen' ||
            (event.metaKey && event.shiftKey && ['3', '4', '5', 's'].includes(key)) ||
            (event.ctrlKey && event.shiftKey && key === 's');

        if (screenshotShortcut) {
            event.preventDefault();
            event.stopImmediatePropagation();
            blackout();
            return;
        }

        if (event.key === 'F12' || (command && event.shiftKey && ['i', 'j', 'c'].includes(key))) {
            event.preventDefault();
            event.stopImmediatePropagation();
            showToast('Developer tools dinonaktifkan selama latihan.');
            return;
        }

        if (command && ['p', 's', 'u'].includes(key)) {
            event.preventDefault();
            event.stopImmediatePropagation();
            blackout('Mencetak, menyimpan, dan melihat sumber halaman dinonaktifkan.');
            return;
        }

        if (protectedAction && command && ['a', 'c', 'x'].includes(key)) {
            event.preventDefault();
            event.stopImmediatePropagation();
            window.getSelection?.().removeAllRanges();
            showToast('Teks soal dan pilihan jawaban tidak dapat disalin.');
        }
    }, true);

    window.addEventListener('beforeprint', () => blackout('Pencetakan dan simpan PDF dinonaktifkan.'));
    window.addEventListener('blur', () => blackout());
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) blackout();
    });
    window.addEventListener('pagehide', () => blackout());
})();
</script>
