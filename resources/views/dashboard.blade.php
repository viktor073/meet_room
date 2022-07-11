<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-responsive-nav-link :href="route('meet.create')" :active="request()->routeIs('meet.create')">
                            {{ __('Add Meet') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('meet.index')" :active="request()->routeIs('meet.index')">
                            {{ __('View Meets') }}
                        </x-responsive-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
