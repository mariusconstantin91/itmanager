<div
    x-cloak
    class="table-layout"
>
    {{-- Table --}}
    <table class="table">
        @if (isset($thead))
            <thead {{ $tbody->attributes->class(['table-head']) }}>
                {{ $thead }}
            </thead>
        @endif

        @if (isset($tbody))
            <tbody {{ $tbody->attributes->class(['table-body']) }}>
                {{ $tbody }}
            </tbody>
        @endif

        @if (isset($tfoot))
            <tbody {{ $tfoot->attributes->class(['table-head']) }}>
                {{ $tfoot }}
            </tbody>
        @endif
    </table>
</div>
