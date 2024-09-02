<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'salary_per_hour',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['roles', 'companies', 'services'];

    /**
     * Get the address for this user.
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return bool
     */
    public function hasPassed2FA(): bool
    {
        return Cache::get('2fa-' . request()->session()->getId()) ?? false;
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withPivot('cost_per_hour');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class, 'user_id');
    }

    public function totalCostForCompany($companyId, $year)
    {
        return $this->timesheets()
                    ->where('company_id', $companyId)
                    ->whereBetween('date', [
                        "{$year}-01-01",
                        "{$year}-12-31"
                    ])
                    ->get()
                    ->reduce(function ($carry, $timesheet) {
//                        $serviceUser = DB::table('service_user')
//                                         ->where('user_id', $timesheet->user_id)
//                                         ->where('service_id', $timesheet->service_id)
//                                         ->first();
//                        $hourlyRate  = $serviceUser->cost_per_hour ?? 0;
                        $hourlyRate  = $timesheet->current_hourly_rate;
                        $cost        = $timesheet->hours * $hourlyRate;
                        return $carry + $cost;
                    }, 0);
    }


    public function totalHoursForCompany($companyId, $year)
    {
        return $this->timesheets()
                    ->where('company_id', $companyId)
                    ->whereBetween('date', [
                        "{$year}-01-01",
                        "{$year}-12-31"
                    ])
                    ->sum('hours');
    }
}
