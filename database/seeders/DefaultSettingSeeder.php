<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DefaultSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // General
            ['key' => 'site_name',        'value' => 'PPID SMKN 2 Sumedang',            'type' => 'string',  'group' => 'general'],
            ['key' => 'site_tagline',     'value' => 'Keterbukaan Informasi Publik',    'type' => 'string',  'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Portal Resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) SMK Negeri 2 Sumedang. Memberikan akses informasi publik secara cepat, mudah, akuntabel, dan transparan.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'logo_url',         'value' => 'images/logo-smea.svg',            'type' => 'image',   'group' => 'appearance'],
            ['key' => 'favicon_url',      'value' => 'favicon.ico',                     'type' => 'image',   'group' => 'appearance'],
            ['key' => 'primary_color',    'value' => '#3d60a1',                         'type' => 'string',  'group' => 'appearance'],
            // Contact
            ['key' => 'contact_address',  'value' => 'Jl. Arief Rakhman Hakim No. 59, Situ, Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45323', 'type' => 'text',    'group' => 'contact'],
            ['key' => 'contact_phone',    'value' => '(0261) 201531',                   'type' => 'string',  'group' => 'contact'],
            ['key' => 'contact_email',    'value' => 'smkn2sumedang@yahoo.com',         'type' => 'string',  'group' => 'contact'],
            ['key' => 'contact_hours',    'value' => 'Senin - Jumat, 07:00 - 15:30 WIB', 'type' => 'string',  'group' => 'contact'],
            ['key' => 'contact_map_embed','value' => 'https://maps.google.com/maps?q=SMK%20Negeri%202%20Sumedang,%20Jl.%20Arief%20Rakhman%20Hakim%20No.%2059,%20Situ,%20Sumedang%20Utara,%20Kabupaten%20Sumedang&t=&z=15&ie=UTF8&iwloc=&output=embed', 'type' => 'text', 'group' => 'contact'],
            // Social
            ['key' => 'social_facebook',  'value' => 'https://www.facebook.com/officialsmkn2sumedang.sch.id', 'type' => 'string', 'group' => 'social'],
            ['key' => 'social_twitter',   'value' => 'https://x.com/gridazofficial', 'type' => 'string', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/smkn2sumedang.official/', 'type' => 'string', 'group' => 'social'],
            ['key' => 'social_youtube',   'value' => 'https://www.youtube.com/channel/UCvwVhIQrFLJmf2_kWZi1c7Q', 'type' => 'string', 'group' => 'social'],
            // Legal
            ['key' => 'privacy_policy',   'value' => null, 'type' => 'text',   'group' => 'legal'],
            ['key' => 'terms_of_use',     'value' => null, 'type' => 'text',   'group' => 'legal'],
            ['key' => 'complaint_notice', 'value' => 'Data pribadi Anda dilindungi sesuai UU Perlindungan Data Pribadi.', 'type' => 'text', 'group' => 'legal'],
            // Admin
            ['key' => 'department_name',  'value' => 'SMK Negeri 2 Sumedang',           'type' => 'string',  'group' => 'general'],
            ['key' => 'letter_department','value' => 'SMKN2-SMD',                       'type' => 'string',  'group' => 'general'],
            // Profile Page
            ['key' => 'profile_title',        'value' => 'Profil PPID SMKN 2 Sumedang', 'type' => 'string', 'group' => 'general'],
            ['key' => 'profile_subtitle',     'value' => 'Pelayanan Keterbukaan Informasi Publik di Lingkungan SMK Negeri 2 Sumedang.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'profile_header_image', 'value' => null,                                  'type' => 'image',  'group' => 'appearance'],
            ['key' => 'profile_history',      'value' => '<p>PPID (Pejabat Pengelola Informasi dan Dokumentasi) SMK Negeri 2 Sumedang dibentuk sebagai wujud komitmen sekolah dalam mendukung keterbukaan informasi publik dan akuntabilitas penyelenggaraan pendidikan kejuruan. Pembentukan ini didasari oleh amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik (KIP).</p><p>Sebagai salah satu sekolah kejuruan negeri terkemuka di Jawa Barat, kami bertekad untuk menyajikan pelayanan informasi yang cepat, mudah, akuntabel, dan transparan bagi siswa, orang tua murid, alumni, komite sekolah, mitra dunia industri, serta masyarakat umum demi kemajuan mutu pendidikan di lingkungan SMKN 2 Sumedang.</p>', 'type' => 'text', 'group' => 'general'],
            ['key' => 'profile_vision',       'value' => 'Terwujudnya pelayanan informasi publik SMK Negeri 2 Sumedang yang transparan, profesional, akuntabel, dan terintegrasi untuk mendukung penyelenggaraan pendidikan kejuruan yang unggul, berkarakter, dan berdaya saing global.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'profile_mission',      'value' => '<ul class="space-y-3"><li>Menyelenggarakan sistem pengelolaan dokumen dan arsip sekolah secara tertib, terpadu, dan transparan.</li><li>Mengembangkan layanan informasi publik berbasis teknologi informasi digital yang mudah diakses oleh seluruh pemangku kepentingan.</li><li>Meningkatkan kapasitas dan integritas SDM pengelola PPID di lingkungan SMK Negeri 2 Sumedang.</li><li>Menjamin aksesibilitas layanan informasi bagi seluruh publik dan mitra industri secara berkeadilan.</li></ul>', 'type' => 'text', 'group' => 'general'],
            ['key' => 'profile_head_name',    'value' => 'Dr. Elis Herawati, M.Pd.',             'type' => 'string', 'group' => 'general'],
            ['key' => 'profile_head_title',   'value' => 'Kepala Sekolah SMKN 2 Sumedang',      'type' => 'string', 'group' => 'general'],
            ['key' => 'profile_head_message', 'value' => '"Keterbukaan informasi adalah pilar utama akuntabilitas sekolah. Melalui PPID SMKN 2 Sumedang, kami berkomitmen memberikan pelayanan informasi yang cepat, mudah, akuntabel, dan transparan bagi masyarakat dan seluruh warga sekolah guna mewujudkan Gridas Ceria dan sekolah kejuruan yang tangguh."', 'type' => 'text', 'group' => 'general'],
            ['key' => 'profile_head_image',   'value' => null,                                  'type' => 'image',  'group' => 'appearance'],
        ];

        foreach ($defaults as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type'  => $setting['type'],
                    'group' => $setting['group']
                ]
            );
        }

        $this->command->info('Default settings seeded successfully for SMKN 2 Sumedang!');
    }
}
