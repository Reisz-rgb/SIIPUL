<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LeaveHistoryImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'CT 2024' => new LeaveSheetImport('CT 2024'),
            'CT 2025' => new LeaveSheetImport('CT 2025'),
            'CT 2026' => new LeaveSheetImport('CT 2026'),
        ];
    }
}