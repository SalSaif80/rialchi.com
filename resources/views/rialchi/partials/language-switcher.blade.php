<form method="get" action="{{ url()->current() }}" class="language-switcher" style="display:inline-flex;align-items:center;gap:6px;flex-shrink:0">
    @foreach(request()->except('locale') as $key => $value)
        @if(is_scalar($value))<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
    @endforeach
    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/></svg>
    <select name="locale" aria-label="{{ __('اللغة') }}" onchange="this.form.submit()" style="color:inherit;background:transparent;border:1px solid #b8a587;border-radius:8px;min-height:40px;padding:4px 6px;font-size:14px;max-width:110px">
        @foreach(['ar' => 'العربية', 'en' => 'English', 'zh_CN' => '简体中文'] as $code => $label)
            <option value="{{ $code }}" @selected(app()->getLocale() === $code)>{{ $label }}</option>
        @endforeach
    </select>
    <noscript><button type="submit">{{ __('تغيير اللغة') }}</button></noscript>
</form>
