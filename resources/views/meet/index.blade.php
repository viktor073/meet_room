<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Meets') }}
            <br>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card-body">
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-responsive-nav-link :href="route('meet.index', ['week' => $week - 1])">
                                {{ __('Back') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('meet.index', ['week' => $week + 1])">
                                {{ __('Next') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('meet.index')">
                                {{ __('Current Week') }}
                            </x-responsive-nav-link>
                        </div>
                        <table style="width: 100%; table-layout: fixed; white-space: nowrap; overflow: hidden;">
                            <thead>
                            <tr>
                                <th scope="col"> </th>
                                @foreach ($dates as $date)
                                    <th scope="col">{{ $date['name'] }} <br> {{ $date['date'] }} </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $meetIds = [];
                            @endphp
                            @foreach ($minutes as $minute)
                                <tr>
                                    <th scope="row">
                                        {{ $minute }}
                                    </th>
                                    @foreach ($dates as $date)
                                        @if(count($meets))
                                            @if (isset($meets[strtotime($date['date'] . $minute)]))
                                                @php
                                                    $meet = $meets[strtotime($date['date'] . $minute)]
                                                @endphp
                                                <td bgcolor="#deb887" style="width: 100%; table-layout: fixed; white-space: nowrap; overflow: hidden;">
                                                    @if(!in_array($meet->getId(), $meetIds))
                                                        <a class="nav-link" href="{{ route('meet.show', $meet)}}">{{ $meet->getName() }}</a><br>
                                                        @foreach ($meet->participants as $participant)
                                                            {{ $participant->name }} <br>
                                                        @endforeach
                                                    @endif
                                                    @php
                                                        $meetIds[$meet->getId()] = $meet->getId();
                                                    @endphp
                                                </td>
                                            @else
                                                <td> </td>
                                            @endif
                                        @else
                                            <td> </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>>
