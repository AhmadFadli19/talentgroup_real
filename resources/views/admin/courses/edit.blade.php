@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')

<style>
/* ================= PIXEL COURSE EDIT ================= */
.pixel-edit-container {
    max-width: 900px;
    margin: 0 auto;
}

/* HEADER */
.pixel-edit-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

.pixel-back-btn {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 6px 8px;
    box-shadow: 3px 3px 0 var(--shadow);
}

.pixel-back-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-edit-title h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-edit-title p {
    font-size: 9px;
    color: var(--muted);
}

/* CARD */
.pixel-edit-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 6px 6px 0 var(--shadow);
    padding: 24px;
    max-width: 600px;
}

/* FIELD */
.pixel-field {
    margin-bottom: 16px;
}

.pixel-field label {
    display: block;
    font-size: 9px;
    margin-bottom: 6px;
    color: var(--muted);
}

.pixel-input,
.pixel-textarea,
.pixel-file {
    width: 100%;
    background: var(--bg);
    border: 3px solid var(--border);
    padding: 12px;
    font-size: 10px;
    color: var(--text);
    outline: none;
}

.pixel-textarea {
    resize: vertical;
}

.pixel-input:focus,
.pixel-textarea:focus,
.pixel-file:focus {
    border-color: var(--accent);
}

/* IMAGE PREVIEW */
.pixel-image-preview {
    margin-bottom: 10px;
}

.pixel-image-preview img {
    width: 140px;
    height: 90px;
    object-fit: cover;
    border: 3px solid var(--border);
}

/* CHECKBOX */
.pixel-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 9px;
    color: var(--muted);
}

.pixel-checkbox input {
    width: 16px;
    height: 16px;
    accent-color: var(--accent);
}

/* ERROR */
.pixel-error {
    border: 2px solid #ff5555;
    background: #2a0000;
    color: #ffb3b3;
    padding: 8px;
    font-size: 9px;
    margin-top: 6px;
}

/* ACTIONS */
.pixel-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.pixel-btn {
    font-size: 9px;
    padding: 10px 14px;
    border: 3px solid;
    box-shadow: 4px 4px 0 var(--shadow);
}

.pixel-btn.cancel {
    background: var(--bg);
    border-color: var(--border);
    color: var(--muted);
}

.pixel-btn.save {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

.pixel-btn:hover {
    transform: translate(-2px,-2px);
    box-shadow: 6px 6px 0 var(--shadow);
}

/* RESPONSIVE */
@media (max-width: 640px) {
    .pixel-edit-card {
        padding: 18px;
    }
}
</style>

<div class="pixel-edit-container">

    <!-- HEADER -->
    <div class="pixel-edit-header">
        <a href="{{ route('admin.courses.index') }}" class="pixel-back-btn">
            ◀
        </a>

        <div class="pixel-edit-title">
            <h1>EDIT COURSE</h1>
            <p>Perbarui detail course English Brain</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="pixel-edit-card">

        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- TITLE -->
            <div class="pixel-field">
                <label>COURSE TITLE</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $course->title) }}"
                    required
                    class="pixel-input @error('title') border-red-500 @enderror"
                >
                @error('title')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- DESCRIPTION -->
            <div class="pixel-field">
                <label>DESCRIPTION</label>
                <textarea
                    name="description"
                    rows="4"
                    required
                    class="pixel-textarea @error('description') border-red-500 @enderror"
                >{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- PRICE -->
            <div class="pixel-field">
                <label>PRICE (Rp)</label>
                <input
                    type="number"
                    name="price"
                    min="0"
                    step="1000"
                    value="{{ old('price', $course->price) }}"
                    required
                    class="pixel-input @error('price') border-red-500 @enderror"
                >
                @error('price')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- IMAGE -->
            <div class="pixel-field">
                <label>COURSE IMAGE</label>

                @if($course->image)
                    <div class="pixel-image-preview">
                         <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        <p style="font-size:8px;color:var(--muted)">Current image</p>
                    </div>
                @endif

                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="pixel-file @error('image') border-red-500 @enderror"
                >
                <p style="font-size:8px;color:var(--muted);margin-top:6px">
                    Kosongkan jika tidak ingin mengganti gambar (max 2MB)
                </p>

                @error('image')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- ACTIVE -->
            <div class="pixel-field">
                <label>STATUS</label>
                <div class="pixel-checkbox">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $course->is_active) ? 'checked' : '' }}
                    >
                    <span>Aktifkan course (visible ke user)</span>
                </div>
                @error('is_active')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- ACTIONS -->
            <div class="pixel-actions">
                <a href="{{ route('admin.courses.index') }}" class="pixel-btn cancel">
                    CANCEL
                </a>
                <button type="submit" class="pixel-btn save">
                    UPDATE
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
