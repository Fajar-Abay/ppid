<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentCategoryType: string
{
    case InformasiBerkala    = 'informasi_berkala';
    case InformasiSertaMerta = 'informasi_serta_merta';
    case InformasiSetiapSaat = 'informasi_setiap_saat';
    case Berita              = 'berita';

    public function label(): string
    {
        return match($this) {
            self::InformasiBerkala    => 'Informasi Berkala',
            self::InformasiSertaMerta => 'Informasi Serta Merta',
            self::InformasiSetiapSaat => 'Informasi Setiap Saat',
            self::Berita              => 'Berita / Artikel',
        };
    }
}
