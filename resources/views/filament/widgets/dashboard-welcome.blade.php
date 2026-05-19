<x-filament-widgets::widget>
    @php
        $user = auth()->user();
        $roles = $user?->getRoleNames()->toArray() ?? [];
        $shortcuts = $this->getShortcuts();
    @endphp

    <style>
        .welcome-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }
        .shortcut-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            height: 180px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }
        .dark .shortcut-card {
            border-color: #1f2937;
            background-color: #111827;
        }
        .shortcut-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -2px rgba(59, 130, 246, 0.05);
            transform: translateY(-2px);
        }
        .shortcut-icon-container {
            padding: 10px;
            background-color: #f1f5f9;
            border-radius: 8px;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .dark .shortcut-icon-container {
            background-color: #1f2937;
            color: #9ca3af;
        }
        .shortcut-card:hover .shortcut-icon-container {
            background-color: #2563eb;
            color: #ffffff;
        }
        .shortcut-title {
            font-weight: 700;
            font-size: 15px;
            margin: 0;
            color: #1e293b;
            transition: color 0.3s ease;
            line-height: 1.2;
        }
        .dark .shortcut-title {
            color: #f3f4f6;
        }
        .shortcut-card:hover .shortcut-title {
            color: #2563eb;
        }
        .dark .shortcut-card:hover .shortcut-title {
            color: #60a5fa;
        }
        .shortcut-desc {
            font-size: 12px;
            color: #64748b;
            margin: 12px 0 0 0;
            line-height: 1.5;
        }
        .dark .shortcut-desc {
            color: #9ca3af;
        }
        .shortcut-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 8px 16px;
            background-color: #f1f5f9;
            color: #475569;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            gap: 6px;
        }
        .dark .shortcut-btn {
            background-color: #1f2937;
            color: #d1d5db;
            border-color: #374151;
        }
        .shortcut-card:hover .shortcut-btn {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #1d4ed8;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
    </style>

    <x-filament::section class="fi-wi-welcome overflow-hidden">
        <!-- Banner Top (Slate Navy) -->
        <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 24px; padding: 24px; border-radius: 12px; background-color: #0f172a; color: #ffffff; position: relative; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            
            <!-- Left Header -->
            <div style="display: flex; flex-direction: row; align-items: center; gap: 16px; z-index: 10;">
                <div style="width: 56px; height: 56px; background-color: rgba(255, 255, 255, 0.1); border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 20px; border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; flex-shrink: 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <h2 style="font-size: 20px; font-weight: 700; tracking-tight: -0.025em; color: #ffffff; margin: 0; line-height: 1.25;">
                        Selamat Datang Kembali, {{ $user->name ?? 'Administrator' }}!
                    </h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-top: 8px;">
                        <span style="font-size: 11px; font-weight: 600; color: #cbd5e1;">Hak Akses:</span>
                        @forelse($roles as $role)
                            <x-filament::badge color="primary" size="sm" class="uppercase font-bold tracking-wider">
                                {{ $role }}
                            </x-filament::badge>
                        @empty
                            <x-filament::badge color="gray" size="sm">
                                STAFF
                            </x-filament::badge>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Header -->
            <div style="text-align: right; font-size: 12px; color: #cbd5e1; max-w: 280px; line-height: 1.5; z-index: 10; flex-shrink: 0;" class="hidden md:block">
                <p style="font-weight: 700; color: #ffffff; font-size: 14px; margin: 0;">Portal CMS PPID Aktif</p>
                <p style="margin: 4px 0 0 0;">Gunakan pintasan di bawah ini untuk mengakses modul kerja utama Anda secara instan.</p>
            </div>
        </div>

        <!-- Shortcuts Grid -->
        <div style="margin-top: 24px;">
            <h3 style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 6px; height: 14px; background-color: #3b82f6; border-radius: 2px; display: inline-block;"></span>
                Pintasan Modul Kerja Anda
            </h3>

            @if(count($shortcuts) > 0)
                <div class="welcome-card-grid">
                    @foreach($shortcuts as $shortcut)
                        <a href="{{ $shortcut['url'] }}" class="shortcut-card">
                            <div>
                                <div style="display: flex; flex-direction: row; align-items: center; gap: 12px;">
                                    <div class="shortcut-icon-container">
                                        @if($shortcut['icon'] === 'complaint')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                        @elseif($shortcut['icon'] === 'message')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        @elseif($shortcut['icon'] === 'news')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                        @elseif($shortcut['icon'] === 'document')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        @elseif($shortcut['icon'] === 'letter')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5" /></svg>
                                        @elseif($shortcut['icon'] === 'user')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        @elseif($shortcut['icon'] === 'setting')
                                            <svg width="20" height="20" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        @endif
                                    </div>
                                    <h4 class="shortcut-title">{{ $shortcut['title'] }}</h4>
                                </div>
                                <p class="shortcut-desc">{{ $shortcut['description'] }}</p>
                            </div>
                            <!-- Beautiful Tactile Action Button -->
                            <div class="shortcut-btn">
                                <span>Buka Modul</span>
                                <svg width="14" height="14" style="width: 14px; height: 14px; display: block;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 32px; background-color: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;" class="dark:bg-gray-900/30 dark:border-gray-800">
                    <svg width="40" height="40" style="width: 40px; height: 40px; margin: 0 auto 12px auto; color: #94a3b8; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <p style="font-size: 14px; font-weight: 600; color: #475569; margin: 0;" class="dark:text-gray-400">Hak Akses Modul Belum Dikonfigurasi</p>
                    <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;" class="dark:text-gray-500">Anda belum memiliki izin aktif untuk modul administratif. Silakan hubungi Administrator utama.</p>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
