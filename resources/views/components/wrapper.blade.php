@props([
    'field' => null,
    'hasInlineLabel' => null,
])

@if($field->isSearchEnabled())
    <x-filament-forms::field-wrapper
        :field="$field"
        :has-inline-label="$hasInlineLabel"

        class="def-fo-searchable-input-wrapper"

        x-load
        x-load-src="{{\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-searchable-input', 'defstudio/filament-searchable-input')}}"
        x-data="searchableInput({
            statePath: '{{$field->getStatePath()}}'
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
        {{$slot}}

        <div x-show="suggestions.length > 0"
             class="def-fo-searchable-input-dropdown"
        >
            <div class="def-fo-searchable-input-dropdown-wrapper">
                <ul class="def-fo-searchable-input-dropdown-list" wire:loading.class.delay="def-fo-searchable-input-dropdown-list-loading">
                    <template x-for="(suggestion, index) in suggestions" :key="index">
                        <li
                            x-ref="suggestionItems"
                            class="def-fo-searchable-input-dropdown-list-item"
                            :class="{
                                'def-fo-searchable-input-dropdown-list-item-selected': selected_suggestion === index
                            }"
                            x-html="suggestion.label"
                            @click="set(suggestion)"
                            x-effect="if (selected_suggestion === index) {
                                $nextTick(() => $refs.suggestionItems[index]?.scrollIntoView({ behavior: 'smooth', block: 'nearest' }));
                            }"
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
    >{{$slot}}</x-filament-forms::field-wrapper>
@endif
