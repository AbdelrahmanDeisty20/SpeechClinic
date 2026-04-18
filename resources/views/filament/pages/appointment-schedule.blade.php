<x-filament-panels::page>
    <div class="space-y-4">
        {{-- High Contrast Filter Section --}}
        <div class="p-4 bg-white rounded-xl shadow-sm border-2 border-[#d37332] dark:bg-gray-800">
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

        <div class="relative overflow-hidden rounded-xl border border-gray-400 bg-white shadow-lg dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-400 text-center text-sm min-w-[1000px]">
                    <thead>
                        <tr class="bg-[#d37332] text-white">
                            @foreach($specialists as $specialist)
                                <th class="border border-white p-3 min-w-[150px] font-black">
                                    <div class="flex flex-col items-center justify-center">
                                        {{ $specialist->full_name }}
                                    </div>
                                </th>
                            @endforeach
                            <th class="w-20 bg-[#d37332] text-white p-3 font-black text-lg border border-white">
                                {{ __('Time') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($times as $time)
                            <tr class="hover:bg-orange-50/50 transition-colors">
                                {{-- Session Cells --}}
                                @foreach($specialists as $specialist)
                                    <td class="border border-gray-400 p-2 h-24 bg-white dark:bg-gray-900">
                                        @php
                                            $childName = $matrix[$time][$specialist->id] ?? null;
                                        @endphp
                                        
                                        @if($childName)
                                            <div class="font-bold text-[#d37332] border-2 border-[#d37332] bg-orange-50 p-3 rounded-lg text-[14px] leading-tight shadow-sm dark:bg-orange-900/40 dark:text-white">
                                                {{ $childName }}
                                            </div>
                                        @else
                                            <div class="text-gray-100 italic">...</div>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Right Time Label --}}
                                <td class="bg-[#d37332] text-white p-3 font-black text-2xl border border-white">
                                    {{ \Carbon\Carbon::parse($time)->format('g') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Force clear lines consistent with the user's paper request */
        th, td {
            border: 2px solid #555 !important;
        }
        
        /* Ensure table expands properly */
        table {
            width: 100%;
            table-layout: fixed;
        }
        
        .dark th, .dark td {
            border-color: #888 !important;
        }
    </style>
</x-filament-panels::page>
