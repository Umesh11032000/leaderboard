<div class="w-full max-w-lg">
    <!-- Recalculate Button -->
    <div class="flex justify-center mb-4">
        <button class="px-4 py-2 bg-gray-300 text-black rounded-lg font-semibold hover:bg-gray-400"
            wire:click="recalculate">Recalculate</button>
    </div>

    <!-- User ID Input and Filter Button -->
    <div class="flex items-center justify-center gap-2 mb-6">
        <input type="text" placeholder="User ID" wire:model="userId"
            class="w-100 px-2 py-2 bg-gray-900 text-white border border-gray-600 rounded-lg focus:outline-none">
        <button class="px-4 py-2 bg-gray-300 text-black rounded-lg font-semibold hover:bg-gray-400"
            wire:click="filterByUser">Filter</button>
    </div>

    <!-- Sort By Dropdown -->
    <div class="flex justify-center items-center mb-4">
        <span class="mr-2">Sort by</span>
        <select class="px-2 py-2 bg-gray-900 text-white border border-gray-600 rounded-lg focus:outline-none"
            wire:model="sortBy" wire:change="setPeriod($event.target.value)">
            @foreach (\App\Enums\Period::choices() as $periodValue => $periodName)
                <option value="{{ $periodValue }}">{{ $periodName }}</option>
            @endforeach
        </select>
    </div>

    <!-- Leaderboard Table -->
    <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-4 py-3 font-semibold text-gray-400">ID</th>
                    <th class="px-4 py-3 font-semibold text-gray-400">Name</th>
                    <th class="px-4 py-3 font-semibold text-gray-400">Points</th>
                    <th class="px-4 py-3 font-semibold text-gray-400">Rank</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example rows -->
                @foreach ($leaderboards as $leaderboard)
                    <tr
                        class="border-b border-gray-700 {{ $leaderboard->user_id == $highlightUserId ? 'bg-gray-700' : '' }}">
                        <td class="px-4 py-3">{{ $leaderboard->user_id }}</td>
                        <td class="px-4 py-3">{{ $leaderboard->user->name }}</td>
                        <td class="px-4 py-3">{{ $leaderboard->points }}</td>
                        <td class="px-4 py-3">#{{ $leaderboard->rank }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
