<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * Card Component - Contenedor de contenido con estilo Flux UI
 *
 * Proporciona un contenedor flexible para agrupar contenido
 * con soporte para headers, footers y acciones.
 */
class Card extends Component
{
    public string $title = '';

    public ?string $description = null;

    public string $class = '';

    public bool $padded = true;

    public string $padding = 'md';

    public function render()
    {
        return view('livewire.user-module.components.card', [
            'title' => $this->title,
            'description' => $this->description,
            'class' => $this->class,
            'padded' => $this->padded,
            'padding' => $this->padding,
        ]);
    }
}
