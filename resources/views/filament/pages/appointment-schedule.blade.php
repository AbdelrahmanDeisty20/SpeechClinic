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
                <table class="w-full border-collapse border border-gray-400 text-center text-sm">
                    <thead>
                        <tr>
                            <th class="sticky left-0 z-30 w-16 bg-[#d37332] text-white p-3 font-bold border border-gray-400">
                                {{ __('Time') }}
                            </th>
                            @foreach($specialists as $specialist)
                                <th class="border border-gray-400 p-3 min-w-[80px] bg-gray-100 dark:bg-gray-800 dark:text-gray-100 h-40 align-bottom">
                                    <div class="flex flex-col items-center justify-end h-full">
                                        <div class="transform -rotate-90 origin-bottom mb-4 whitespace-nowrap font-black text-gray-800 dark:text-gray-200">
                                            {{ $specialist->full_name }}
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                            <th class="w-16 bg-[#d37332] text-white p-3 font-bold border border-gray-400">
                                {{ __('Time') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($times as $time)
                            <tr class="hover:bg-orange-50/50 transition-colors">
                                {{-- Left Sticky Time --}}
                                <td class="sticky left-0 z-20 bg-[#d37332] text-white p-3 font-black text-lg border border-gray-400 shadow-xl">
                                    {{ \Carbon\Carbon::parse($time)->format('g') }}
                                    <span class="block text-[8px] opacity-70">{{ \Carbon\Carbon::parse($time)->format('A') }}</span>
                                </td>

                                {{-- Session Cells --}}
                                @foreach($specialists as $specialist)
                                    <td class="border border-gray-400 p-2 h-20 bg-white dark:bg-gray-900">
                                        @php
                                            $childName = $matrix[$time][$specialist->id] ?? null;
                                        @endphp
                                        
                                        @if($childName)
                                            <div class="font-bold text-gray-900 border-l-4 border-[#d37332] bg-orange-50 p-2 rounded text-[12px] leading-tight break-words dark:bg-orange-900/20 dark:text-white">
                                                {{ $childName }}
                                            </div>
                                        @else
                                            <div class="text-gray-100 dark:text-gray-800">.</div>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Right Time --}}
                                <td class="bg-[#d37332] text-white p-3 font-black text-lg border border-gray-400">
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
        /* Force high contrast lines */
        th, td {
            border: 1px solid #999 !important;
        }

        /* Ensure sticky shadow */
        .sticky {
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
    </style>
</x-filament-panels::page>
