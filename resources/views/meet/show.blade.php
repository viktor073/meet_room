@php
    /** @var \App\Interface\Meet\Data\MeetInterface $meet */
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Info of Meet') }}
            <br>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-success" role="error">
                    {{ session('error') }}
                </div>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card-body">
                        @isset($meet)
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <x-responsive-nav-link :href="route('meet.edit', $meet)" :active="request()->routeIs('meet.edit')">
                                    {{ __('Edit') }}
                                </x-responsive-nav-link>
                            </div>

                            <table class="table table-primary">
                                <tbody>
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <td>{{ $meet->getId() }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <td>{{ $meet->getName() }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <td>{{ $meet->getDescription() }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">{{ __('Start Date Time') }}</th>
                                    <td>{{ $meet->getTimeFrom() }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">{{ __('End Date Time') }}</th>
                                    <td>{{ $meet->getTimeTo() }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">{{ __('Participants') }}</th>
                                    <td>
                                        @foreach($meet->getParticipants() as $participant)
                                            {{ $participant->name }}
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                                <br>
                            <form action="{{ route('meet.destroy', $meet) }}" method="POST" class="col-md-13">
                                @method('DELETE')
                                @csrf

                                <x-button>
                                    {{ __('Delete Meet') }}
                                </x-button>
                            </form>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
