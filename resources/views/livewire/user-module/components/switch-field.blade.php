<div class="flex items-center justify-between gap-4">
   <div class="flex-1">
      @if ($label)
         <flux:label class="mb-1 block">{{ $label }}</flux:label>
      @endif

      @if ($description)
         <flux:description>{{ $description }}</flux:description>
      @endif
   </div>

   <flux:switch wire:model="modelValue" :disabled="$disabled" />
</div>

@if ($errors->has($errorKey))
   <div class="mt-2">
      <flux:error name="{{ $errorKey }}" />
   </div>
@endif