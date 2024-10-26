<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $wantToCreateNew = confirm(
            label: 'Create new users?',
            default: true,
            yes: 'Yes please',
            no: 'No, thanks',
            hint: 'If you want to create new users, you can do it now.',
        );

        if ($wantToCreateNew) {
            info('Creating new users...');
            User::factory()->count(50)->create();
        } else {
            info('Skipping creating new users.');
        }

        // Create activities
        foreach (User::all() as $user) {
            $numActivities = rand(1, 10); // Each user can have between 1 and 10 activities
            for ($i = 0; $i < $numActivities; $i++) {
                UserActivity::create([
                    'user_id' => $user->id,
                    'points' => 20,
                    'activated_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
            }
        }
        info('Activities created.');

        // Recalculate leaderboard
        info('Recalculating leaderboard...');
        Artisan::call('app:recalculate-leaderboard-command');
    }
}
