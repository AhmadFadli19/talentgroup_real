<?php

namespace App\Services;

use Illuminate\Support\Collection;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class StudentSpreadsheetExporter
{
    public function download(Collection $students, string $filename): BinaryFileResponse
    {
        $temporaryPath = tempnam(sys_get_temp_dir(), 'talentgroup_students_');

        if ($temporaryPath === false) {
            throw new RuntimeException('Gagal membuat berkas sementara untuk ekspor Excel.');
        }

        $zip = new ZipArchive;
        if ($zip->open($temporaryPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Gagal membuat berkas Excel.');
        }

        $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
        $zip->addFromString('_rels/.rels', $this->rootRelationshipsXml());
        $zip->addFromString('xl/workbook.xml', $this->workbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelationshipsXml());
        $zip->addFromString('xl/styles.xml', $this->stylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->worksheetXml($students));
        $zip->close();

        return response()
            ->download($temporaryPath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0',
            ])
            ->deleteFileAfterSend(true);
    }

    private function worksheetXml(Collection $students): string
    {
        $headings = [
            'No.',
            'Nama Siswa',
            'Username',
            'Email',
            'Nomor Telepon',
            'Metode Daftar',
            'Verifikasi Email',
            'Tanggal Bergabung',
            'Total Kursus',
            'Kursus Selesai',
            'Status Belajar',
            'Daftar Kursus',
        ];

        $rows = [$headings];

        foreach ($students->values() as $index => $student) {
            $courseNames = $student->userCourses
                ->pluck('course.title')
                ->filter()
                ->unique()
                ->values()
                ->implode(', ');

            $rows[] = [
                (string) ($index + 1),
                $student->name,
                $student->username,
                $student->email,
                $student->phone ?: '-',
                $student->google_id ? 'Google' : 'Email & Password',
                $student->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi',
                $student->created_at?->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') ?: '-',
                (string) $student->courses_count,
                (string) $student->completed_courses_count,
                $this->learningStatus($student),
                $courseNames !== '' ? $courseNames : '-',
            ];
        }

        $sheetRows = '';
        foreach ($rows as $rowIndex => $row) {
            $excelRow = $rowIndex + 1;
            $cells = '';

            foreach ($row as $columnIndex => $value) {
                $coordinate = $this->columnName($columnIndex + 1).$excelRow;
                $style = $rowIndex === 0 ? ' s="1"' : '';
                $escaped = htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
                $cells .= '<c r="'.$coordinate.'" t="inlineStr"'.$style.'><is><t xml:space="preserve">'
                    .$escaped
                    .'</t></is></c>';
            }

            $height = $rowIndex === 0 ? ' ht="25" customHeight="1"' : '';
            $sheetRows .= '<row r="'.$excelRow.'"'.$height.'>'.$cells.'</row>';
        }

        $lastRow = max(1, count($rows));

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
            .'<cols>'
            .'<col min="1" max="1" width="7" customWidth="1"/>'
            .'<col min="2" max="2" width="26" customWidth="1"/>'
            .'<col min="3" max="3" width="20" customWidth="1"/>'
            .'<col min="4" max="4" width="32" customWidth="1"/>'
            .'<col min="5" max="5" width="19" customWidth="1"/>'
            .'<col min="6" max="7" width="19" customWidth="1"/>'
            .'<col min="8" max="8" width="20" customWidth="1"/>'
            .'<col min="9" max="10" width="15" customWidth="1"/>'
            .'<col min="11" max="11" width="22" customWidth="1"/>'
            .'<col min="12" max="12" width="48" customWidth="1"/>'
            .'</cols>'
            .'<sheetData>'.$sheetRows.'</sheetData>'
            .'<autoFilter ref="A1:L'.$lastRow.'"/>'
            .'</worksheet>';
    }

    private function learningStatus($student): string
    {
        if ((int) $student->courses_count === 0) {
            return 'Belum mengikuti kursus';
        }

        if ((int) $student->completed_courses_count === (int) $student->courses_count) {
            return 'Semua kursus selesai';
        }

        if ((int) $student->completed_courses_count > 0) {
            return 'Aktif belajar';
        }

        return 'Terdaftar di kursus';
    }

    private function columnName(int $number): string
    {
        $name = '';
        while ($number > 0) {
            $number--;
            $name = chr(65 + ($number % 26)).$name;
            $number = intdiv($number, 26);
        }

        return $name;
    }

    private function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>'
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            .'</Types>';
    }

    private function rootRelationshipsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            .'</Relationships>';
    }

    private function workbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="Daftar Siswa" sheetId="1" r:id="rId1"/></sheets>'
            .'</workbook>';
    }

    private function workbookRelationshipsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            .'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            .'</Relationships>';
    }

    private function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font></fonts>'
            .'<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF0757B8"/><bgColor indexed="64"/></patternFill></fill></fills>'
            .'<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            .'<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            .'<cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment vertical="center"/></xf></cellXfs>'
            .'</styleSheet>';
    }
}
