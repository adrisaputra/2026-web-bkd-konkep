<?php

namespace Tests\Feature;

use Tests\TestCase;

class MenuPagesTest extends TestCase
{
    public function test_each_menu_page_uses_the_bootstrap_layout(): void
    {
        $paths = [
            '/',
            '/profil-sejarah',
            '/profil-visimisi',
            '/profil-struktur',
            '/profil-tupoksi',
            '/layanan-pangkat',
            '/layanan-pensiun',
            '/layanan-cuti',
            '/layanan-mutasi',
            '/layanan-disiplin',
            '/info-pengumuman',
            '/info-produkhukum',
            '/info-galeri',
            '/info-faq',
            '/transparansi-lakip',
            '/transparansi-renstra',
            '/transparansi-ziwbk',
            '/kontak',
        ];

        foreach ($paths as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('navbar-expand-lg')
                ->assertSee('dropdown-menu')
                ->assertDontSee('switchTab');
        }
    }
}
