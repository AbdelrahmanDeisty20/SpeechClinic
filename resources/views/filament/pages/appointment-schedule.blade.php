<x-filament-panels::page>
    <div class="space-y-4">
        <div class="p-4 bg-white rounded-lg shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <form wire:submit.prevent="submit">
                {{ $this->form }}
            </form>
        </div>

        @php
            $schedule = $this->getScheduleData();
            $specialists = $schedule['specialists'];
            $times = $schedule['times'];
            $matrix = $schedule['matrix'];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center text-sm">
                <thead>
                    <tr class="bg-[#d37332] text-white">
                        <th class="border border-white p-2">/</th>
                        @foreach($specialists as $specialist)
                            <th class="border border-white p-2 min-w-[120px]">
                                {{ $specialist->full_name }}
                            </th>
                        @endforeach
                        <th class="border border-white p-2">/</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($times as $time)
                        <tr>
                            {{-- Time Col --}}
                            <td class="bg-[#d37332] text-white border border-white p-2 font-bold">
                                {{ \Carbon\Carbon::parse($time)->format('g') }}
                            </td>

                            {{-- Data Cells --}}
                            @foreach($specialists as $specialist)
                                <td class="border border-gray-300 p-2 h-16 bg-white dark:bg-gray-800 dark:text-white dark:border-gray-600">
                                    @php
                                        $childName = $matrix[$time][$specialist->id] ?? null;
                                    @endphp
                                    
                                    @if($childName)
                                        <div class="font-bold">
                                            {{ $childName }}
                                        </div>
                                    @else
                                        <span class="text-gray-200">-</span>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Right Time Col --}}
                            <td class="bg-[#d37332] text-white border border-white p-2 font-bold">
                                {{ \Carbon\Carbon::parse($time)->format('g') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
