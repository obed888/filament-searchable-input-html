@props([
    'field' => null,
    'hasInlineLabel' => null,
])

@if($field->isSearchEnabled())
    <x-filament-forms::field-wrapper
        :field="$field"
        :has-inline-label="$hasInlineLabel"
        class="def-fo-searchable-input-wrapper relative"
        x-load
        x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-searchable-input', 'defstudio/filament-searchable-input') }}"
        x-data="searchableInput({
            statePath: '{{ $field->getStatePath() }}'
        })"
        x-on:click.away="suggestions=[]"
        x-on:keyup.prevent.enter=""
        x-on:keyup.prevent.esc=""
        x-on:keyup.prevent.up=""
        x-on:keyup.prevent.down=""
        x-on:keyup="$event.key != 'Enter' && $event.key != 'ArrowDown' && $event.key != 'ArrowUp' && $event.key != 'Escape' &&  refresh_suggestions"
        x-on:keydown.prevent.enter="set(suggestions[selected_suggestion])"
        x-on:keydown.prevent.esc="suggestions = []"
        x-on:keydown.prevent.up="previous_suggestion()"
        x-on:keydown.prevent.down="next_suggestion()"
        x-on:keydown.tab="suggestions = []"
    >
        {{-- Input slot --}}
        {{ $slot }}

        {{-- Spinner de carga --}}
        <div
            x-show="loading"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 animate-spin"
            style="display: none;"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v1m0 14v1m8-8h1M4 12H3m15.364-7.364l-.707.707M6.343 17.657l-.707.707m12.021 0l-.707-.707M6.343 6.343l-.707-.707"/>
            </svg>
        </div>

        {{-- Lista de sugerencias --}}
        <div x-show="suggestions.length > 0"
             class="def-fo-searchable-input-dropdown"
        >
            <div class="def-fo-searchable-input-dropdown-wrapper">
                <ul class="def-fo-searchable-input-dropdown-list"
                    wire:loading.class.delay="def-fo-searchable-input-dropdown-list-loading">
                    <template x-for="(suggestion, index) in suggestions">
                        <li class="def-fo-searchable-input-dropdown-list-item"
                            :class="{
                                'def-fo-searchable-input-dropdown-list-item-selected': selected_suggestion === index
                            }"
                            x-html="suggestion.label"
                            @click="set(suggestion)"
                        ></li>
                    </template>
                </ul>
            </div>
        </div>
    </x-filament-forms::field-wrapper>
@else
    <x-filament-forms::field-wrapper
        :field="$field"
        :has-inline-label="$hasInlineLabel"
    >
        {{ $slot }}
    </x-filament-forms::field-wrapper>
@endif
