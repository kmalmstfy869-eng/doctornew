<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFileBackup extends Model
{
    // سجل داخلي بيكتبه الـ Backup Service بس، فمفيش mass-assignment من المستخدم.
    protected $guarded = [];

    protected $casts = [
        'backed_up_at' => 'datetime',
        'source_deleted_at' => 'datetime',
        'size' => 'integer',
    ];
}
