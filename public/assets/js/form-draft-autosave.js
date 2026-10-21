/**
 * Universal Form Draft & Image Preview Persistence
 * flowacademy / talentgroup
 * 
 * Ensures all form data (text, textareas, selects, checkboxes, image previews)
 * persists across page reloads / refreshes and is automatically restored.
 */

(function () {
    'use strict';

    const STORAGE_PREFIX = 'flow_draft_';

    function getStorageKey(form) {
        const formId = form.id || form.getAttribute('name') || form.getAttribute('action') || 'form';
        return STORAGE_PREFIX + window.location.pathname + '_' + formId;
    }

    function getFileStorageKey(form, inputName) {
        return getStorageKey(form) + '_file_' + inputName;
    }

    // Save form data into localStorage (debounced)
    let saveTimeouts = {};

    function saveFormData(form) {
        const key = getStorageKey(form);
        clearTimeout(saveTimeouts[key]);

        saveTimeouts[key] = setTimeout(() => {
            const formData = {};
            const elements = form.elements;

            for (let i = 0; i < elements.length; i++) {
                const el = elements[i];
                if (!el.name || el.type === 'password' || el.type === 'hidden' && el.name === '_token' || el.type === 'hidden' && el.name === '_method') {
                    continue;
                }

                if (el.type === 'checkbox') {
                    formData[el.name] = el.checked;
                } else if (el.type === 'radio') {
                    if (el.checked) {
                        formData[el.name] = el.value;
                    }
                } else if (el.type === 'file') {
                    // Files handled separately via FileReader
                } else {
                    formData[el.name] = el.value;
                }
            }

            try {
                localStorage.setItem(key, JSON.stringify(formData));
                showAutoSaveIndicator(form, 'Tersimpan otomatis');
            } catch (err) {
                console.warn('Draft save error:', err);
            }
        }, 300);
    }

    // Show indicator on form
    function showAutoSaveIndicator(form, text) {
        let indicator = form.querySelector('.autosave-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.className = 'autosave-indicator';
            indicator.style.cssText = 'position: fixed; bottom: 16px; left: 16px; background: rgba(15, 23, 42, 0.95); border: 1px solid rgba(56, 189, 248, 0.3); color: #38bdf8; font-size: 11px; font-family: monospace; padding: 6px 12px; border-radius: 8px; z-index: 99999; box-shadow: 0 4px 12px rgba(0,0,0,0.5); display: flex; align-items: center; gap: 6px; transition: opacity 0.3s ease; pointer-events: none; opacity: 0;';
            indicator.innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i> <span class="autosave-msg"></span>';
            document.body.appendChild(indicator);
        }

        const msgSpan = indicator.querySelector('.autosave-msg');
        if (msgSpan) msgSpan.textContent = text;
        indicator.style.opacity = '1';

        clearTimeout(indicator._timer);
        indicator._timer = setTimeout(() => {
            indicator.style.opacity = '0';
        }, 2000);
    }

    // Handle file inputs: preview + persist in sessionStorage
    function setupFileInputPersistence(form, fileInput) {
        const fileKey = getFileStorageKey(form, fileInput.name);

        // Create or find preview container
        let previewBox = form.querySelector(`.file-draft-preview[data-for="${fileInput.name}"]`);
        if (!previewBox) {
            previewBox = document.createElement('div');
            previewBox.className = 'file-draft-preview mt-3';
            previewBox.setAttribute('data-for', fileInput.name);
            fileInput.parentNode.insertBefore(previewBox, fileInput.nextSibling);
        }

        // Restore saved file preview if exists
        try {
            const savedFileData = sessionStorage.getItem(fileKey);
            if (savedFileData) {
                const parsed = JSON.parse(savedFileData);
                if (parsed && parsed.dataUrl) {
                    renderPreviewBox(previewBox, parsed.dataUrl, parsed.name, form, fileKey);
                }
            }
        } catch (e) {}

        // Listen for user selecting a file
        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (!file) return;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const dataUrl = e.target.result;
                    try {
                        // Store thumbnail / preview in sessionStorage
                        sessionStorage.setItem(fileKey, JSON.stringify({
                            name: file.name,
                            size: file.size,
                            type: file.type,
                            dataUrl: dataUrl
                        }));
                    } catch (err) {
                        // If quota exceeded, store metadata only
                        sessionStorage.setItem(fileKey, JSON.stringify({
                            name: file.name,
                            size: file.size,
                            type: file.type
                        }));
                    }
                    renderPreviewBox(previewBox, dataUrl, file.name, form, fileKey);
                };
                reader.readAsDataURL(file);
            } else {
                renderNonImagePreview(previewBox, file.name);
            }
        });
    }

    function renderPreviewBox(container, dataUrl, fileName, form, fileKey) {
        container.innerHTML = `
            <div class="p-3 rounded-xl bg-slate-900 border border-cyan-500/30 flex items-center gap-3">
                <img src="${dataUrl}" class="w-12 h-12 object-cover rounded-lg border border-slate-700 shadow-md">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-white truncate">${fileName || 'Preview Gambar'}</div>
                    <div class="text-[10px] text-cyan-400 font-mono">Tersimpan di draft (aman saat refresh)</div>
                </div>
                <button type="button" class="btn-clear-file-draft px-2 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-[10px]">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        const clearBtn = container.querySelector('.btn-clear-file-draft');
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                container.innerHTML = '';
                sessionStorage.removeItem(fileKey);
            });
        }
    }

    function renderNonImagePreview(container, fileName) {
        container.innerHTML = `
            <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-700 text-xs text-slate-300 flex items-center gap-2">
                <i class="fas fa-file text-cyan-400"></i>
                <span class="truncate">${fileName}</span>
            </div>
        `;
    }

    // Restore text / options form data on page load
    function restoreFormData(form) {
        const key = getStorageKey(form);
        const savedRaw = localStorage.getItem(key);
        if (!savedRaw) return;

        let formData = null;
        try {
            formData = JSON.parse(savedRaw);
        } catch (e) {
            return;
        }

        if (!formData || typeof formData !== 'object') return;

        let restoredCount = 0;
        const elements = form.elements;

        for (let i = 0; i < elements.length; i++) {
            const el = elements[i];
            if (!el.name || !(el.name in formData)) continue;

            const val = formData[el.name];

            if (el.type === 'checkbox') {
                if (el.checked !== val) {
                    el.checked = val;
                    restoredCount++;
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            } else if (el.type === 'radio') {
                if (el.value === val && !el.checked) {
                    el.checked = true;
                    restoredCount++;
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            } else if (el.type !== 'file' && el.type !== 'password' && el.type !== 'submit') {
                // If input is currently empty or default, restore saved value
                if (val && el.value !== val) {
                    // Only restore if user hasn't typed something else or if default
                    el.value = val;
                    restoredCount++;
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        }

        if (restoredCount > 0) {
            showRestoredBanner(form, key);
        }
    }

    function showRestoredBanner(form, storageKey) {
        if (form.querySelector('.draft-restored-banner')) return;

        const banner = document.createElement('div');
        banner.className = 'draft-restored-banner mb-4 p-3 rounded-xl bg-cyan-950/40 border border-cyan-500/40 text-cyan-300 text-xs flex items-center justify-between gap-3 shadow-lg';
        banner.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-cyan-400 text-sm"></i>
                <span><strong>Draft Dipulihkan:</strong> Data yang Anda ketik sebelumnya tetap tersimpan saat halaman di-refresh.</span>
            </div>
            <button type="button" class="btn-clear-entire-draft px-2.5 py-1 rounded bg-slate-900 hover:bg-slate-800 text-slate-400 hover:text-white text-[11px] font-semibold border border-slate-700 transition">
                Reset Draft
            </button>
        `;

        form.insertBefore(banner, form.firstChild);

        const resetBtn = banner.querySelector('.btn-clear-entire-draft');
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                localStorage.removeItem(storageKey);
                banner.remove();
                form.reset();
            });
        }
    }

    // Clear draft when form is successfully submitted
    function clearFormDraft(form) {
        const key = getStorageKey(form);
        localStorage.removeItem(key);

        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(fi => {
            sessionStorage.removeItem(getFileStorageKey(form, fi.name));
        });
    }

    // Initialize auto-save on all forms
    function initAutoSave() {
        // Target all forms in admin area, user profile, course and module forms
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            // Ignore search-only or logout-only forms
            if (form.classList.contains('no-autosave') || form.getAttribute('action') && form.getAttribute('action').includes('logout')) {
                return;
            }

            // Listen to inputs
            form.addEventListener('input', () => saveFormData(form));
            form.addEventListener('change', () => saveFormData(form));

            // Setup file inputs
            const fileInputs = form.querySelectorAll('input[type="file"]');
            fileInputs.forEach(fi => setupFileInputPersistence(form, fi));

            // Restore data on load
            restoreFormData(form);

            // Clear draft when form is submitted
            form.addEventListener('submit', function () {
                clearFormDraft(form);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoSave);
    } else {
        initAutoSave();
    }

})();
