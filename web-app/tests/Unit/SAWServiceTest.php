<?php

namespace Tests\Unit;

use App\Services\SAWService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Unit Test untuk App\Services\SAWService
 *
 * Menguji perilaku SAWService saat berkomunikasi dengan engine Python.
 * Menggunakan Http::fake() untuk mensimulasikan response tanpa koneksi nyata.
 */
class SAWServiceTest extends TestCase
{
    // =========================================================================
    // HELPER: Data dummy untuk test
    // =========================================================================

    /**
     * Membuat koleksi kafe palsu menggunakan anonymous class
     * agar tidak bergantung pada database (sesuai prinsip unit test).
     */
    private function makeFakeCafes(): Collection
    {
        $cafe = new class {
            public int $id_kafe = 1;
            public string $nama_kafe = 'Kafe Ujicoba';
            public string $alamat = 'Jl. Kampus No. 1';
            public float $rating = 4.2;
            public float $jarak = 0.8;
            public int $harga_min = 15000;
            public int $harga_max = 40000;
            public string $jam_buka = '08:00:00';
            public string $jam_tutup = '22:00:00';
            public $gambar = null;
            public $fasilitas = null;
            public $menus = null;

            /** Simulasi method Eloquent tanpa DB */
            public function relationLoaded(string $relation): bool
            {
                return false;
            }
        };

        return collect([$cafe]);
    }

    /**
     * Bobot default untuk kriteria SAW (jumlah harus 1.0).
     */
    private function makeBobot(): array
    {
        return [
            'harga'           => 0.2,
            'rating'          => 0.3,
            'jarak'           => 0.2,
            'fasilitas'       => 0.1,
            'menu'            => 0.1,
            'jam_operasional' => 0.1,
        ];
    }

    /**
     * Response JSON sukses dari engine Python.
     */
    private function fakeEngineSuccessResponse(): array
    {
        return [
            'hasil' => [
                [
                    'id_kafe'   => 1,
                    'nama_kafe' => 'Kafe Ujicoba',
                    'skor'      => 0.87,
                    'rating'    => 4.2,
                    'jarak'     => 0.8,
                    'harga_min' => 15000,
                    'harga_max' => 40000,
                ],
            ],
            'matriks' => [
                ['id_kafe' => 1, 'harga' => 0.5, 'rating' => 0.84],
            ],
            'normalisasi' => [
                ['id_kafe' => 1, 'harga' => 1.0, 'rating' => 1.0],
            ],
        ];
    }

    // =========================================================================
    // POSITIF: Engine berhasil merespons
    // =========================================================================

    /**
     * @test
     * Ketika engine sukses (HTTP 200), hasil calculate() harus memiliki
     * tiga kunci utama: 'hasil', 'matriks', 'normalisasi'.
     */
    public function saat_engine_sukses_hasil_memiliki_tiga_kunci_utama(): void
    {
        Http::fake([
            '*' => Http::response($this->fakeEngineSuccessResponse(), 200),
        ]);

        $service = new SAWService();
        $result  = $service->calculate($this->makeFakeCafes(), $this->makeBobot());

        $this->assertArrayHasKey('hasil', $result);
        $this->assertArrayHasKey('matriks', $result);
        $this->assertArrayHasKey('normalisasi', $result);
    }

    /**
     * @test
     * Hasil dari engine harus di-mapping dengan menambahkan
     * key 'rating_raw' dan 'jarak_km' pada setiap item 'hasil'.
     */
    public function saat_engine_sukses_hasil_memiliki_mapping_rating_raw_dan_jarak_km(): void
    {
        Http::fake([
            '*' => Http::response($this->fakeEngineSuccessResponse(), 200),
        ]);

        $service    = new SAWService();
        $result     = $service->calculate($this->makeFakeCafes(), $this->makeBobot());
        $firstHasil = $result['hasil']->first();

        // SAWService memetakan rating → rating_raw, jarak → jarak_km (SAWService.php:48-50)
        $this->assertArrayHasKey('rating_raw', $firstHasil);
        $this->assertArrayHasKey('jarak_km', $firstHasil);
        $this->assertEquals(4.2, $firstHasil['rating_raw']);
        $this->assertEquals(0.8, $firstHasil['jarak_km']);
    }

    /**
     * @test
     * Menguji kesiapan service mengirim data ekstrem (jarak ribuan km, harga negatif)
     * ke engine API dan memetakan response secara normal.
     */
    public function saat_payload_ekstrem_calculate_tetap_berjalan(): void
    {
        Http::fake([
            '*' => Http::response($this->fakeEngineSuccessResponse(), 200),
        ]);

        $extremeCafe = new class {
            public int $id_kafe = 2;
            public string $nama_kafe = 'Kafe Ekstrem';
            public string $alamat = 'Alamat Jauh';
            public float $rating = 5.5; 
            public float $jarak = 12000.5; 
            public int $harga_min = -1500; 
            public int $harga_max = 500000;
            public string $jam_buka = '08:00:00';
            public string $jam_tutup = '22:00:00';
            public $gambar = null;
            public $fasilitas = null;
            public $menus = null;

            public function relationLoaded(string $relation): bool
            {
                return false;
            }
        };

        $service = new SAWService();
        $result = $service->calculate(collect([$extremeCafe]), $this->makeBobot());

        $this->assertNotEmpty($result['hasil']);
        $this->assertEquals('Kafe Ujicoba', $result['hasil']->first()['nama_kafe']);
    }

    // =========================================================================
    // NEGATIF: Engine mengembalikan status error
    // =========================================================================

    /**
     * @test
     * Ketika engine mengembalikan HTTP 500, calculate() harus
     * melempar Exception dengan menyebut kode status.
     */
    public function saat_engine_error_500_melempar_exception(): void
    {
        Http::fake([
            '*' => Http::response(['error' => 'Internal Server Error'], 500),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/Engine returned status code 500/');

        $service = new SAWService();
        $service->calculate($this->makeFakeCafes(), $this->makeBobot());
    }

    /**
     * @test
     * Ketika koneksi ke engine gagal (tidak bisa terhubung),
     * calculate() harus melempar Exception dengan pesan "Gagal menghubungi engine".
     */
    public function saat_engine_tidak_bisa_dihubungi_melempar_exception(): void
    {
        // Simulasi koneksi ditolak / timeout
        Http::fake(function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection refused');
        });

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/Gagal menghubungi engine/');

        $service = new SAWService();
        $service->calculate($this->makeFakeCafes(), $this->makeBobot());
    }
}
