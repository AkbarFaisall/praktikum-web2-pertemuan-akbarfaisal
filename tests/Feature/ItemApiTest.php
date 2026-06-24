<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setiap kali test dijalankan

    protected $penggunaBiasa;
    protected $penggunaAdmin;
    protected $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat data kategori
        Category::factory()->create([
            "id" => 1,
            "name" => "Electronics"
        ]);

        // 2. Buat akun user biasa
        $this->penggunaBiasa = User::factory()->create([
            "role" => "user"
        ]);

        // 3. Buat akun admin
        $this->penggunaAdmin = User::factory()->create([
            "role" => "admin"
        ]);
    }

    // Test 1: Tamu (belum login) tidak bisa akses API
    public function test_guest_cannot_access_items()
    {
        
        $respon = $this->getJson("/api/v1/items");
        
        $respon->assertStatus(401);
    }

    // Test 2: User biasa bisa melihat daftar barang
    public function test_user_can_list_items()
    {
        $token = $this->penggunaBiasa->createToken("api-token")->plainTextToken;

        $this->withHeader("Authorization", "Bearer $token")
             ->getJson("/api/v1/items")
             ->assertStatus(200)
             ->assertJsonStructure([
                 "success", "data", "message" // Disesuaikan dengan respon API kita (success, bukan status)
             ]);
    }

    // Test 3: User biasa DITOLAK saat mencoba menghapus barang
    public function test_user_cannot_delete_item()
    {
        $token = $this->penggunaBiasa->createToken("api-token")->plainTextToken;

        $this->deleteJson(
            "/api/v1/items/1",
            [],
            ["Authorization" => "Bearer $token"]
        )->assertStatus(403); // 403 artinya Forbidden (Ditolak)
    }

    // Test 4: Admin DIIZINKAN untuk menghapus barang
    public function test_admin_can_delete_item()
    {
        // Buat satu barang palsu untuk dihapus
        $barang = \App\Models\Item::factory()->create(["category_id" => 1]);

        $token = $this->penggunaAdmin->createToken("api-token")->plainTextToken;

        $this->deleteJson(
            "/api/v1/items/{$barang->id}",
            [],
            ["Authorization" => "Bearer $token"]
        )->assertStatus(204); // 204 artinya No Content (Sukses dihapus)
    }
}