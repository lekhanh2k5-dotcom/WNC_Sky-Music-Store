<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm với SEARCH & FILTER (dùng cho /shop)
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // 1. SEARCH theo tên bài hát, tác giả
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('author', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 2. FILTER theo quốc gia/khu vực
        if ($request->filled('country') && $request->country != 'all') {
            $query->where('country_region', $request->country);
        }

        // 3. FILTER theo khoảng giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 4. SORT (sắp xếp)
        $sortBy = $request->get('sort', 'newest');

        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->orderBy('downloads_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 5. PAGINATION (12 sản phẩm/trang)
        $products = $query->paginate(12)->withQueryString();

        // 6. Lấy danh sách countries/regions
        $countries = Product::select('country_region')
            ->distinct()
            ->whereNotNull('country_region')
            ->where('is_active', true)
            ->orderBy('country_region')
            ->pluck('country_region');

        // Hiển thị view shop
        return view('page.shop.index', compact('products', 'countries'));
    }

    /**
     * Hiển thị chi tiết sản phẩm (dùng cho /shop/{id})
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        // Sản phẩm liên quan (cùng quốc gia hoặc cùng tác giả)
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('country_region', $product->country_region)
                      ->orWhere('author', $product->author);
            })
            ->limit(4)
            ->get();

        return view('page.shop.detail', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for creating a new resource (Admin)
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'music_file' => 'required|file|mimes:txt,json|max:2048',
            'name' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'transcribed_by' => 'nullable|string|max:255',
            'country_region' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'youtube_url' => 'nullable|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $file = $request->file('music_file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Tạo thư mục theo quốc gia
        $countryFolder = $this->getCountryFolder($request->input('country_region'));
        $uploadPath = 'songs/' . $countryFolder;
        if (!is_dir(public_path($uploadPath))) {
            mkdir(public_path($uploadPath), 0755, true);
        }

        // Lưu file nhạc
        $file->move(public_path($uploadPath), $fileName);
        $filePath = $uploadPath . '/' . $fileName;

        // Xử lý upload ảnh (nếu có)
        $imagePath = null;
        if ($request->hasFile('cover_image')) {
            $imageFile = $request->file('cover_image');
            $imageName = time() . '_cover_' . $imageFile->getClientOriginalName();

            // Tạo thư mục cho ảnh
            $imageUploadPath = 'images/covers/' . $countryFolder;
            if (!is_dir(public_path($imageUploadPath))) {
                mkdir(public_path($imageUploadPath), 0755, true);
            }

            // Lưu ảnh
            $imageFile->move(public_path($imageUploadPath), $imageName);
            $imagePath = $imageUploadPath . '/' . $imageName;
        }

        // Tạo sản phẩm mới với thông tin từ form
        Product::create([
            'name' => $request->input('name'),
            'author' => $request->input('author') ?: 'Chưa xác định',
            'transcribed_by' => $request->input('transcribed_by') ?: 'Admin',
            'country_region' => $request->input('country_region'),
            'file_path' => $filePath,
            'image_path' => $imagePath,
            'price' => $request->input('price'),
            'youtube_demo_url' => $request->input('youtube_url'),
            'downloads_count' => 0,
            'is_active' => $request->boolean('is_active', false)
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm bản nhạc mới thành công!');
    }

    /**
     * Show the form for editing the specified resource (Admin)
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage (Admin)
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'music_file' => 'nullable|file|mimes:txt,json|max:2048',
                'name' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'transcribed_by' => 'nullable|string|max:255',
                'country_region' => 'required|string|max:100',
                'price' => 'required|numeric|min:0',
                'youtube_url' => 'nullable|url',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'is_active' => 'nullable|boolean'
            ]);

            // Xử lý upload file mới (nếu có)
            if ($request->hasFile('music_file')) {
                // Xóa file cũ
                if ($product->file_path && file_exists(public_path($product->file_path))) {
                    unlink(public_path($product->file_path));
                }

                $file = $request->file('music_file');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Tạo thư mục theo quốc gia
                $countryFolder = $this->getCountryFolder($request->input('country_region'));
                $uploadPath = 'songs/' . $countryFolder;
                if (!is_dir(public_path($uploadPath))) {
                    mkdir(public_path($uploadPath), 0755, true);
                }

                // Lưu file nhạc
                $file->move(public_path($uploadPath), $fileName);
                $product->file_path = $uploadPath . '/' . $fileName;
            }

            // Xử lý upload ảnh mới (nếu có)
            if ($request->hasFile('cover_image')) {
                // Xóa ảnh cũ
                if ($product->image_path && file_exists(public_path($product->image_path))) {
                    unlink(public_path($product->image_path));
                }

                $imageFile = $request->file('cover_image');
                $imageName = time() . '_cover_' . $imageFile->getClientOriginalName();

                // Tạo thư mục cho ảnh
                $countryFolder = $this->getCountryFolder($request->input('country_region'));
                $imageUploadPath = 'images/covers/' . $countryFolder;
                if (!is_dir(public_path($imageUploadPath))) {
                    mkdir(public_path($imageUploadPath), 0755, true);
                }

                // Lưu ảnh
                $imageFile->move(public_path($imageUploadPath), $imageName);
                $product->image_path = $imageUploadPath . '/' . $imageName;
            }

            // Cập nhật thông tin sản phẩm
            $product->update([
                'name' => $request->input('name'),
                'author' => $request->input('author') ?: 'Chưa xác định',
                'transcribed_by' => $request->input('transcribed_by') ?: 'Admin',
                'country_region' => $request->input('country_region'),
                'price' => $request->input('price'),
                'youtube_demo_url' => $request->input('youtube_url'),
                'is_active' => $request->boolean('is_active', false)
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Đã cập nhật bản nhạc "' . $product->name . '" thành công!');
        } catch (\Exception $e) {
            Log::error('Update product error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật bản nhạc. Vui lòng thử lại.');
        }
    }

    /**
     * Remove the specified resource from storage (Admin)
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Xóa file nhạc nếu tồn tại
            if ($product->file_path && file_exists(public_path($product->file_path))) {
                unlink(public_path($product->file_path));
            }

            // Xóa ảnh cover nếu tồn tại
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }

            // Xóa bản ghi trong database
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Đã xóa bản nhạc "' . $product->name . '" thành công!');
        } catch (\Exception $e) {
            Log::error('Delete product error: ' . $e->getMessage());

            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi xóa bản nhạc. Vui lòng thử lại.');
        }
    }

    /**
     * API endpoint để preview thông tin từ file upload
     */
    public function previewFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:txt,json|max:2048'
            ]);

            $file = $request->file('file');
            $content = file_get_contents($file->getPathname());
            $fileName = $file->getClientOriginalName();

            // Parse thông tin từ file
            $parsedInfo = $this->parseFileInfo($content, $fileName);

            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $parsedInfo['name'],
                    'author' => $parsedInfo['author'],
                    'transcribed_by' => $parsedInfo['transcribed_by'],
                    'file_name' => $fileName,
                    'file_size' => $this->formatFileSize($file->getSize())
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('File preview error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Không thể đọc file. Vui lòng kiểm tra định dạng file.'
            ], 400);
        }
    }

    /**
     * Get folder name based on country
     */
    private function getCountryFolder($country)
    {
        $folders = [
            'Việt Nam' => 'vietnam',
            'Hàn Quốc' => 'korea',
            'Nhật Bản' => 'japan',
            'Trung Quốc' => 'china',
            'Âu Mỹ' => 'western',
            'Khác' => 'others'
        ];

        return $folders[$country] ?? 'others';
    }

    /**
     * Parse file info from content
     */
    private function parseFileInfo($content, $fileName)
    {
        // Mặc định lấy tên từ filename
        $name = pathinfo($fileName, PATHINFO_FILENAME);
        $author = 'Chưa xác định';
        $transcribed_by = 'Admin';

        // Làm sạch content và xử lý encoding
        $cleanContent = $content;

        Log::info('Raw file analysis:', [
            'contentLength' => strlen($cleanContent),
            'firstBytes' => bin2hex(substr($cleanContent, 0, 10)),
            'fileName' => $fileName
        ]);

        // Phát hiện và xử lý các loại BOM
        $boms = [
            "\xFF\xFE\x00\x00" => 'UTF-32 LE BOM',
            "\x00\x00\xFE\xFF" => 'UTF-32 BE BOM',
            "\xFF\xFE" => 'UTF-16 LE BOM',
            "\xFE\xFF" => 'UTF-16 BE BOM',
            "\xEF\xBB\xBF" => 'UTF-8 BOM',
        ];

        $detectedBom = null;
        foreach ($boms as $bom => $type) {
            if (substr($cleanContent, 0, strlen($bom)) === $bom) {
                $cleanContent = substr($cleanContent, strlen($bom));
                $detectedBom = $type;
                Log::info("Detected and removed {$type} from file content");
                break;
            }
        }

        // Xử lý encoding
        if ($detectedBom === 'UTF-16 LE BOM' || (!$detectedBom && !mb_check_encoding($cleanContent, 'UTF-8'))) {
            $encoding = mb_detect_encoding($cleanContent, ['UTF-16LE', 'UTF-16BE', 'UTF-32LE', 'UTF-32BE'], true);

            if ($encoding) {
                $cleanContent = mb_convert_encoding($cleanContent, 'UTF-8', $encoding);
                Log::info("Converted content from {$encoding} to UTF-8");
            } else if (!mb_check_encoding($cleanContent, 'UTF-8')) {
                $encoding = mb_detect_encoding($cleanContent, ['ISO-8859-1', 'Windows-1252', 'ASCII'], true);
                if ($encoding) {
                    $cleanContent = mb_convert_encoding($cleanContent, 'UTF-8', $encoding);
                    Log::info("Fallback: Converted content from {$encoding} to UTF-8");
                }
            }
        }

        // Chuẩn hóa line endings
        $cleanContent = str_replace(["\r\n", "\r"], "\n", $cleanContent);
        $cleanContent = trim($cleanContent);

        // Xử lý các ký tự ẩn
        $cleanContent = preg_replace('/^[\x00-\x1F\x7F]+/', '', $cleanContent);
        $cleanContent = preg_replace('/[\x00-\x1F\x7F]+$/', '', $cleanContent);
        $cleanContent = trim($cleanContent);

        Log::info('Attempting to parse file:', [
            'fileName' => $fileName,
            'contentLength' => strlen($cleanContent),
            'contentStart' => substr($cleanContent, 0, 200),
        ]);

        // Thử parse JSON
        $jsonData = json_decode($cleanContent, true);
        $jsonError = json_last_error();

        if ($jsonError === JSON_ERROR_NONE && is_array($jsonData)) {
            Log::info('JSON parsed successfully');

            if (isset($jsonData[0]) && is_array($jsonData[0])) {
                $songData = $jsonData[0];
            } else {
                $songData = $jsonData;
            }

            if (isset($songData['name']) && !empty(trim($songData['name']))) {
                $name = trim($songData['name']);
            }

            if (isset($songData['author']) && !empty(trim($songData['author']))) {
                $author = trim($songData['author']);
            }

            if (isset($songData['transcribedBy']) && !empty(trim($songData['transcribedBy']))) {
                $transcribed_by = trim($songData['transcribedBy']);
            }
        } else {
            // Parse như text
            if (preg_match('/name[:\s]+(.*)/i', $content, $matches)) {
                $name = trim($matches[1]);
            }

            if (preg_match('/author[:\s]+(.*)/i', $content, $matches)) {
                $author = trim($matches[1]);
            } elseif (preg_match('/composer[:\s]+(.*)/i', $content, $matches)) {
                $author = trim($matches[1]);
            }

            if (preg_match('/transcribed[:\s]+by[:\s]+(.*)/i', $content, $matches)) {
                $transcribed_by = trim($matches[1]);
            }
        }

        return [
            'name' => $name,
            'author' => $author,
            'transcribed_by' => $transcribed_by
        ];
    }

    /**
     * Format file size to human readable
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}