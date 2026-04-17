@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex flex-col items-center text-center py-2">
            {{-- Logo Section --}}
            <div class="mb-4">
                <div style="width: 80px; height: 80px; overflow: hidden; border-radius: 9999px; margin: 0 auto; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Clinic Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            {{-- Welcome Text --}}
            <div class="fi-account-widget-main mb-4" style="margin-top: 1rem;">
                <h2 class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">
                    {{ __('filament-panels::widgets/account-widget.welcome', ['app' => '']) }}
                </h2>

                <p class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                    {{ filament()->getUserName($user) }}
                </p>
            </div>

            {{-- Logout Button --}}
            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="w-full pt-4 border-t border-gray-100 dark:border-gray-800"
            >
                @csrf

                <x-filament::button
                    color="danger"
                    size="sm"
                    :icon="\Filament\Support\Icons\Heroicon::ArrowLeftEndOnRectangle"
                    :icon-alias="\Filament\View\PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON"
                    tag="button"
                    type="submit"
                    variant="ghost"
                    class="w-full hover:bg-danger-50 dark:hover:bg-danger-900/20"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
