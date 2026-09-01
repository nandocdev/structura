<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * SelectField Component - Flux UI Select wrapper
 */
class SelectField extends Component
{
    public mixed $modelValue = null;

    public string $model = '';

    public string $label = '';

    public string $placeholder = '';

    public array $options = [];

    public ?string $description = null;

    public bool $disabled = false;

    public bool $required = false;

    public ?string $errorKey = null;

    public function updatedModelValue(mixed $value): void
    {
        $this->dispatch('field-updated', field: $this->model, value: $value);
    }

    public function render()
    {
        return view('livewire.user-module.components.select-field', [
            'modelValue' => $this->modelValue,
            'model' => $this->model,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'options' => $this->options,
            'description' => $this->description,
            'disabled' => $this->disabled,
            'required' => $this->required,
            'errorKey' => $this->errorKey ?? $this->model,
        ]);
    }
}
