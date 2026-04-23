<footer class="mt-12 bg-slate-950/95 py-10 text-sm text-slate-200">
    <div class="shell-container grid gap-6 md:grid-cols-3">
        <div>
            <p class="text-lg font-semibold text-white">{{ $siteSettings['site_name'] ?? 'PIPAA CMS' }}</p>
            <p class="mt-3 text-slate-400">Professional accounting education, certification support, and institute news managed from a clean Laravel CMS.</p>
        </div>
        <div>
            <p><strong class="text-white">Email:</strong> {{ $siteSettings['contact_email'] ?? 'info@pipaa.tj' }}</p>
            @if(! empty($siteSettings['contact_backup_email']))
                <p class="mt-2"><strong class="text-white">Backup:</strong> {{ $siteSettings['contact_backup_email'] }}</p>
            @endif
            @if(! empty($siteSettings['contact_phone']))
                <p class="mt-2"><strong class="text-white">Phone:</strong> {{ $siteSettings['contact_phone'] }}</p>
            @endif
        </div>
        <div>
            <p><strong class="text-white">Address:</strong> {{ $siteSettings['contact_address'] ?? 'Dushanbe, Tajikistan' }}</p>
            <p class="mt-4 text-slate-500">&copy; {{ now()->year }} {{ $siteSettings['site_name'] ?? 'PIPAA CMS' }}</p>
        </div>
    </div>
</footer>
