<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Filter Section --}}
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
            
            // Split specialists into two chunks
            $chunks = $specialists->count() > 0 ? $specialists->chunk(ceil($specialists->count() / 2)) : [];
        @endphp

        <div class="space-y-4">
            @foreach($chunks as $index => $specialistChunk)
                <div class="relative overflow-hidden rounded-xl border-2 border-gray-500 bg-white shadow-lg dark:bg-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-center text-sm min-w-[1200px]">
                            <thead>
                                <tr class="bg-[#d37332] text-white">
                                    {{-- Right Small Time Header (First column for RTL) --}}
                                    <th class="w-10 bg-[#d37332] text-white p-2 font-black text-[10px] border border-white">
                                        {{ __('وقت') }}
                                    </th>
                                    
                                    @foreach($specialistChunk as $specialist)
                                        <th class="border border-white p-2 min-w-[200px] font-black h-20 text-lg">
                                            {{ $specialist->full_name }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($times as $time)
                                    <tr class="hover:bg-orange-50/50 transition-colors">
                                        {{-- Right Small Time Label --}}
                                        <td class="bg-[#d37332] text-white p-2 font-black text-lg border border-white w-10">
                                            {{ \Carbon\Carbon::parse($time)->format('g') }}
                                        </td>

                                        {{-- Session Cells --}}
                                        @foreach($specialistChunk as $specialist)
                                            <td class="border border-gray-500 p-2 h-24 bg-white dark:bg-gray-900">
                                                @php
                                                    $childName = $matrix[$time][$specialist->id] ?? null;
                                                @endphp
                                                
                                                @if($childName)
                                                    <div class="font-black text-[#d37332] border-2 border-[#d37332] bg-orange-50 p-3 rounded-lg text-xl leading-tight shadow-md dark:bg-orange-900/40 dark:text-white">
                                                        {{ $childName }}
                                                    </div>
                                                @else
                                                    <div class="text-gray-100">.</div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            
            @if($specialists->isEmpty())
                <div class="p-12 text-center text-gray-400 font-bold border-2 border-dashed border-gray-200 rounded-xl">
                    {{ __('No specialists found for the selected filter.') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Strong borders for the grid */
        table, th, td {
            border: 2px solid #333 !important;
        }
        
        table {
            width: 100%;
            table-layout: fixed;
        }

        .dark th, .dark td {
            border-color: #777 !important;
        }
    </style>
</x-filament-panels::page>
