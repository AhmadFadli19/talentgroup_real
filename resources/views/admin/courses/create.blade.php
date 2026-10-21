@extends('layouts.app')

@section('title', 'Create Course')

@section('content')

<style>
/* ================= PIXEL CREATE COURSE ================= */
.pixel-create {
    max-width: 900px;
    margin: 0 auto;
}

/* HEADER */
.pixel-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

.pixel-back {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 6px 8px;
    box-shadow: 3px 3px 0 var(--shadow);
}

.pixel-back:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-header h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-header p {
    font-size: 9px;
    color: var(--muted);
}

/* CARD */
.pixel-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 20px;
}

/* FORM */
.pixel-group {
    margin-bottom: 16px;
}

.pixel-label {
    font-size: 9px;
    color: var(--muted);
    display: block;
    margin-bottom: 6px;
}

.pixel-input,
.pixel-textarea,
.pixel-file {
    width: 100%;
    background: var(--bg);
    border: 3px solid var(--border);
    padding: 10px;
    font-size: 10px;
}

.pixel-input:focus,
.pixel-textarea:focus,
.pixel-file:focus {
    outline: none;
    border-color: var(--accent);
}

.pixel-textarea {
    min-height: 90px;
    resize: vertical;
}

.pixel-hint {
    font-size: 8px;
    color: var(--muted);
    margin-top: 4px;
}

.pixel-error {
    font-size: 8px;
    color: #ff5555;
    margin-top: 4px;
}

/* CHECKBOX */
.pixel-check {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 9px;
}

/* ACTIONS */
.pixel-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.pixel-btn {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 8px 14px;
    font-size: 9px;
}

.pixel-btn.primary {
    background: var(--accent);
    color: #fff;
}

.pixel-btn:hover {
    border-color: var(--accent);
}

/* RESPONSIVE */
@media(max-width:640px){
    .pixel-actions {
        flex-direction: column;
    }
}
</style>

<div class="pixel-create">

    <!-- HEADER -->
    <div class="pixel-header">
        <a href="{{ route('admin.courses.index') }}" class="pixel-back">◀</a>
        <div>
            <h1>CREATE NEW COURSE</h1>
            <p>Build a new English Brain course</p>
        </div>
    </div>

    <!-- FORM -->
    <div class="pixel-card">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TITLE -->
            <div class="pixel-group">
                <label class="pixel-label">COURSE TITLE</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="pixel-input @error('title') border-red-500 @enderror"
                       placeholder="e.g. Basic English Vocabulary">
                @error('title')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- DESCRIPTION -->
            <div class="pixel-group">
                <label class="pixel-label">DESCRIPTION</label>
                <textarea name="description" required
                          class="pixel-textarea @error('description') border-red-500 @enderror"
                          placeholder="Describe what users will learn">{{ old('description') }}</textarea>
                @error('description')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- PRICE -->
            <div class="pixel-group">
                <label class="pixel-label">PRICE (Rp)</label>
                <input type="number" name="price" min="0" step="1000"
                       value="{{ old('price', 0) }}" required
                       class="pixel-input @error('price') border-red-500 @enderror">
                @error('price')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- IMAGE -->
            <div class="pixel-group">
                <label class="pixel-label">COURSE IMAGE</label>
                <input type="file" name="image" accept="image/*"
                       class="pixel-file @error('image') border-red-500 @enderror">
                <div class="pixel-hint">PNG, JPG, JPEG, GIF • Max 2MB</div>
                @error('image')
                    <div class="pixel-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- ACTIVE -->
            <div class="pixel-group pixel-check">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active') ? 'checked' : '' }}>
                <span>Make course active (visible to users)</span>
            </div>

            <!-- ACTIONS -->
            <div class="pixel-actions">
                <a href="{{ route('admin.courses.index') }}" class="pixel-btn">
                    CANCEL
                </a>
                <button type="submit" class="pixel-btn primary">
                    CREATE COURSE
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
