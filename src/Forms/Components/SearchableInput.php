<?php

namespace DefStudio\SearchableInput\Forms\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;

class SearchableInput extends TextInput
{
    protected ?Closure $searchUsing = null;
    protected ?Closure $onItemSelected = null;

    protected function setUp(): void
    {
        $this->fieldWrapperView('searchable-input-wrapper');

        $this->extraInputAttributes(['x-model' => 'value']);

        $this->registerActions([
            Action::make('search')->action(function (array $arguments) {
                $search = $arguments['value'];

                return $this->evaluate($this->searchUsing, [
                    'search' => $search,
                ]);
            }),
            Action::make('item_selected')->action(function ($arguments) {
                $this->evaluate($this->onItemSelected, [
                    'item' => $arguments['item'],
                ]);
            }),
        ]);
    }

    public function searchUsing(Closure|null $searchUsing): static
    {
        $this->searchUsing = $searchUsing;

        return $this;
    }

    public function onItemSelected(Closure|null $callback): static
    {
        $this->onItemSelected = $callback;

        return $this;
    }

    public function isSearchEnabled(): bool
    {
        return $this->searchUsing !== null;
    }
}
