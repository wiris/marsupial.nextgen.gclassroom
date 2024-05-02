<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Material;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create(
            [
                'email' => 'pol.torrent@wiris.com',
                'role' => 'admin'
            ]
        );

        $tool = Tool::factory()->create([
            'title' => 'WirisQuizzes kitchen demo',
            'description' => fake()->text(),
            'oidc_initiation_url' => 'https://quizzeslti.wiris.kitchen/demo.wiris.com/enrol/quizzeslti/login.php',
            'jwks_url' => 'https://quizzeslti.wiris.kitchen/demo.wiris.com/enrol/quizzeslti/jwks.php',
            'target_link_uri' => 'https://quizzeslti.wiris.kitchen/demo.wiris.com/enrol/quizzeslti/tool.php',
            'redirect_uris' => json_encode(['https://quizzeslti.wiris.kitchen/demo.wiris.com/enrol/quizzeslti/tool.php'])
        ]);

        $deployment = $tool->deployments()->create();

        $material = Material::factory()->create([
            'title' => fake()->title(),
            'description' => fake()->text(),
            'custom_claim' => json_encode(['id' => 2393]),
            'user_id' => $user->id,
            'tool_deployment_id' => $deployment->id,
            'course_id' => '277230768630',
            'coursework_id' => 'afkjdokfao'
        ]);
    }
}
