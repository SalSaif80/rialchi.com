<header>
<a class="brand" href="{{ route('rialchi.home') }}#home" aria-label="Rialchi الرئيسية">
<span class="brand-icon">◈</span>
<b dir="ltr">RLC <span>RIALCHI</span>
</b>
</a>
<button class="menu-toggle" aria-expanded="false" aria-controls="nav" aria-label="فتح القائمة">☰</button>
<nav id="nav">
<a href="{{ route('rialchi.home') }}#journey">كيف أبدأ؟ <small>⌟</small>
</a>
<a href="{{ route('rialchi.tracking') }}" @if(request()->routeIs('rialchi.tracking')) aria-current="page" @endif>تتبع شحنتك <small>@include('rialchi.components.icons.arrow-up-right')</small>
</a>
<a href="{{ route('rialchi.home') }}#network">قبل أن تدفع <small>⌟</small>
</a>
<a class="quote-link" data-wa="السلام عليكم فريق ريالتشي، لدي استفسار عن الاستيراد." href="https://wa.me/{{ config('rialchi.whatsapp') }}">تواصل واتساب <small>@include('rialchi.components.icons.arrow-down-left')</small>
</a>
</nav>
</header>
