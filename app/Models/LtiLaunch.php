<?php

namespace App\Models;

use App\Enums\LaunchType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LtiLaunch extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'launch_type' => LaunchType::class
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toolDeployment(): BelongsTo
    {
        return $this->belongsTo(ToolDeployment::class);
    }
}
