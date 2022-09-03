<div class="flex flex-wrap">
    @foreach($entities as $entity)
        @switch($entity->pivot->importance)
            @case(App\Models\Skill::LOWEST)
                <div
                    wire:key="{{ class_basename($entity) }}-{{ $entity->id }}"
                    class="mr-2 mb-1 flex items-center justify-center rounded-md border border-blue-300 bg-blue-100 px-1 py-1 pt-0 text-sm font-normal text-blue-500 w-fit">
                    <div
                        class="max-w-full flex-initial text-sm font-normal leading-none">
                        {{ $entity->name}} - Lowest</div>
                </div>
                @break    
            @case(App\Models\Skill::LOW)
                <div
                    wire:key="{{ class_basename($entity) }}-{{ $entity->id }}"
                    class="mr-2 mb-1 flex items-center justify-center rounded-md border border-gray-300 bg-gray-100 px-1 py-1 pt-0 text-sm font-normal text-gray-500 w-fit">
                    <div
                        class="max-w-full flex-initial text-sm font-normal leading-none">
                        {{ $entity->name }} - Low</div>
                </div>
                @break
            
            @case(App\Models\Skill::MEDIUM)
                <div
                    class="mr-2 mb-1 flex items-center justify-center rounded-md border border-yellow-300 bg-yellow-100 px-1 py-1 pt-0 text-sm font-normal text-yellow-500 w-fit">
                    <div
                        wire:key="{{ class_basename($entity) }}-{{ $entity->id }}"
                        class="max-w-full flex-initial text-sm font-normal leading-none">
                        {{ $entity->name }} - Medium</div>
                </div>
                @break
            @case(App\Models\Skill::HIGH)
                <div
                    class="mr-2 mb-1 flex items-center justify-center rounded-md border border-orange-300 bg-orange-100 px-1 py-1 pt-0 text-sm font-normal text-orange-500 w-fit">
                    <div
                        wire:key="{{ class_basename($entity) }}-{{ $entity->id }}"
                        class="max-w-full flex-initial text-sm font-normal leading-none">
                        {{ $entity->name }} - High</div>
                </div>
                @break
            @case(App\Models\Skill::HIGHEST)
                <div
                    class="mr-2 mb-1 flex items-center justify-center rounded-md border border-red-300 bg-red-100 px-1 py-1 pt-0 text-sm font-normal text-red-500 w-fit">
                    <div
                        wire:key="{{ class_basename($entity) }}-{{ $entity->id }}"
                        class="max-w-full flex-initial text-sm font-normal leading-none">
                        {{ $entity->name }} - Highest</div>
                </div>
                @break
            @default
        @endswitch
    @endforeach
</div>