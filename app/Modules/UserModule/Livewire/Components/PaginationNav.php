<?php

namespace App\Modules\UserModule\Livewire\Components;

use Illuminate\Pagination\AbstractPaginator;
use Livewire\Component;

/**
 * PaginationNav Component - Navegación de paginación Flux UI
 *
 * Proporciona controles de paginación accesibles para listas de datos.
 */
class PaginationNav extends Component {
   public ?AbstractPaginator $paginator = null;

   public string $queryString = 'page';

   public string $alignment = 'center';

   public function mount(?AbstractPaginator $paginator = null): void {
      $this->paginator = $paginator;
   }

   public function goToPage(int $page): void {
      $this->dispatch('paginate', page: $page);
   }

   public function render() {
      return view('livewire.user-module.components.pagination-nav', [
         'paginator' => $this->paginator,
         'alignment' => $this->alignment,
      ]);
   }
}
