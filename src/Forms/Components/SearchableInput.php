<?php

namespace DefStudio\SearchableInput\Forms\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasOptions;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Arrayable;

class SearchableInput extends TextInput
{
    /** @var ?Closure(string): array<int|string, string|array{label: string, value: string}> */
    protected ?Closure $searchUsing = null;

    /** @var ?Closure(array{label: string, value: string}>:): void */
    protected ?Closure $onItemSelected = null;

    /** @var array<array-key, string>|Closure(): array<array-key, string>|null */
    protected array|Closure|null $options = null;


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
                    if(array_is_list($results)) {
                        $results = collect($results)
                            ->map(fn($item) => [
                                'value' => $item,
                                'label' => $item,
                            ])->toArray();
                    }else{
                        $results = collect($results)
                            ->map(fn($item, $key) => [
                                'value' => $key,
                                'label' => $item,
                            ])->toArray();
                    }
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

    /**
     * @return array<array-key, string>
     */
    public function getOptions(): array
    {
        return $this->evaluate($this->options) ?? [];
    }

    /**
     * @param  array<array-key, string>|Closure(): array<array-key, string>|null  $options
     */
    public function options(array|Closure|null $options): static
    {
        $this->options = $options;
        return $this;
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
