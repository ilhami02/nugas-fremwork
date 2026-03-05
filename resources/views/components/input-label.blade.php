<label {{ $attributes->merge(['class' => 'block text-xs font-semibold mb-1.5 text-campus-blue']) }}>
    {{ $value ?? $slot }}
</label>
