<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Component;

/**
 * BreadcrumbsNav Component - Navegación jerárquica Flux UI
 *
 * Proporciona migajas de pan para mostrar la ubicación actual
 * dentro de la jerarquía de la aplicación.
 */
class BreadcrumbsNav extends Component {
   /**
    * @var array Array de migas: [['label' => 'Home', 'href' => '/', 'active' => false], ...]
    */
   public array $breadcrumbs = [];

   public string $separator = '/';

   public function render() {
      return view('livewire.user-module.components.breadcrumbs-nav', [
         'breadcrumbs' => $this->breadcrumbs,
         'separator' => $this->separator,
      ]);
   }
}
