<label {{ $attributes->merge(['class' => 'block text-xs font-semibold mb-1.5']) }} style="color: #0f2c5e;">
    {{ $value ?? $slot }}
</label>
