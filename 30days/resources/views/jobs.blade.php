<x-layout>
    <x-slot:heading>
        Job listings
    </x-slot:heading>
    <ul>
        @foreach ($jobs as $job)
            <li>
                <a href="/jobs/{{ $job['id'] }}">
                    <strong>{{ $job['title'] }}:</strong> Pays {{ $job['salary'] }} per year
                </a>
            </li>
        @endforeach
    </ul>
</x-layout>
