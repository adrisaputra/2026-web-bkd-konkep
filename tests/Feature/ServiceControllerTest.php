<?php

namespace Tests\Feature;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Group;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_service_admin(): void
    {
        $this->get('/service/layanan-cuti')
            ->assertRedirect('/');
    }

    public function test_index_displays_the_service_for_its_menu(): void
    {
        $this->createAdminLayoutSetting();

        $maliciousTitle = 'Layanan <script>alert(1)</script>';
        $service = Service::create([
            'title' => $maliciousTitle,
            'text' => '<p>Deskripsi layanan</p>',
            'condition' => '<p>Persyaratan layanan</p>',
            'url' => '/permohonan',
            'menu' => 'layanan-cuti',
        ]);
        $user = User::factory()->create();
        $user->setRelation('group', new Group(['name' => 'Operator']));

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs($user)
            ->get('/service/layanan-cuti')
            ->assertOk()
            ->assertViewIs('admin.service.index')
            ->assertViewHas('service', fn (Service $viewService): bool => $viewService->is($service))
            ->assertSee(e($maliciousTitle), false)
            ->assertDontSee($maliciousTitle, false);
    }

    public function test_index_returns_not_found_when_the_menu_has_no_service(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->get('/service/menu-tidak-ada')
            ->assertNotFound();
    }

    public function test_validation_rejects_a_missing_description(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->postJson('/service/validate', [], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['text']);
    }

    public function test_update_persists_service_content(): void
    {
        $service = Service::create([
            'title' => 'Layanan Cuti',
            'text' => 'Deskripsi lama',
            'condition' => 'Persyaratan lama',
            'url' => '/lama',
            'menu' => 'layanan-cuti',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->putJson('/service/edit/'.$service->id, [
                'text' => 'Deskripsi baru',
                'condition' => 'Persyaratan baru',
                'url' => '/baru',
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Ubah Data Berhasil',
            ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'text' => 'Deskripsi baru',
            'condition' => 'Persyaratan baru',
            'url' => '/baru',
            'title' => 'Layanan Cuti',
            'menu' => 'layanan-cuti',
        ]);
    }

    public function test_update_rejects_invalid_content_without_changing_the_service(): void
    {
        $service = Service::create([
            'title' => 'Layanan Cuti',
            'text' => 'Deskripsi lama',
            'condition' => 'Persyaratan lama',
            'url' => '/lama',
            'menu' => 'layanan-cuti',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->putJson('/service/edit/'.$service->id, [
                'text' => ['bukan teks'],
                'condition' => 'Persyaratan baru',
                'url' => '/baru',
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['text']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'text' => 'Deskripsi lama',
            'condition' => 'Persyaratan lama',
            'url' => '/lama',
        ]);
    }

    private function createAdminLayoutSetting(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('application_name')->nullable();
            $table->string('small_icon')->nullable();
            $table->timestamps();
        });

        Setting::create(['application_name' => 'Test Application']);
    }
}
