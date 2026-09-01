<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * BadgeStatus Component - Flux UI Badge wrapper
 *
 * Proporciona un badge para mostrar estados con soporte para:
 * - Múltiples variantes de color (success, warning, danger, info)
 * - Iconos opcionales
 * - Texto descriptivo
 * - Estados personalizables
 *
 * @example
 * <livewire:user-module.components.badge-status
 *     :label="'Active'"
 *     :variant="'success'"
 *     :icon="'check-circle'"
 * />
 */
class BadgeStatus extends Component
{
    public string $label = '';

    public string $variant = 'default';

    public ?string $icon = null;

    public string $size = 'md';

    /**
     * Map variants to Flux color classes
     */
    protected array $variantMap = [
        'success' => 'zinc',
        'warning' => 'amber',
        'danger' => 'rose',
        'info' => 'blue',
        'pending' => 'yellow',
        'inactive' => 'gray',
        'default' => 'zinc',
    ];

    public function mount(string $label = '', string $variant = 'default', ?string $icon = null, string $size = 'md'): void
    {
        $this->label = $label;
        $this->variant = $variant;
        $this->icon = $icon;
        $this->size = $size;
    }

    public function getColor(): string
    {
        return $this->variantMap[$this->variant] ?? $this->variantMap['default'];
    }

    public function render()
    {
        return view('livewire.user-module.components.badge-status', [
            'label' => $this->label,
            'variant' => $this->variant,
            'icon' => $this->icon,
            'size' => $this->size,
            'color' => $this->getColor(),
        ]);
    }
}
