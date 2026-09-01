<div>
   @if ($show)
      <flux:callout :variant="$variant" class="flex items-start gap-3">
         @if ($icon)
            <flux:icon name="{{ $icon }}" class="size-5 flex-shrink-0 mt-0.5" />
         @endif

         <div class="flex-1">
            @if ($title)
               <flux:heading level="4" size="sm">{{ $title }}</flux:heading>
            @endif

            <flux:text>{{ $message }}</flux:text>

            {{ $slot ?? '' }}
         </div>

         @if ($dismissible)
            <button type="button" wire:click="dismiss"
               class="flex-shrink-0 text-{{ $color }}-400 hover:text-{{ $color }}-600 dark:hover:text-{{ $color }}-300"
               aria-label="{{ __('Dismiss') }}">
               <flux:icon name="x-mark" class="size-5" />
            </button>
         @endif
      </flux:callout>
   @endif
</div>