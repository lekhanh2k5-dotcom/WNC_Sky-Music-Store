<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function index()
    {
        return view('admin.products.products', [
            'products' => Product::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

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

    private function parseFileInfo($content, $fileName)
    {
        // Mặc định lấy tên từ filename
        $name = pathinfo($fileName, PATHINFO_FILENAME);
        $author = 'Chưa xác định';
        $transcribed_by = 'Admin';

        // Làm sạch content và xử lý encoding
        $cleanContent = $content; // Không trim ngay để giữ nguyên BOM

        Log::info('Raw file analysis:', [
            'contentLength' => strlen($cleanContent),
            'firstBytes' => bin2hex(substr($cleanContent, 0, 10)),
            'fileName' => $fileName
        ]);

        // Phát hiện và xử lý các loại BOM với thứ tự ưu tiên
        $boms = [
            "\xFF\xFE\x00\x00" => 'UTF-32 LE BOM', // UTF-32 LE BOM (4 bytes) - check trước
            "\x00\x00\xFE\xFF" => 'UTF-32 BE BOM', // UTF-32 BE BOM (4 bytes)
            "\xFF\xFE" => 'UTF-16 LE BOM',         // UTF-16 LE BOM (2 bytes)
            "\xFE\xFF" => 'UTF-16 BE BOM',         // UTF-16 BE BOM (2 bytes)
            "\xEF\xBB\xBF" => 'UTF-8 BOM',         // UTF-8 BOM (3 bytes)
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

        // Xử lý encoding với ưu tiên UTF-16 LE
        $originalEncoding = null;

        // Nếu có BOM UTF-16 LE hoặc detect được UTF-16 LE
        if ($detectedBom === 'UTF-16 LE BOM' || (!$detectedBom && !mb_check_encoding($cleanContent, 'UTF-8'))) {
            // Thử UTF-16 LE trước
            $encoding = mb_detect_encoding($cleanContent, ['UTF-16LE', 'UTF-16BE', 'UTF-32LE', 'UTF-32BE'], true);

            if ($encoding) {
                $originalEncoding = $encoding;
                $cleanContent = mb_convert_encoding($cleanContent, 'UTF-8', $encoding);
                Log::info("Converted content from {$encoding} to UTF-8");
            } else if (!mb_check_encoding($cleanContent, 'UTF-8')) {
                // Fallback: thử các encoding khác
                $encoding = mb_detect_encoding($cleanContent, ['ISO-8859-1', 'Windows-1252', 'ASCII'], true);
                if ($encoding) {
                    $originalEncoding = $encoding;
                    $cleanContent = mb_convert_encoding($cleanContent, 'UTF-8', $encoding);
                    Log::info("Fallback: Converted content from {$encoding} to UTF-8");
                }
            }
        }

        // Chuẩn hóa line endings (Unix LF -> Windows CRLF or vice versa)
        $cleanContent = str_replace(["\r\n", "\r"], "\n", $cleanContent); // Normalize to LF

        // Làm sạch cuối cùng
        $cleanContent = trim($cleanContent);

        // Xử lý các ký tự ẩn khác
        $cleanContent = preg_replace('/^[\x00-\x1F\x7F]+/', '', $cleanContent);
        $cleanContent = preg_replace('/[\x00-\x1F\x7F]+$/', '', $cleanContent);
        $cleanContent = trim($cleanContent);

        Log::info('Attempting to parse file:', [
            'fileName' => $fileName,
            'contentLength' => strlen($cleanContent),
            'contentStart' => substr($cleanContent, 0, 200), // Tăng lên 200 ký tự
            'contentEnd' => substr($cleanContent, -50), // 50 ký tự cuối
            'firstChar' => ord($cleanContent[0] ?? ''), // Mã ASCII ký tự đầu
            'encoding' => mb_detect_encoding($cleanContent), // Detect encoding
            'hasUTF8BOM' => substr($cleanContent, 0, 3) === "\xEF\xBB\xBF" // Check BOM
        ]);

        // Thử parse JSON trước (bất kể đuôi file)
        $jsonData = json_decode($cleanContent, true);
        $jsonError = json_last_error();

        Log::info('JSON Parse attempt:', [
            'jsonError' => $jsonError,
            'jsonErrorMsg' => json_last_error_msg(),
            'isArray' => is_array($jsonData),
            'dataType' => gettype($jsonData)
        ]);

        if ($jsonError === JSON_ERROR_NONE && is_array($jsonData)) {
            Log::info('JSON parsed successfully, extracting song data...');

            // Xử lý cả JSON array và JSON object
            if (isset($jsonData[0]) && is_array($jsonData[0])) {
                // Nếu là array of objects, lấy phần tử đầu tiên
                $songData = $jsonData[0];
                Log::info('Using first element of JSON array');
            } else {
                // Nếu là object đơn lẻ hoặc array đơn giản
                $songData = $jsonData;
                Log::info('Using JSON data directly');
            }

            Log::info('Song data extracted:', [
                'available_keys' => array_keys($songData),
                'name' => $songData['name'] ?? 'not found',
                'author' => $songData['author'] ?? 'not found',
                'transcribedBy' => $songData['transcribedBy'] ?? 'not found'
            ]);

            // Lấy thông tin từ JSON
            if (isset($songData['name']) && !empty(trim($songData['name']))) {
                $name = trim($songData['name']);
                Log::info('Name extracted from JSON: ' . $name);
            }

            if (isset($songData['author']) && !empty(trim($songData['author']))) {
                $author = trim($songData['author']);
                Log::info('Author extracted from JSON: ' . $author);
            }

            if (isset($songData['transcribedBy']) && !empty(trim($songData['transcribedBy']))) {
                $transcribed_by = trim($songData['transcribedBy']);
                Log::info('TranscribedBy extracted from JSON: ' . $transcribed_by);
            }

            // Debug: Log kết quả cuối cùng
            Log::info('Final JSON Parse Result:', [
                'name' => $name,
                'author' => $author,
                'transcribed_by' => $transcribed_by
            ]);
        } else {
            // Nếu không phải JSON, parse như text thô (logic cũ)
            if (preg_match('/name[:\s]+(.*)/i', $content, $matches)) {
                $name = trim($matches[1]);
            }

            if (preg_match('/author[:\s]+(.*)/i', $content, $matches)) {
                $author = trim($matches[1]);
            } elseif (preg_match('/composer[:\s]+(.*)/i', $content, $matches)) {
                $author = trim($matches[1]);
            } elseif (preg_match('/by[:\s]+(.*)/i', $content, $matches)) {
                $author = trim($matches[1]);
            }

            if (preg_match('/transcribed[:\s]+by[:\s]+(.*)/i', $content, $matches)) {
                $transcribed_by = trim($matches[1]);
            } elseif (preg_match('/transcriber[:\s]+(.*)/i', $content, $matches)) {
                $transcribed_by = trim($matches[1]);
            }

            Log::info('Text Parse Result:', [
                'name' => $name,
                'author' => $author,
                'transcribed_by' => $transcribed_by
            ]);
        }

        return [
            'name' => $name,
            'author' => $author,
            'transcribed_by' => $transcribed_by
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
