<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class AdminResumeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Resume::class);

        $resumes = Resume::with('user')->latest()->paginate(10);
        return view('admin.resumes.index', compact('resumes'));
    }

    public function download(Resume $resume): StreamedResponse
    {
        $this->authorize('download', $resume);

        return Storage::download($resume->file_path, $resume->file_name);
    }
}
