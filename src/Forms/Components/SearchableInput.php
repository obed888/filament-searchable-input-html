<?php

namespace DefStudio\SearchableInput\Forms\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasOptions;
use Filament\Forms\Components\TextInput;

class SearchableInput extends TextInput
{
    use HasOptions;

    /** @var ?Closure(string): array<int|string, string|array{label: string, value: string}> */
    protected ?Closure $searchUsing = null;

    /** @var ?Closure(array{label: string, value: string}>:): void */
    protected ?Closure $onItemSelected = null;

    protected function setUp(): void
    {
        $this->fieldWrapperView('searchable-input-wrapper');

        $this->extraInputAttributes(['x-model' => 'value']);

        $this->registerActions([
            Action::make('search')->action(function(SearchableInput $component, array $arguments): array {
                if ($component->isDisabled() || $component->isReadOnly()) {
                    return [];
                }

                $search = $arguments['value'];

                $results = $this->evaluate($this->searchUsing, [
                    'search' => $search,
                    'options' => $this->getOptions(),
                ]);

                $results ??= collect($this->getOptions())
                    ->filter(fn(string $option) => str($option)->contains($search))
                    ->toArray();

                if (collect($results)->every(fn($item) => is_string($item))) {
                    $results = collect($results)
                        ->map(fn($item, $key) => [
                            'value' => $key,
                            'label' => $item,
                        ]);
                }

                return $results;
            }),

            Action::make('item_selected')->action(function($arguments) {
                $this->evaluate($this->onItemSelected, [
                    'item' => $arguments['item'],
                ]);
            }),
        ]);
    }

    public function searchUsing(?Closure $searchUsing): static
    {
        $this->searchUsing = $searchUsing;

        return $this;
    }

    public function onItemSelected(?Closure $callback): static
    {
        $this->onItemSelected = $callback;

        return $this;
    }

    public function isSearchEnabled(): bool
    {
        return $this->searchUsing !== null || $this->getOptions() !== [];
    }
}
