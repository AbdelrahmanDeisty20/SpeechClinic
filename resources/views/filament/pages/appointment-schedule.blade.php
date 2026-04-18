<x-filament-panels::page>
    <div class="space-y-6">
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
                                    {{-- Ultra Slim Time Header - No text --}}
                                    <th class="w-[25px] min-w-[25px] bg-[#d37332] text-white p-0 m-0 border border-white">
                                        {{-- Empty on purpose --}}
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
                                        {{-- Ultra Slim Time Label --}}
                                        <td class="bg-[#d37332] text-white p-0 m-0 font-black text-[10px] border border-white w-[25px] min-w-[25px] leading-none">
                                            {{ \Carbon\Carbon::parse($time)->format('g') }}
                                        </td>

                                        {{-- Session Cells --}}
                                        @foreach($specialistChunk as $specialist)
                                            <td class="border border-gray-500 p-2 h-24 bg-white dark:bg-gray-900">
                                                @php
                                                    $childName = $matrix[$time][$specialist->id] ?? null;
                                                @endphp
                                                
                                                @if($childName)
                                                    <div class="font-black text-[#d37332] border-2 border-[#d37332] bg-orange-50 p-2 rounded-lg text-xl leading-tight shadow-md dark:bg-orange-900/40 dark:text-white">
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
                    {{ __('No specialists found.') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Force ultra slim width and strong lines */
        table, th, td {
            border: 2px solid #333 !important;
        }
        
        table {
            width: 100%;
            table-layout: fixed;
        }
    </style>
</x-filament-panels::page>
