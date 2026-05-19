<div style="min-height: 100vh; display: flex; flex-direction: row; font-family: system-ui, -apple-system, sans-serif; background-color: #ffffff;" class="dark:bg-slate-950">
    <style>
        .login-left-pane {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 50%;
            padding: 64px;
            background: linear-gradient(135deg, #090d16 0%, #020617 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .login-right-pane {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50%;
            padding: 48px;
            background-color: #f8fafc;
        }
        .dark .login-right-pane {
            background-color: #070a13;
        }
        
        .login-glow-orb-1 {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background-color: rgba(59, 130, 246, 0.12);
            border-radius: 9999px;
            filter: blur(80px);
            pointer-events: none;
        }
        .login-glow-orb-2 {
            position: absolute;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background-color: rgba(99, 102, 241, 0.12);
            border-radius: 9999px;
            filter: blur(100px);
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            padding: 48px;
            transition: all 0.3s ease;
        }
        .dark .login-card {
            background-color: #0f1322;
            border-color: #1e293b;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            background-color: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #60a5fa;
            width: fit-content;
        }

        @media (max-width: 1024px) {
            .login-left-pane {
                display: none;
            }
            .login-right-pane {
                width: 100%;
                padding: 24px;
            }
            .login-card {
                padding: 36px 24px;
            }
        }
    </style>

    <!-- Left Column: Visual Brand Showcase -->
    <div class="login-left-pane">
        <!-- Glow Orbs -->
        <div class="login-glow-orb-1"></div>
        <div class="login-glow-orb-2"></div>

        <!-- Top Brand Label -->
        <div style="z-index: 10;">
            <div class="brand-badge">
                Sistem Portal PPID Resmi
            </div>
            
            <div style="display: flex; align-items: center; gap: 14px; margin-top: 32px;">
                <div style="width: 52px; height: 52px; background-color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4); flex-shrink: 0;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h1 style="font-size: 26px; font-weight: 850; tracking-tight: -0.03em; margin: 0; color: #ffffff; line-height: 1;">PPID Portal</h1>
                    <span style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Pemerintah Daerah</span>
                </div>
            </div>
        </div>

        <!-- Middle Showcase Text -->
        <div style="z-index: 10; margin: 40px 0;">
            <h2 style="font-size: 36px; font-weight: 800; tracking-tight: -0.025em; line-height: 1.15; color: #ffffff; margin: 0;">
                Terbuka, Transparan, <br>dan Tepercaya.
            </h2>
            <p style="font-size: 15px; color: #94a3b8; margin: 20px 0 0 0; line-height: 1.6; max-w: 460px;">
                Selamat datang di Panel Administrasi Pejabat Pengelola Informasi dan Dokumentasi (PPID). Sistem satu pintu untuk publikasi informasi berkala, penyelesaian aduan masyarakat, penyusunan surat resmi, dan transparansi publik yang akuntabel.
            </p>
        </div>

        <!-- Bottom Footer -->
        <div style="z-index: 10; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 24px;">
            <div style="font-size: 11px; color: #475569;">
                &copy; {{ date('Y') }} Portal PPID. Hak Cipta Dilindungi.
            </div>
            <div style="display: flex; align-items: center; gap: 4px; font-size: 11px; color: #3b82f6; font-weight: 700; letter-spacing: 0.05em;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                SSL SECURED
            </div>
        </div>
    </div>

    <!-- Right Column: Login Form Container -->
    <div class="login-right-pane">
        <div class="login-card">
            <!-- Header inside card -->
            <div style="text-align: center; margin-bottom: 36px;">
                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; tracking-tight: -0.025em;" class="dark:text-white">
                    Masuk ke Sistem
                </h2>
                <p style="font-size: 13px; color: #64748b; margin: 8px 0 0 0;" class="dark:text-gray-400">
                    Masukkan alamat email & kata sandi akun administratif Anda
                </p>
            </div>

            <!-- Filament/Livewire Auth Form -->
            {{ $this->content }}
        </div>
    </div>
</div>
