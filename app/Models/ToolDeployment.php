<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToolDeployment extends Model
{
    use HasFactory, HasUuids;

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
