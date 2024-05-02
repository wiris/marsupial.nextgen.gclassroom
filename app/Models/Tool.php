<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Tool extends Model
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'oidc_initiation_url',
        'jwks_url',
        'target_link_uri',
        'redirect_uris',
        'deep_link_url'
    ];

    public function deployments(): HasMany
    {
        return $this->hasMany(ToolDeployment::class);
    }
}
