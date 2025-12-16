<?php

// app/Http/Controllers/AcademicDocumentController.php

namespace App\Http\Controllers;

use App\Models\AcademicDocument;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AcademicDocumentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(string $category)
    {
        $this->authorize('viewAny', AcademicDocument::class);
        $documents = AcademicDocument::query()
            ->where('category', $category)
            ->orderByDesc('created_at')
            ->get()
            ->values(); // 👈 fuerza array limpio

        return Inertia::render('Admin/AcademicProduction/Index', [
            'category' => $category,
            'documents' => $documents, // 👈 ARRAY REAL
        ]);

    }

    public function store(Request $request, string $category)
    {
        $this->authorize('create', AcademicDocument::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $path = $request->file('file')->store('academic-documents', 'public');

        AcademicDocument::create([
            ...$data,
            'file_path' => $path,
            'category' => $category,
        ]);

        return back();
    }

    public function update(Request $request, string $category, AcademicDocument $document)
    {
        $this->authorize('update', $document);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $document->update($data);

        return back();
    }

    public function destroy(string $category, AcademicDocument $document)
    {
        $this->authorize('delete', $document);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back();
    }

    public function showPdf(string $path): BinaryFileResponse
    {

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);

        $response = new BinaryFileResponse($fullPath);

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set(
            'Content-Disposition',
            ResponseHeaderBag::DISPOSITION_INLINE
        );

        // 🔑 CLAVE PARA PDF.js
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }

    public function dashboard()
    {
        $user = Auth::user();

        // ==========================
        // Estadísticas por categoría
        // ==========================
        $stats = AcademicDocument::where('user_id', $user->id)
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');
        $stats = AcademicDocument::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $categories = [
            'articles',
            'research',
            'thesis',
            'evaluations',
            'workshops',
        ];

        $statsNormalized = collect($categories)->mapWithKeys(fn ($cat) => [
            $cat => $stats[$cat] ?? 0,
        ]);

        // ==========================
        // Evolución mensual
        // ==========================
        // Estadísticas por categoría (GLOBAL)

        // Evolución mensual (GLOBAL)
        $monthly = AcademicDocument::selectRaw("strftime('%m', created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyNormalized = collect(range(1, 12))
            ->map(fn ($m) => $monthly[$m] ?? 0);

        return Inertia::render('Dashboard', [
            'stats' => $statsNormalized,
            'monthly' => $monthlyNormalized,
        ]);
    }

    public function showCategory(string $category)
    {
        $documents = AcademicDocument::query()
            ->whereRaw('LOWER(TRIM(category)) = ?', [strtolower($category)])
            ->orderByDesc('published_at')
            ->get()
            ->map(function ($doc) {
                $extension = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));

                $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                $isPdf = $extension === 'pdf';

                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'description' => $doc->description,
                    'published_at' => $doc->published_at,
                    'file_path' => url('secure-pdf/'.$doc->file_path),
                    'file_type' => $isImage ? 'image' : ($isPdf ? 'pdf' : 'other'),
                ];
            });

        return Inertia::render('AcademicProduction/Category', [
            'documents' => $documents,
            'category' => $category,
        ]);
    }
}
