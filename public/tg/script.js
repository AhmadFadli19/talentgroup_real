'use strict';

// Vanilla JavaScript. All interactions work locally; no backend or credentials.
const $ = (selector, root = document) => root.querySelector(selector);
const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];
const storage = {
  get(key, fallback) { try { return JSON.parse(localStorage.getItem(key)) ?? fallback; } catch { return fallback; } },
  set(key, value) { try { localStorage.setItem(key, JSON.stringify(value)); return true; } catch { return false; } }
};
const escapeHTML = value => String(value ?? '').replace(/[&<>"']/g, ch => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[ch]));
let toastTimer;
function toast(message) {
  const el = $('#toast');
  clearTimeout(toastTimer);
  el.textContent = message;
  el.hidden = false;
  toastTimer = setTimeout(() => { el.hidden = true; }, 4500);
}

const dialog = $('#detail-dialog');
let dialogAction = null;
function showDialog(title, message, actionLabel = 'Tutup', action = null) {
  $('#dialog-title').textContent = title;
  $('#dialog-body').replaceChildren();
  const p = document.createElement('p');
  p.textContent = message;
  $('#dialog-body').append(p);
  $('#dialog-primary').textContent = actionLabel;
  dialogAction = action;
  dialog.showModal();
}
$('.dialog-close').addEventListener('click', () => dialog.close());
$('#dialog-primary').addEventListener('click', () => { dialog.close(); if (dialogAction) dialogAction(); });
dialog.addEventListener('click', event => { if (event.target === dialog) { const r = dialog.getBoundingClientRect(); if (event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom) dialog.close(); } });

const dashboardRoutes = new Set(['kelas', 'pertanyaan', 'upload', 'review']);
function route() {
  const id = decodeURIComponent(location.hash.slice(1) || 'home');
  const inDashboard = dashboardRoutes.has(id);
  $('#landing-view').hidden = inDashboard;
  $('#dashboard-view').hidden = !inDashboard;
  $$('.dashboard-page').forEach(page => { page.hidden = page.id !== `page-${id}`; });
  $$('.sidebar nav a').forEach(link => {
    const selected = link.dataset.page === (id === 'review' ? 'upload' : id);
    link.classList.toggle('active', selected);
    if (selected) link.setAttribute('aria-current', 'page'); else link.removeAttribute('aria-current');
  });
  $$('#site-nav a').forEach(link => {
    const selected = link.hash === `#${id}`;
    link.classList.toggle('active', selected);
    if (selected) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current');
  });
  $('#site-nav').classList.remove('open');
  $('.menu-toggle').setAttribute('aria-expanded', 'false');
  document.title = inDashboard ? `${({kelas:'Kelas',pertanyaan:'Pertanyaan',upload:'Upload Prototype',review:'Hasil Review'})[id]} — TalentGroup.id` : 'TalentGroup.id — Raih Ilmu, Kuasai Kode.';
  if (inDashboard) {
    window.scrollTo(0, 0);
    $('#dashboard-main').focus({ preventScroll: true });
  } else {
    requestAnimationFrame(() => document.getElementById(id)?.scrollIntoView({ behavior: 'instant' }));
  }
}
window.addEventListener('hashchange', route);
$('.menu-toggle').addEventListener('click', () => {
  const expanded = $('#site-nav').classList.toggle('open');
  $('.menu-toggle').setAttribute('aria-expanded', String(expanded));
});

$$('[data-module]').forEach(button => button.addEventListener('click', () => {
  const module = button.dataset.module;
  showDialog(`Modul ${module}`, module === 'Figma' ? 'Modul Figma ditandai selesai pada desain. Tautan video dan slide belum disertakan dalam file Figma. Kamu bisa melanjutkan diskusi melalui halaman Pertanyaan.' : 'Modul Web sedang dalam proses pada desain. Tautan video dan slide belum disertakan dalam file Figma. Gunakan halaman Pertanyaan untuk mencoba alur diskusi.', 'Buka Pertanyaan', () => { location.hash = 'pertanyaan'; });
}));
$$('[data-course]').forEach(button => button.addEventListener('click', () => {
  const free = button.dataset.course === 'ssda';
  showDialog(button.dataset.course, free ? 'Kelas gratis · 1 materi · Semua level. Buka ruang belajar untuk melihat dua modul yang tersedia dalam desain.' : 'Kelas premium · 4 materi · Semua level · Rp 99.000. Informasi mengikuti desain Figma. Pembayaran belum tersedia pada demo ini.', 'Lihat Ruang Belajar', () => { location.hash = 'kelas'; });
}));
$$('.carousel-arrow').forEach(button => button.addEventListener('click', () => {
  const track = $('#course-track');
  if (track.scrollWidth <= track.clientWidth) {
    const cards = $$('.course-card', track);
    if (button.classList.contains('next')) track.append(cards[0]); else track.prepend(cards[cards.length - 1]);
  } else {
    track.scrollBy({ left: (button.classList.contains('next') ? 1 : -1) * 340, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' });
  }
}));
$$('[data-info]').forEach(button => button.addEventListener('click', () => showDialog(button.dataset.info, 'Tautan tujuan belum disertakan di desain Figma. Bagian ini sudah disiapkan agar dapat dihubungkan ke halaman yang sesuai.')));
$('#newsletter-form').addEventListener('submit', event => { event.preventDefault(); toast('Email valid. Layanan newsletter belum terhubung pada demo ini.'); });
$('#challenge-form').addEventListener('submit', event => {
  event.preventDefault();
  const answer = $('#challenge-answer').value.trim();
  const correct = answer === 'Hello, World!' || answer === 'Hello, World';
  $('#game-output').textContent = `$ ${answer}`;
  $('#challenge-feedback').textContent = correct ? '✓ Benar! Tantangan selesai.' : "Coba lagi: tulis Hello, World! sesuai instruksi tantangan.";
  $('#challenge-feedback').style.color = correct ? 'var(--green)' : '#a66a00';
  if (correct) $('.challenge-code').innerHTML = '<span>&lt;?php</span><br><b>echo</b> <em>"Hello, World!"</em>;';
});

const seedQuestions = [
  {id:'q1',title:'Kenapa := tidak bisa dipakai di luar function?',detail:'Saya coba deklarasi total := 0 di level package, tapi muncul error "non-declaration statement outside function body". Apa bedanya dengan var?',module:'Modul 02',category:'Variabel',author:'Aulia',time:'5 jam lalu',votes:14,answer:'Operator := hanya berlaku di dalam function. Di level package gunakan var total = 0 atau var total int. Detail lengkap ada di menit 11:20 video modul ini.',answerTime:'2 jam lalu'},
  {id:'q2',title:'Kapan sebaiknya pakai int vs int64?',detail:'Di materi disebut ada banyak tipe integer. Untuk kasus umum (hitung stok, umur) mana yang dipakai?',module:'Modul 02',category:'Tipe Data',author:'Bagas',time:'1 hari lalu',votes:8,answer:'Gunakan int untuk kebutuhan umum. Pakai int64 hanya saat butuh ukuran pasti, misalnya ID database atau timestamp.',answerTime:'6 jam lalu'},
  {id:'q3',title:'Apakah zero value string itu null?',detail:'Saya pikir variabel string tanpa nilai akan bernilai null seperti di bahasa lain.',module:'Modul 02',category:'Variabel',author:'Nadia',time:'20 menit lalu',votes:3,answer:null}
];
let ownQuestions = storage.get('tg.questions.v1', []);
if (!Array.isArray(ownQuestions)) ownQuestions = [];
ownQuestions = ownQuestions.filter(q => q && typeof q.id === 'string' && typeof q.title === 'string' && typeof q.detail === 'string').slice(0, 100);
let voted = storage.get('tg.votes.v1', []);
if (!Array.isArray(voted)) voted = [];
const votes = new Set(voted.filter(v => typeof v === 'string'));
let activeFilter = 'all';
function renderQuestions() {
  const all = [...ownQuestions, ...seedQuestions];
  const selected = all.filter(q => activeFilter === 'answered' ? Boolean(q.answer) : activeFilter === 'unanswered' ? !q.answer : activeFilter === 'mine' ? q.mine : true);
  const list = $('#question-list');
  list.innerHTML = selected.map(q => `<article class="question-card"><button class="vote-button" data-vote="${escapeHTML(q.id)}" aria-label="Dukung pertanyaan: ${escapeHTML(q.title)}" aria-pressed="${votes.has(q.id)}"><span aria-hidden="true">▲</span><b>${Number(q.votes || 0) + Number(votes.has(q.id))}</b><small>suara</small></button><div class="question-content"><div class="question-top"><h2>${escapeHTML(q.title)}</h2><span class="pill ${q.answer ? 'success-outline' : 'pending'}">${q.answer ? 'Terjawab' : 'Menunggu jawaban'}</span></div><p>${escapeHTML(q.detail)}</p><div class="question-tags"><span class="pill">${escapeHTML(q.module)}</span>${q.category && q.id !== 'q3' ? `<span class="pill">${escapeHTML(q.category)}</span>` : ''}<span class="question-author">${escapeHTML(q.author)} · ${escapeHTML(q.time)}</span></div>${q.answer ? `<div class="answer"><span class="avatar">AF</span><div><div class="answer-head"><strong>Ahmad Fadli</strong><span class="pill blue-soft">Tutor</span><time>${escapeHTML(q.answerTime)}</time></div><p>${escapeHTML(q.answer)}</p></div></div>` : ''}</div></article>`).join('');
  if (!selected.length) list.innerHTML = '<div class="empty-state">Belum ada pertanyaan di kategori ini.</div>';
  $('#question-total').textContent = String(42 + ownQuestions.length);
  $$('[data-vote]', list).forEach(button => button.addEventListener('click', () => {
    const id = button.dataset.vote;
    votes.has(id) ? votes.delete(id) : votes.add(id);
    storage.set('tg.votes.v1', [...votes]);
    renderQuestions();
    const replacement = $$('[data-vote]', list).find(el => el.dataset.vote === id);
    replacement?.focus({ preventScroll:true });
  }));
}
$$('[data-filter]').forEach(button => button.addEventListener('click', () => {
  activeFilter = button.dataset.filter;
  $$('[data-filter]').forEach(b => { b.classList.toggle('selected', b === button); b.setAttribute('aria-pressed', String(b === button)); });
  renderQuestions();
}));
$('#question-form').addEventListener('submit', event => {
  event.preventDefault();
  const title = $('#question-title').value.trim();
  const detail = $('#question-detail').value.trim();
  if (!title || !detail) { toast('Isi judul dan detail pertanyaan terlebih dahulu.'); return; }
  ownQuestions.unshift({ id:`own-${Date.now()}-${Math.random().toString(36).slice(2,7)}`, title, detail, module:$('#question-module').value, category:$('#question-category').value, author:'Kamu', time:'baru saja', votes:0, answer:null, mine:true });
  ownQuestions = ownQuestions.slice(0,100);
  const saved = storage.set('tg.questions.v1', ownQuestions);
  $('#question-form').reset();
  $('[data-filter="all"]').click();
  toast(saved ? 'Pertanyaan tersimpan di browser ini. Belum dikirim ke tutor.' : 'Pertanyaan ditambahkan untuk sesi ini. Penyimpanan browser tidak tersedia.');
});

let selectedFile = null;
const fileInput = $('#prototype-file');
function acceptFile(file) {
  $('#prototype-error').textContent = '';
  if (!file) return;
  if (!file.name.toLowerCase().endsWith('.zip')) { selectedFile = null; fileInput.value = ''; $('#file-label').textContent = 'Tarik file ke sini atau klik untuk memilih'; $('#prototype-error').textContent = 'Pilih file ZIP yang berisi index.html, CSS, dan JavaScript.'; return; }
  if (file.size > 20 * 1024 * 1024) { selectedFile = null; fileInput.value = ''; $('#file-label').textContent = 'Tarik file ke sini atau klik untuk memilih'; $('#prototype-error').textContent = 'Ukuran file melebihi batas 20 MB.'; return; }
  selectedFile = file;
  $('#file-label').textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
}
fileInput.addEventListener('change', () => acceptFile(fileInput.files[0]));
const dropzone = $('#dropzone');
['dragenter','dragover'].forEach(name => dropzone.addEventListener(name, event => { event.preventDefault(); dropzone.classList.add('dragging'); }));
['dragleave','drop'].forEach(name => dropzone.addEventListener(name, event => { event.preventDefault(); dropzone.classList.remove('dragging'); }));
dropzone.addEventListener('drop', event => { acceptFile(event.dataTransfer.files[0]); });
function slugify(value) { return value.toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'').slice(0,45).replace(/-$/,''); }
let customSlug = false;
$('#prototype-name').addEventListener('input', () => { if (!customSlug) $('#prototype-slug').value = slugify($('#prototype-name').value); });
$('#prototype-slug').addEventListener('input', () => { customSlug = true; });
const prototypeFields = ['repo','name','stack','description','slug'];
const draft = storage.get('tg.prototype-draft.v1', null);
if (draft && typeof draft === 'object' && !Array.isArray(draft)) prototypeFields.forEach(name => { if (typeof draft[name] === 'string') $(`#prototype-${name}`).value = draft[name]; });
$('#save-draft').addEventListener('click', () => {
  const values = Object.fromEntries(prototypeFields.map(name => [name,$(`#prototype-${name}`).value]));
  toast(storage.set('tg.prototype-draft.v1', values) ? 'Draf tersimpan di browser ini. File ZIP perlu dipilih ulang setelah halaman ditutup.' : 'Draf tidak dapat disimpan karena penyimpanan browser tidak tersedia.');
});
$('#prototype-form').addEventListener('submit', event => {
  event.preventDefault();
  const error = $('#prototype-error');
  error.textContent = '';
  const repo = $('#prototype-repo').value.trim();
  if (!selectedFile && !repo) { error.textContent = 'Pilih file ZIP atau isi link repository GitHub.'; return; }
  if (repo) {
    try { const url = new URL(repo); if (url.protocol !== 'https:' || url.hostname !== 'github.com' || url.pathname.split('/').filter(Boolean).length < 2) throw new Error(); }
    catch { error.textContent = 'Gunakan link repository publik dengan format https://github.com/username/nama-repo.'; return; }
  }
  if (!$('#prototype-name').value.trim() || !$('#prototype-description').value.trim()) { error.textContent = 'Isi nama dan deskripsi prototype.'; return; }
  showDialog('Prototype siap untuk ditinjau', 'Data form sudah valid. Demo ini tidak mengunggah file, menjalankan review AI, atau memublikasikan situs. Kamu bisa melihat contoh halaman hasil review sesuai desain Figma.', 'Lihat Contoh Review', () => { location.hash = 'review'; });
});

function copyExampleURL() {
  const value = 'https://smartkasir.flowacademy.fun';
  if (navigator.clipboard?.writeText) navigator.clipboard.writeText(value).then(() => toast('Alamat contoh disalin. Situs belum dipublikasikan dari demo ini.')).catch(() => showDialog('Alamat contoh prototype', value));
  else showDialog('Alamat contoh prototype', value);
}
$('#copy-example-url').addEventListener('click', copyExampleURL);
$('#share-example').addEventListener('click', copyExampleURL);
$('#open-example').addEventListener('click', () => showDialog('Pratinjau SmartKasir', 'SmartKasir dan alamat di halaman ini merupakan contoh dari desain Figma. Belum ada prototype yang benar-benar dipublikasikan dari demo ini.'));
renderQuestions();
route();
