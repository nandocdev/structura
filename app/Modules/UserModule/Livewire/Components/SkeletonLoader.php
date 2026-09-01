<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * SkeletonLoader Component - Placeholder de carga Flux UI
 *
 * Proporciona esqueletos animados para mostrar mientras
 * se cargan datos (loading states).
 */
class SkeletonLoader extends Component
{
    public int $count = 1;

    public string $height = '12';

    public string $width = 'full';

    public bool $animated = true;

    public string $class = '';

    public function render()
    {
        return view('livewire.user-module.components.skeleton-loader', [
            'count' => $this->count,
            'height' => $this->height,
            'width' => $this->width,
            'animated' => $this->animated,
            'class' => $this->class,
        ]);
    }
}
