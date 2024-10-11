<?php

namespace App\Models;

use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timesheet extends Model
{
    use HasFactory, Paginatable;

    protected $table = 'timesheets';

    protected $fillable = [
        'client_id',
        'user_id',
        'month',
        'date',
        'month_number',
        'service_id',
        'current_hourly_rate',
        'hours',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public static function getTotalHoursForUserInCompany(int $userId, int $companyId): int
    {
        return self::where('user_id', $userId)
                   ->where('client_id', $companyId)
                   ->sum('hours');
    }


}
