<?php

namespace App\Livewire;

use App\Enums\Period;
use App\Models\Leaderboard as ModelsLeaderboard;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class LeaderBoard extends Component
{
    public Period $period;
    public $userId = null;
    public $highlightUserId = null;

    public function mount()
    {
        $this->period = request()->has('period') ? Period::fromValue(request('period')) : Period::default();
    }

    public function filterByUser()
    {
        $this->userId = $this->highlightUserId = $this->userId;
    }


    public function setPeriod($period)
    {
        $this->period = Period::fromValue($period);
    }

    public function recalculate()
    {
        Artisan::call('app:recalculate-leaderboard-command');
    }

    public function render()
    {
        $leaderboards = ModelsLeaderboard::query()
            ->orderBy('points', 'desc')
            ->with('user')->where('period', $this->period)
            ->get();

        if ($this->userId) {
            // Move to 1st place by sortBy to this USER
            $leaderboards = $leaderboards->reject(function($value){
                return $value->user_id == $this->userId;
            })->prepend($leaderboards->firstWhere('user_id', $this->userId));
        }

        $highlightUserId = $this->highlightUserId;
        return view('livewire.leader-board', compact('leaderboards', 'highlightUserId'));
    }
}
