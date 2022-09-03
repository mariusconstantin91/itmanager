@foreach($entity->skills as $skill)
    @switch($skill->pivot->importance)
        @case(App\Models\Skill::LOWEST)
            <div
                class="mr-2 mb-1 flex items-center justify-center rounded-md border border-blue-300 bg-blue-100 px-1 py-1 pt-0 text-sm font-normal text-blue-500">
                <div
                    class="max-w-full flex-initial text-sm font-normal leading-none">
                    {{ $skill->name }}</div>
            </div>
            @break    
        @case(App\Models\Skill::LOW)
            <div
                class="mr-2 mb-1 flex items-center justify-center rounded-md border border-gray-300 bg-gray-100 px-1 py-1 pt-0 text-sm font-normal text-gray-500">
                <div
                    class="max-w-full flex-initial text-sm font-normal leading-none">
                    {{ $skill->name }}</div>
            </div>
            @break
        
        @case(App\Models\Skill::MEDIUM)
            <div
                class="mr-2 mb-1 flex items-center justify-center rounded-md border border-yellow-300 bg-yellow-100 px-1 py-1 pt-0 text-sm font-normal text-yellow-500">
                <div
                    class="max-w-full flex-initial text-sm font-normal leading-none">
                    {{ $skill->name }}</div>
            </div>
            @break
        @case(App\Models\Skill::HIGH)
            <div
                class="mr-2 mb-1 flex items-center justify-center rounded-md border border-orange-300 bg-orange-100 px-1 py-1 pt-0 text-sm font-normal text-orange-500">
                <div
                    class="max-w-full flex-initial text-sm font-normal leading-none">
                    {{ $skill->name }}</div>
            </div>
            @break
        @case(App\Models\Skill::HIGHEST)
            <div
                class="mr-2 mb-1 flex items-center justify-center rounded-md border border-red-300 bg-red-100 px-1 py-1 pt-0 text-sm font-normal text-red-500">
                <div
                    class="max-w-full flex-initial text-sm font-normal leading-none">
                    {{ $skill->name }}</div>
            </div>
            @break
        @default
    @endswitch
@endforeach