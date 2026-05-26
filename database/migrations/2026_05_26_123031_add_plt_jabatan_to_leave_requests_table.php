<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Support\SafeMigration;

class AddPltJabatanToLeaveRequestsTable extends SafeMigration
{
    public function up(): void
    {
        $this->safeAddColumn('leave_requests', 'plt_jabatan', function (Blueprint $table) {
            $table->string('plt_jabatan')->nullable()->after('supervisor_id');
        });
    }

    public function down(): void
    {
        $this->safeDropColumns('leave_requests', ['plt_jabatan']);
    }
}
