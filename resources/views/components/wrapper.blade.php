@props([
    'field' => null,
    'hasInlineLabel' => null,
])

@if($field->isSearchEnabled())
    <x-filament-forms::field-wrapper
        :field="$field"
        :has-inline-label="$hasInlineLabel"

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
        x-on:keyup="$event.key != 'Enter' && $event.key != 'ArrowDown' && $event.key != 'ArrrowUp' && $event.key != 'Escape' &&  refresh_suggestions"

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
            <ul class="def-fo-searchable-input-dropdown-list">
                <template x-for="(suggestion, index) in suggestions">
                    <li class="def-fo-searchable-input-dropdown-list-item"
                        x-bind:class="{
                            'def-fo-searchable-input-dropdown-list-item-selected': selected_suggestion === index
                        }"
                        x-text="`${suggestion.label}`"
                        x-on:click="set(suggestion)"
                    ></li>
                </template>
            </ul>
        </div>
    </x-filament-forms::field-wrapper>
@else
    <x-filament-forms::field-wrapper
        :field="$field"
        :has-inline-label="$hasInlineLabel"
    >{{$slot}}</x-filament-forms::field-wrapper>
@endif
