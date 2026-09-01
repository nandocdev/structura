<div class="space-y-3 {{ $class }}">
   @for ($i = 0; $i < $count; $i++)
      <flux:skeleton class="h-{{ $height }} w-{{ $width }} @if ($animated) animate-pulse @endif" />
   @endfor
</div>