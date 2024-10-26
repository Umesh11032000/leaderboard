<?php

namespace App\Console\Commands;

use App\Enums\Period;
use App\Models\Leaderboard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;

class RecalculateLeaderboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recalculate-leaderboard-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate the leaderboard.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $periods = Period::toArray();

        // Truncate the leaderboard table
        Leaderboard::truncate();

        foreach ($periods as $period) {
            $leaderboards = User::withSum(['activities as total_points' => function ($query) use ($period) {
                $query->whereBetween('activated_at', $period->range());
            }], 'points')
                ->orderByDesc('total_points')
                ->get();

            $leaderboardArr = [];
            $previousPoints = 0;
            $rank = 0;

            foreach ($leaderboards as $leaderboard) {
                if ($leaderboard->total_points !== $previousPoints) {
                    $previousPoints = $leaderboard->total_points;
                    $rank++;
                }

                $leaderboardArr[] = [
                    'rank' => $rank,
                    'points' => $leaderboard->total_points ?? 0,
                    'user_id' => $leaderboard->id,
                    'period' => $period,
                ];
            }

            // Insert leaderboard data in bulk
            Leaderboard::insert($leaderboardArr);
        }
    }
}
