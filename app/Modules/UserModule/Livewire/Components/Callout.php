<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * Callout Component - Alertas y mensajes contextuales Flux UI
 *
 * Proporciona un contenedor para mostrar alertas, advertencias
 * e información importante al usuario.
 */
class Callout extends Component {
   public string $message = '';

   public string $variant = 'info';

   public ?string $icon = null;

   public ?string $title = null;

   public bool $dismissible = false;

   public bool $show = true;

   /**
    * Variantes de callout soportadas
    */
   protected array $variantIcons = [
      'info' => 'information-circle',
      'success' => 'check-circle',
      'warning' => 'exclamation-triangle',
      'danger' => 'x-circle',
   ];

   protected array $variantColors = [
      'info' => 'blue',
      'success' => 'green',
      'warning' => 'amber',
      'danger' => 'rose',
   ];

   public function mount(string $message = '', string $variant = 'info', ?string $icon = null, ?string $title = null, bool $dismissible = false): void {
      $this->message = $message;
      $this->variant = $variant;
      $this->icon = $icon ?? $this->variantIcons[$variant] ?? null;
      $this->title = $title;
      $this->dismissible = $dismissible;
   }

   public function dismiss(): void {
      $this->show = false;
   }

   public function getColor(): string {
      return $this->variantColors[$this->variant] ?? 'gray';
   }

   public function render() {
      return view('livewire.user-module.components.callout', [
         'message' => $this->message,
         'variant' => $this->variant,
         'icon' => $this->icon,
         'title' => $this->title,
         'dismissible' => $this->dismissible,
         'show' => $this->show,
         'color' => $this->getColor(),
      ]);
   }
}
