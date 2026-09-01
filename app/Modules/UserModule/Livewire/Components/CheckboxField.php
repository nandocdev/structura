<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * CheckboxField Component - Flux UI Checkbox wrapper
 */
class CheckboxField extends Component
{
    public bool $modelValue = false;

    public string $model = '';

    public string $label = '';

    public ?string $description = null;

    public bool $disabled = false;

    public ?string $errorKey = null;

    public function updatedModelValue(bool $value): void
    {
        $this->dispatch('field-updated', field: $this->model, value: $value);
    }

    public function render()
    {
        return view('livewire.user-module.components.checkbox-field', [
            'modelValue' => $this->modelValue,
            'model' => $this->model,
            'label' => $this->label,
            'description' => $this->description,
            'disabled' => $this->disabled,
            'errorKey' => $this->errorKey ?? $this->model,
        ]);
    }
}
