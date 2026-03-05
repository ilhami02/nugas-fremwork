<button {{ $attributes->merge(['type' => 'button',
    'class' => 'inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-campus-dark border border-campus-gray/50 px-4 py-2 rounded-lg text-sm font-semibold transition']) }}>
    {{ $slot }}
</button>
