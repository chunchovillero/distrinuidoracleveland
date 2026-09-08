@if(($systemConfig['show_logo'] ?? 'true') === 'true' && !empty($systemConfig['logo']))
    <img src="{{ asset($systemConfig['logo']) }}" 
         alt="{{ $systemConfig['company_name'] ?? 'Logo' }}" 
         class="{{ $class ?? 'brand-image' }}">
@else
    <span class="brand-text font-weight-light">
        {{ $systemConfig['company_name'] ?? 'Sistema POS' }}
    </span>
@endif