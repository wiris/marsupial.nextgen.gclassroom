<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'custom_claim',
        'course_id',
        'coursework_id',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toolDeployment(): BelongsTo
    {
        return $this->belongsTo(ToolDeployment::class);
    }

    public function lineitems(): HasMany
    {
        return $this->hasMany(Lineitem::class);
    }
}
