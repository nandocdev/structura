<div
   class="@if ($padded) p-{{ $padding === 'sm' ? '4' : ($padding === 'lg' ? '8' : '6') }} @endif border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-800 bg-white {{ $class }}">
   @if ($title)
      <div class="mb-4">
         <flux:heading level="3">{{ $title }}</flux:heading>
         @if ($description)
            <flux:subheading>{{ $description }}</flux:subheading>
         @endif
      </div>
   @endif

   <div>
      {{ $slot }}
   </div>
</div>