<div x-data="clock('Asia/Jakarta', 'id-ID')" x-init="start()"
    {{ $attributes->merge(['class' => 'backdrop-blur rounded-lg ring-1 p-2 ring-white/10 select-none']) }}>
    <div class="text-center flex items-center justify-center gap-4">
        <div class="text-md" x-text="dateStr"></div>
        <div
            class="font-mono tabular-nums flex justify-center items-center tracking-widest text-lg md:text-lg leading-none">
            <span x-text="hh"></span>
            <span class="transition-opacity duration-200" :class="blink ? 'opacity-100' : 'opacity-10'">:</span>
            <span x-text="mm"></span>
            <span class="transition-opacity duration-200" :class="blink ? 'opacity-100' : 'opacity-10'">:</span>
            <span x-text="ss"></span>
        </div>
    </div>
</div>
@pushOnce('scripts')
    <script>
        // Komponen jam Alpine
        function clock(tz = 'Asia/Jakarta', locale = 'id-ID') {
            return {
                tz,
                locale,
                hh: '00',
                mm: '00',
                ss: '00',
                dateStr: '',
                blink: true,
                start() {
                    this.update();
                    setInterval(() => {
                        this.blink = !this.blink;
                        this.update();
                    }, 1000);
                },
                update() {
                    const now = new Date();

                    // Format waktu 24 jam di timezone tertentu
                    const timeFmt = new Intl.DateTimeFormat(this.locale, {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false,
                        timeZone: this.tz
                    });
                    const parts = timeFmt.formatToParts(now);
                    const get = t => parts.find(p => p.type === t)?.value?.padStart(2, '0') ?? '00';

                    this.hh = get('hour');
                    this.mm = get('minute');
                    this.ss = get('second');

                    // Format tanggal lokal (Indonesia)
                    this.dateStr = new Intl.DateTimeFormat(this.locale, {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        timeZone: this.tz
                    }).format(now);
                }
            }
        }
    </script>
@endPushOnce
