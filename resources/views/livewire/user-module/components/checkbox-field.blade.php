<flux:field>
   <flux:checkbox wire:model="modelValue" :label="$label ?: null" :disabled="$disabled" />

   @if ($description)
      <flux:description>{{ $description }}</flux:description>
   @endif

   @if ($errors->has($errorKey))
      <flux:error name="{{ $errorKey }}" />
   @endif
</flux:field>