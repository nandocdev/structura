<div>
   <div wire:loading.delay.shortest class="space-y-3">
      @for ($i = 0; $i < 5; $i++)
         <flux:skeleton class="h-12 w-full" />
      @endfor
   </div>

   <div wire:loading.delay.shortest.remove>
      @if (empty($rows))
         <flux:card class="text-center py-12">
            <flux:icon name="inbox" class="size-12 mx-auto mb-4 text-zinc-400" />
            <flux:heading level="3">{{ __('No records') }}</flux:heading>
            <flux:text class="text-zinc-500">{{ $emptyMessage }}</flux:text>
         </flux:card>
      @else
         <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
               <thead>
                  <tr class="border-b border-zinc-200 dark:border-zinc-700">
                     @foreach ($columns as $column)
                        @php
                           $isSortable = $column['sortable'] ?? false;
                           $isActive = $sortBy === $column['key'];
                           $icon = $isActive && $sortDirection === 'desc' ? 'chevron-down' : 'chevron-up';
                          @endphp

                        <th class="text-left px-4 py-2 font-medium text-sm {{ $isSortable ? 'cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700' : '' }}"
                           @if ($isSortable) wire:click="sort('{{ $column['key'] }}')" @endif>
                           <div class="flex items-center gap-2">
                              {{ $column['label'] }}
                              @if ($isActive && $isSortable)
                                 <flux:icon name="{{ $icon }}" class="size-4" />
                              @endif
                           </div>
                        </th>
                     @endforeach
                  </tr>
               </thead>
               <tbody>
                  @forelse ($rows as $row)
                     <tr class="border-b border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        @foreach ($columns as $column)
                           <td class="px-4 py-3">
                              @if (is_callable($column['render'] ?? null))
                                 {{ $column['render']($row) }}
                              @else
                                 {{ data_get($row, $column['key']) }}
                              @endif
                           </td>
                        @endforeach
                     </tr>
                  @empty
                     <tr>
                        <td colspan="{{ count($columns) }}" class="text-center py-8">
                           <flux:text class="text-zinc-500">{{ $emptyMessage }}</flux:text>
                        </td>
                     </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      @endif
   </div>
</div>