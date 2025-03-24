<?php

namespace DefStudio\SearchableInput\DTO;

use Illuminate\Contracts\Support\Arrayable;

class SearchResult implements Arrayable
{
    protected array $data = [];

    final public function __construct(
        protected string $value,
        protected string $label,
    ) {}

    public static function make(string $value, ?string $label = null): self
    {
        return new static($value, $label ?? $value);
    }

    public function withData(string | array $key, string $value): self
    {
        if (is_array($key)) {
            $this->data = $key;

            return $this;
        }

        data_set($this->data, $key, $value);

        return $this;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }

    public static function fromArray(array $item): self
    {
        $dto = new static($item['value'], $item['label'] ?? $item['value']);
        $dto->data = $item['data'] ?? [];

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
            'data' => $this->data,
        ];
    }
}
