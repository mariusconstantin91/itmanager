<ul>
    @foreach($entity->contacts as $contact)
        <li x-data="{open: false}" @click="open = ! open" class="cursor-pointer text-blue-800 mb-1">
            <div>
                <span class="font-bold">{{ $contact->name }},</span> {{ $contact->position }}: {{ $contact->email }}, {{ $contact->phone }}
                @if ($contact->main_contact)
                    <span class="font-bold"> (Main contact) </span>   
                @endif
            </div>
            <div x-show="open" x-cloak class="text-black-100">
                <ul>
                    <li>
                        <span class="font-bold">Country:</span> {{ $contact->country->name }} 
                    </li>
                    <li>
                        <span class="font-bold">City:</span> {{ $contact->city }} 
                    </li>
                    <li>    
                        <span class="font-bold">Postal code:</span> {{ $contact->postalcode }} 
                    </li>
                    <li>
                        <span class="font-bold">Address line 1:</span> {{ $contact->address_line_1 }} 
                    </li>
                    <li>
                        <span class="font-bold">Address line 2:</span> {{ $contact->address_line_2 }} 
                    </li>
                </ul>
            </div>
        </li>
    @endforeach
</ul>
