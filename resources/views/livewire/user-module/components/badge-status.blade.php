<div class="inline-flex items-center gap-1.5">
   @if ($icon)
      <flux:icon name="{{ $icon }}" class="size-4" />
   @endif

   <flux:badge :color="$color" class="text-xs">
      {{ $label }}
   </flux:badge>
</div>