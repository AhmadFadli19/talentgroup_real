<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Daftar Siswa TalentGroup</title>
    <style>
        @page { margin: 24px 26px 34px; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #0b2447; font-family: "DejaVu Sans", sans-serif; font-size: 8px; }
        .header { border-bottom: 3px solid #0757b8; margin-bottom: 14px; padding-bottom: 10px; }
        .brand { color: #0757b8; font-size: 18px; font-weight: 800; letter-spacing: -.4px; }
        .brand span { color: #f97316; }
        h1 { font-size: 15px; margin: 8px 0 2px; }
        .meta { color: #64748b; font-size: 8px; }
        .filter { margin-top: 7px; padding: 6px 8px; border: 1px solid #d5deee; background: #f8fafc; color: #334155; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        th { padding: 7px 5px; background: #0757b8; color: #fff; border: 1px solid #0757b8; font-size: 7px; text-align: left; text-transform: uppercase; }
        td { padding: 6px 5px; border: 1px solid #d5deee; vertical-align: top; line-height: 1.35; word-wrap: break-word; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .center { text-align: center; }
        .strong { font-weight: 700; }
        .muted { color: #64748b; }
        .status { font-size: 7px; font-weight: 700; }
        .footer { position: fixed; right: 0; bottom: -22px; left: 0; color: #64748b; font-size: 7px; text-align: center; }
        .empty { padding: 28px; text-align: center; color: #64748b; }
    </style>
</head>
<body>
    <div class="footer">Dokumen resmi TalentGroup.id • Dicetak {{ $generatedAt->format('d-m-Y H:i') }} WIB</div>

    <div class="header">
        <div class="brand">Talent<span>Group</span>.id</div>
        <h1>Daftar Siswa TalentGroup</h1>
        <div class="meta">Total data: {{ number_format($students->count()) }} siswa</div>

        @if($selectedCourse || $search !== '' || $status !== '')
            <div class="filter">
                <strong>Filter aktif:</strong>
                @if($selectedCourse) Kursus “{{ $selectedCourse->title }}” @endif
                @if($search !== '') {{ $selectedCourse ? ' • ' : '' }}Pencarian “{{ $search }}” @endif
                @if($status !== '')
                    {{ ($selectedCourse || $search !== '') ? ' • ' : '' }}Status
                    {{ match($status) {
                        'learning' => 'sedang belajar',
                        'completed' => 'pernah menyelesaikan',
                        'no_course' => 'belum ikut kursus',
                        'google' => 'daftar via Google',
                        default => $status,
                    } }}
                @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%" class="center">No.</th>
                <th style="width: 14%">Nama / Username</th>
                <th style="width: 19%">Kontak</th>
                <th style="width: 10%">Bergabung</th>
                <th style="width: 8%" class="center">Kursus</th>
                <th style="width: 8%" class="center">Selesai</th>
                <th style="width: 12%">Status</th>
                <th style="width: 25%">Daftar Kursus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php
                    $courseNames = $student->userCourses->pluck('course.title')->filter()->unique()->values()->implode(', ');
                    $learningStatus = $student->courses_count === 0
                        ? 'Belum mengikuti kursus'
                        : ($student->completed_courses_count === $student->courses_count
                            ? 'Semua kursus selesai'
                            : 'Aktif belajar');
                @endphp
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>
                        <div class="strong">{{ $student->name }}</div>
                        <div class="muted">@{{ $student->username }}</div>
                    </td>
                    <td>
                        <div>{{ $student->email }}</div>
                        <div class="muted">{{ $student->phone ?: 'Telepon belum diisi' }}</div>
                    </td>
                    <td>{{ $student->created_at?->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') ?? '-' }}</td>
                    <td class="center strong">{{ $student->courses_count }}</td>
                    <td class="center strong">{{ $student->completed_courses_count }}</td>
                    <td>
                        <div class="status">{{ $learningStatus }}</div>
                        <div class="muted">{{ $student->google_id ? 'Google' : 'Email & Password' }}</div>
                    </td>
                    <td>{{ $courseNames !== '' ? $courseNames : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">Tidak ada siswa yang sesuai dengan filter.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
