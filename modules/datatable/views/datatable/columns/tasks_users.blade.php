<ul>
    @foreach($entity->users as $user)
        <li>
            {{ $user->name }}
        </li>
    @endforeach
</ul>
