<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Meet') }}
        </h2>
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
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card-body">
                        <form action="{{ route('meet.store') }}" method="POST" class="col-md-13">
                            @csrf
                            <div>
                                <x-label for="name" :value="__('Name')" />
                                <x-input id="name" class="block mt-1 w-full @error('name') is-invalid @enderror" type="text" name="name" :value="old('name')" required autofocus />
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <x-label for="description" :value="__('Description')" />
                                <x-input id="description" class="block mt-1 w-full @error('description') is-invalid @enderror" type="text" name="description" :value="old('description')" required />
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <x-label for="time_from" :value="__('From')" />
                                <x-input id="time_from" class="block mt-1 w-full @error('time_from') is-invalid @enderror" type="datetime-local" name="time_from" :value="old('time_from')" required />
                                @error('time_from')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <x-label for="time_to" :value="__('To')" />
                                <x-input id="time_to" class="block mt-1 w-full @error('time_to') is-invalid @enderror" type="datetime-local" name="time_to" :value="old('time_to')" required />
                                @error('time_to')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="participant" class="col-sm-2 col-form-label">{{ __('Participant')}}</label>
                                <div class="col-sm-200">
                                    <select
                                        style="width: 200px"
                                        multiple
                                        name="participant[]"
                                        class="block mt-1 w-full @error('participant') is-invalid @enderror">
                                        @foreach($users ?? [] as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
