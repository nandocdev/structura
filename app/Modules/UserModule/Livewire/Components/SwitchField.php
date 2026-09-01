<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * SwitchField Component - Flux UI Switch wrapper
 */
class SwitchField extends Component
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
        return view('livewire.user-module.components.switch-field', [
            'modelValue' => $this->modelValue,
            'model' => $this->model,
            'label' => $this->label,
            'description' => $this->description,
            'disabled' => $this->disabled,
            'errorKey' => $this->errorKey ?? $this->model,
        ]);
    }
}
