<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = User::firstOrCreate(['email' => 'pol.torrent@wiris.com']);
        $admin->role = 'admin';
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', '=', 'pol.torrent@wiris.com')->delete();
    }
};
