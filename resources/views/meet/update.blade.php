@php
    /** @var \App\Interface\Meet\Data\MeetInterface $meet */
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Meet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @isset($meet, $users)
                        <form action="{{ route('meet.update', $meet) }}" method="POST" class="col-md-13">
                            @csrf
                            @method('PUT')
                            <div>
                                <x-label for="id" :value="__('ID')" />
                                <x-input
                                    id="id"
                                    class="block mt-1 w-full @error('id') is-invalid @enderror"
                                    type="text" name="id"
                                    :disabled="true"
                                    value="{{ $meet->getId() }}"
                                    required
                                />
                                @error('id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-label for="name" :value="__('Name')" />
                                <x-input
                                    id="name"
                                    class="block mt-1 w-full @error('name') is-invalid @enderror"
                                    type="text" name="name"
                                    value="{{ $meet->getName() }}"
                                    required
                                />
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-label for="description" :value="__('Description')" />
                                <x-input
                                    id="description"
                                    class="block mt-1 w-full @error('description') is-invalid @enderror"
                                    type="text" name="description"
                                    value="{{$meet->getDescription()}}"
                                    required
                                />
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-label for="time_from" :value="__('From')" />
                                <x-input
                                    id="time_from"
                                    class="block mt-1 w-full @error('time_from') is-invalid @enderror"
                                    type="datetime-local" name="time_from"
                                    :value="$meet->getTimeFrom()"
                                    required
                                />
                                @error('time_from')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-label for="time_to" :value="__('To')" />
                                <x-input
                                    id="time_to"
                                    class="block mt-1 w-full @error('time_to') is-invalid @enderror"
                                    type="datetime-local" name="time_to"
                                    :value="$meet->getTimeTo()"
                                    required
                                />
                                @error('time_to')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="participant_ids" class="col-sm-2 col-form-label">{{ __('Participants')}}</label>
                                <div class="col-sm-10">
                                    <select style="width: 200px" multiple name="participant_ids[]" class="@error('participant_ids') is-invalid @enderror">>
                                        @foreach($users ?? [] as $user)
                                            <option
                                                value="{{ $user['id'] }}"
                                                @if (in_array($user['id'], $meet->getParticipantIds()))
                                                    selected
                                                @endif
                                            >
                                                {{ $user['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('participant')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br><br>
                            <x-button>
                                {{ __('Save') }}
                            </x-button>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
