@props([
    'href' => route('home'),
    'imageClass' => 'w-10 h-10',
    'textClass' => 'text-xl',
    'showTagline' => false,
])

<a href="{{ $href }}"
   {{ $attributes->class(['group inline-flex min-w-0 items-center gap-2.5 no-underline']) }}
   aria-label="TalentGroup.id">
    <img src="{{ asset('tg/assets/logo-talentgroup-auth.jpeg') }}"
         alt="Logo TalentGroup.id"
         class="{{ $imageClass }} flex-shrink-0 rounded-full object-cover shadow-[0_2px_8px_rgba(0,71,179,0.22)] transition-transform duration-200 group-hover:scale-105">

    <span class="flex min-w-0 flex-col leading-none">
        <span class="{{ $textClass }} whitespace-nowrap font-extrabold tracking-[-0.035em] text-[color:var(--ink)]">
            Talent<span class="text-[#f97316]">Group</span><span class="text-[0.8em] font-bold text-[color:var(--ink)]">.id</span>
        </span>

        @if($showTagline)
            <span class="mt-1 text-[9px] font-bold uppercase tracking-[0.16em] text-[color:var(--muted)]">Ruang Edukasi</span>
        @endif
    </span>
</a>
