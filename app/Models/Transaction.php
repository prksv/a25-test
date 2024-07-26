<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ["employee_id", "hours", "paid"];

    protected $attributes = [
        "paid" => false,
    ];

    protected $casts = [
        "paid" => "boolean",
    ];

    public function scopeUnpaid(Builder $query): void
    {
        $query->where("paid", false);
    }

    public function scopePaid(Builder $query): void
    {
        $query->where("paid", true);
    }

    public static function getTotalHours(): Collection
    {
        return self::unpaid()
            ->groupBy("employee_id")
            ->select([
                DB::raw("CAST(SUM(hours) as UNSIGNED) as total_hours"),
                "employee_id",
            ])
            ->pluck("total_hours", "employee_id");
    }
}
