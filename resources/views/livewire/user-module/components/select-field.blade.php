@php
   $errorClass = $errors->has($errorKey) ? 'border-rose-500 dark:border-rose-400' : '';
@endphp

<flux:field>
   @if ($label)
      <flux:label>
         {{ $label }}
         @if ($required)
            <span class="text-rose-500">*</span>
         @endif
      </flux:label>
   @endif

   <select wire:model="modelValue"
      class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600"
      {{ $disabled ? 'disabled' : '' }}>
      @if ($placeholder)
         <option value="">{{ $placeholder }}</option>
      @endif
      @foreach ($options as $value => $label)
         <option value="{{ $value }}">{{ $label }}</option>
      @endforeach
   </select>

   @if ($description)
      <flux:description>{{ $description }}</flux:description>
   @endif

   @if ($errors->has($errorKey))
      <flux:error name="{{ $errorKey }}" />
   @endif
</flux:field>