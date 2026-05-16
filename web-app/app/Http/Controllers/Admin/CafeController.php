<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasModel;
use App\Models\KafeModel;
use App\Models\KafeGambarModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = KafeModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kafe', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $cafes = $query->orderBy('id_kafe', 'asc')->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('admin.cafe._table', compact('cafes'))->render();
        }

        return view('admin.cafe.index', compact('cafes'));
    }

    public function create(Request $request)
    {
        $fasilitas = FasilitasModel::all();
        $menus = MenuModel::all();
        
        if ($request->ajax()) {
            return view('admin.cafe.partials.form', compact('fasilitas', 'menus'))->render();
        }

        return view('admin.cafe.create', compact('fasilitas', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kafe' => 'required|string|max:255',
            'harga_min' => 'required|numeric',
            'harga_max' => 'required|numeric',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        
        $data = $request->only([
            'nama_kafe', 'alamat', 'link_maps', 'harga_min', 'harga_max', 
            'rating', 'jarak', 'jam_buka', 'jam_tutup', 'deskripsi'
        ]);

        $kafe = KafeModel::create($data);

        
        if ($request->has('fasilitas')) {
            $kafe->fasilitas()->sync($request->fasilitas);
        }

      
        if ($request->has('menu')) {
            $kafe->menus()->sync($request->menu);
        }
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('kafe', 'public');
                $kafe->gambar()->create(['path_gambar' => $path]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data kafe berhasil ditambahkan']);
    }

    public function show($id, Request $request)
    {
        $kafe = KafeModel::with(['fasilitas', 'menus', 'gambar'])->findOrFail($id);

        if ($request->ajax()) {
            return view('admin.cafe.partials.detail', compact('kafe'))->render();
        }

        return view('admin.cafe.show', compact('kafe'));
    }

    public function edit($id, Request $request)
    {
        $kafe = KafeModel::with(['fasilitas', 'menus'])->findOrFail($id);
        $fasilitas = FasilitasModel::all();
        $menus = MenuModel::all();

        if ($request->ajax()) {
            return view('admin.cafe.partials.form', compact('kafe', 'fasilitas', 'menus'))->render();
        }

        return view('admin.cafe.edit', compact('kafe', 'fasilitas', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $kafe = KafeModel::findOrFail($id);
        
        $request->validate([
            'nama_kafe' => 'required|string|max:255',
            'harga_min' => 'required|numeric',
            'harga_max' => 'required|numeric',
        ]);

        $data = $request->only([
            'nama_kafe', 'alamat', 'link_maps', 'harga_min', 'harga_max', 
            'rating', 'jarak', 'jam_buka', 'jam_tutup', 'deskripsi'
        ]);

        $kafe->update($data);

       
        $kafe->fasilitas()->sync($request->fasilitas ?? []);
        
      
        $kafe->menus()->sync($request->menu ?? []);

        
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('kafe', 'public');
                $kafe->gambar()->create(['path_gambar' => $path]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data kafe berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kafe = KafeModel::findOrFail($id);
        
       
        foreach($kafe->gambar as $g) {
            Storage::disk('public')->delete($g->path_gambar);
        }
        
        $kafe->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function deleteImage($id)
    {
        $gambar = KafeGambarModel::findOrFail($id);
        Storage::disk('public')->delete($gambar->path_gambar);
        $gambar->delete();

        return response()->json(['success' => true]);
    }

    public function downloadTemplate()
    {
        // Bypass composer autoloader issue on PHP 8.5
        require_once base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');

        $data = [
            ['<b>No</b>', '<b>Nama</b>', '<b>Deskripsi</b>', '<b>Alamat</b>', '<b>Lokasi</b>', '<b>Harga Menu</b>', '<b>Variasi Menu</b>', '<b>Rating</b>', '<b>Jarak</b>', '<b>Fasilitas</b>', '<b>Jam Operasional</b>', '<b>Nomor</b>'],
            [
                1, 
                'Kafe Contoh Ngafein', 
                'Kafe ini sangat nyaman untuk bekerja dan nongkrong dengan teman.',
                'Jl. MT Haryono No. 123, Malang', 
                'https://maps.app.goo.gl/contoh', 
                'Rp25.000-50.000', 
                "- Coffee\n- Non-Coffee\n- Snack", 
                '4,5', 
                '1,2 km', 
                "- Indoor\n- Outdoor\n- Wifi\n- Colokan", 
                '08.00 - 23.00', 
                '08123456789'
            ]
        ];

        return SimpleXLSXGen::fromArray($data)->downloadAs('Template_Import_Kafe_Ngafein.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        // Bypass composer autoloader issue on PHP 8.5
        require_once base_path('vendor/shuchkin/simplexlsx/src/SimpleXLSX.php');

        $file = $request->file('file');
        $xlsx = SimpleXLSX::parse($file->getPathname());
        if (!$xlsx) {
            return response()->json(['success' => false, 'message' => SimpleXLSX::parseError()], 400);
        }

        $rows = $xlsx->rows();
        if (count($rows) <= 1) {
            return response()->json(['success' => false, 'message' => 'File Excel kosong atau tidak memiliki baris data.'], 400);
        }

        DB::beginTransaction();
        try {
            $fasilitasMapDB = FasilitasModel::pluck('id_fasilitas', 'nama_fasilitas')->toArray();
            $menuMapDB = MenuModel::pluck('id_menu', 'nama_menu')->toArray();

            $insertedCount = 0;
            $updatedCount = 0;
            foreach ($rows as $index => $row) {
                if ($index == 0) continue; // skip header

                $nama = trim(strval($row[1] ?? ''));
                if (empty($nama)) continue;

                $deskripsi = trim(strval($row[2] ?? ''));
                $alamat = trim(strval($row[3] ?? ''));
                $linkMaps = trim(strval($row[4] ?? ''));
                $hargaStr = trim(strval($row[5] ?? ''));
                $menuStr = trim(strval($row[6] ?? ''));
                $ratingStr = trim(strval($row[7] ?? ''));
                $jarakStr = trim(strval($row[8] ?? ''));
                $fasilitasStr = trim(strval($row[9] ?? ''));
                $jamStr = trim(strval($row[10] ?? ''));

                [$hargaMin, $hargaMax] = $this->parsePriceRange($hargaStr);
                $rating = floatval(str_replace(',', '.', $ratingStr));
                $jarak = $this->parseDistance($jarakStr);
                [$jamBuka, $jamTutup] = $this->parseJam($jamStr);

                $kafe = KafeModel::updateOrCreate(
                    ['nama_kafe' => $nama],
                    [
                        'deskripsi' => $deskripsi ?: '-',
                        'alamat' => $alamat ?: '-',
                        'link_maps' => $linkMaps ?: '-',
                        'harga_min' => $hargaMin,
                        'harga_max' => $hargaMax,
                        'rating' => $rating,
                        'jarak' => $jarak,
                        'jam_buka' => $jamBuka,
                        'jam_tutup' => $jamTutup
                    ]
                );

                if ($kafe->wasRecentlyCreated) {
                    $insertedCount++;
                } else {
                    $updatedCount++;
                }

                // Sync Fasilitas
                $fasilitasIds = [];
                foreach ($this->splitItems($fasilitasStr) as $item) {
                    $norm = $this->normalizeFasilitas($item);
                    if (!$norm) continue;

                    if (isset($fasilitasMapDB[$norm])) {
                        $fasilitasIds[] = $fasilitasMapDB[$norm];
                    } else {
                        if (strlen($norm) >= 3) {
                            $maxId = FasilitasModel::max('id_fasilitas') ?? 0;
                            $newId = $maxId + 1;
                            FasilitasModel::create([
                                'id_fasilitas' => $newId,
                                'nama_fasilitas' => $norm
                            ]);
                            $fasilitasMapDB[$norm] = $newId;
                            $fasilitasIds[] = $newId;
                        }
                    }
                }
                if (!empty($fasilitasIds)) {
                    $kafe->fasilitas()->sync(array_unique($fasilitasIds));
                }

                // Sync Menu
                $menuIds = [];
                foreach ($this->splitItems($menuStr) as $item) {
                    $normMenu = $this->normalizeMenu($item);
                    if (isset($menuMapDB[$normMenu])) {
                        $menuIds[] = $menuMapDB[$normMenu];
                    }
                }
                if (!empty($menuIds)) {
                    $kafe->menus()->sync(array_unique($menuIds));
                }
            }

            DB::commit();
            $msg = "Proses selesai! (Data Baru: $insertedCount, Diperbarui: $updatedCount)";
            if ($insertedCount === 0 && $updatedCount === 0) {
                $msg = "Tidak ada data valid yang diproses.";
            }
            return response()->json(['success' => true, 'message' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal mengimpor data: ' . $e->getMessage()], 500);
        }
    }

    private function splitItems($text)
    {
        if (empty($text)) return [];
        $lines = preg_split('/[\n,;|]+/', strval($text));
        $cleaned = [];
        foreach ($lines as $line) {
            $l = trim($line);
            if (str_starts_with($l, '-')) {
                $l = trim(substr($l, 1));
            }
            if ($l !== '') {
                $cleaned[] = $l;
            }
        }
        return $cleaned;
    }

    private function parsePriceRange($priceStr)
    {
        if (empty($priceStr)) return [0, 0];
        $text = strtolower(strval($priceStr));
        $text = str_replace(['rp', '.'], '', $text);
        preg_match_all('/\d+/', $text, $matches);
        $numbers = $matches[0];
        if (empty($numbers)) return [0, 0];
        
        $numbers = array_map(fn($n) => intval($n), $numbers);
        $normalize = fn($n) => ($n < 1000 && $n > 0) ? $n * 1000 : $n;
        
        if (count($numbers) == 1) {
            $val = $normalize($numbers[0]);
            return [$val, $val];
        }
        
        $min = $normalize($numbers[0]);
        $max = $normalize($numbers[1]);
        if ($min > $max && $max > 0) {
            $tmp = $min; $min = $max; $max = $tmp;
        }
        return [$min, $max];
    }

    private function parseDistance($distStr)
    {
        if (empty($distStr)) return 0.0;
        $text = strtolower(str_replace(',', '.', strval($distStr)));
        preg_match('/[\d.]+/', $text, $matches);
        if (empty($matches[0])) return 0.0;
        $val = floatval($matches[0]);
        if (str_contains($text, 'km')) {
            return $val;
        }
        if (str_contains($text, 'm')) {
            return $val / 1000.0;
        }
        return $val;
    }

    private function parseJam($jamStr)
    {
        if (empty($jamStr)) return ['00:00', '00:00'];
        $text = strtolower(strval($jamStr));
        if (str_contains($text, '24')) {
            return ['00:00', '23:59'];
        }
        $text = str_replace('.', ':', $text);
        $parts = explode('-', $text);
        if (count($parts) >= 2) {
            return [trim($parts[0]), trim($parts[1])];
        }
        return ['00:00', '00:00'];
    }

    private function normalizeFasilitas($text)
    {
        $text = strtolower(trim($text));
        $mapping = [
            "wi" => "wifi",
            "fi" => "wifi",
            "wifi." => "wifi",
            "wi-fi" => "wifi",
            "free wifi" => "wifi",

            "stopkontak" => "colokan",
            "colokan." => "colokan",
            "colokan (tanpa mushola" => "colokan",

            "area parkir" => "parkir",
            "tempat parkir" => "parkir",
            "parkir." => "parkir",
            "parkir luas" => "parkir",
            "parkir (valet)" => "parkir",

            "musholla" => "mushola",
            "musola" => "mushola",

            "kamar mandi" => "toilet",

            "ac (indoor)" => "indoor",
            "ac(indoor)" => "indoor",
            "indoor (ac)" => "indoor",
            "indoor ac" => "indoor",
            "indoor (kipas)" => "indoor",
            "ac" => "indoor",

            "outdoor (luas)" => "outdoor",
            "outdoor khusus)." => "outdoor",
            "outdoor & semi" => "outdoor",

            "semi" => "semi_outdoor",
            "semi outdoor" => "semi_outdoor",
            "semioutdoor" => "semi_outdoor",
            "semi-outdoor" => "semi_outdoor",

            "smooking area" => "smoking_area",
            "smoking area" => "smoking_area",
            "smooking area indoor" => "smoking_indoor",
            "indoor smoking" => "smoking_indoor",

            "working space" => "workspace",
            "social space" => "workspace",

            "live music" => "live_music",
            "stage live music&event" => "live_music",

            "meeting room" => "meeting_room",
            "private room" => "private_room",
            "vip room" => "vip_room",

            "rooftop 360°" => "rooftop",
            "rooftop" => "rooftop",
            "shisha area" => "shisha",
            "shisha" => "shisha",
            "playground anak" => "playground",
            "playground" => "playground",
        ];

        $result = $mapping[$text] ?? $text;

        $blacklist = [
            "area setting",
            "beberapa kursi sofa",
            "merchandise"
        ];

        if (in_array($result, $blacklist)) {
            return null;
        }

        return $result;
    }

    private function normalizeMenu($text)
    {
        $text = strtolower(trim($text));
        
        if (str_contains($text, "non coffee") || str_contains($text, "non-coffee") || str_contains($text, "nonkopi") || str_contains($text, "non kopi") || str_contains($text, "juice") || str_contains($text, "jus") || str_contains($text, "minuman") || str_contains($text, "drink") || str_contains($text, "squash") || str_contains($text, "smoothies")) {
            return "non_coffee";
        }

        if (str_contains($text, "coffee") || str_contains($text, "kopi") || str_contains($text, "espresso") || str_contains($text, "latte") || str_contains($text, "cappuccino")) {
            return "coffee";
        }

        if (str_contains($text, "tea") || str_contains($text, "teh")) {
            return "tea";
        }

        if (str_contains($text, "rice") || str_contains($text, "bowl") || str_contains($text, "mie") || str_contains($text, "ramen") || str_contains($text, "burger") || str_contains($text, "steak") || str_contains($text, "main") || str_contains($text, "food") || str_contains($text, "makanan") || str_contains($text, "dining") || str_contains($text, "nasi") || str_contains($text, "spaghetti") || str_contains($text, "pasta") || str_contains($text, "indonesia") || str_contains($text, "western") || str_contains($text, "bakso")) {
            return "food";
        }

        if (str_contains($text, "dessert") || str_contains($text, "cake") || str_contains($text, "gelato") || str_contains($text, "ice cream") || str_contains($text, "es krim") || str_contains($text, "manis") || str_contains($text, "waffle")) {
            return "dessert";
        }

        if (str_contains($text, "snack") || str_contains($text, "pastry") || str_contains($text, "croissant") || str_contains($text, "roti") || str_contains($text, "kentang") || str_contains($text, "french fries") || str_contains($text, "camilan") || str_contains($text, "gorengan") || str_contains($text, "platter")) {
            return "snack";
        }

        return "other";
    }
}