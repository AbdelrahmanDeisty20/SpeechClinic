<x-filament-panels::page>
    <div class="space-y-6">
        <form wire:submit.prevent="submit">
            {{ $this->form }}
        </form>

        @php
            $schedule = $this->getScheduleData();
            $specialists = $schedule['specialists'];
            $times = $schedule['times'];
            $matrix = $schedule['matrix'];
        @endphp

        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <table class="w-full border-collapse text-right text-sm">
                <thead>
                    <tr class="bg-[#d37332] text-white">
                        <th class="border border-white/20 p-4 font-bold text-center w-16">/</th>
                        @foreach($specialists as $specialist)
                            <th class="border border-white/20 p-4 font-bold text-center">
                                {{ $specialist->full_name }}
                            </th>
                        @endforeach
                        <th class="bg-[#d37332] border border-white/20 p-4 font-bold text-center w-16">/</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($times as $time)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            {{-- Left Time Column --}}
                            <td class="bg-[#d37332] text-white border border-white/20 p-4 font-bold text-center whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($time)->format('g') }}
                            </td>

                            {{-- Data Cells --}}
                            @foreach($specialists as $specialist)
                                <td class="border border-gray-200 p-4 text-center min-w-[120px] dark:border-gray-700 h-24 align-middle">
                                    @php
                                        $childName = $matrix[$time][$specialist->id] ?? null;
                                    @endphp
                                    
                                    @if($childName)
                                        <div class="bg-orange-50 text-[#d37332] rounded-lg p-3 font-semibold border border-orange-100 shadow-sm animate-fade-in dark:bg-orange-900/20 dark:border-orange-900/30">
                                            {{ $childName }}
                                        </div>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">-</span>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Right Time Column --}}
                            <td class="bg-[#d37332] text-white border border-white/20 p-4 font-bold text-center whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($time)->format('g') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-filament-panels::page>
