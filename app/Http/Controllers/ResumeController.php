<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class ResumeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $resumes = auth()->user()->resumes()->latest()->paginate(10);
        return view('resumes.user_index', compact('resumes'));
    }

    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);

        return view('resumes.edit', [
            'resume' => $resume,
            'content' => $resume->content
        ]);
    }

    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $request->validate(['content' => 'required|string']);

        $resume->content = $request->input('content');
        $resume->save();

        $this->regeneratePdf($resume);

        return redirect()->route('user.resumes.index')
            ->with('success', 'Резюме успешно обновлено');
    }

    private function regeneratePdf(Resume $resume)
    {
        $parsedown = new Parsedown();
        $resumeHtml = $parsedown->text($resume->content);

        $pdf = Pdf::loadView('layouts.resume.classic', [
            'resume' => $resumeHtml,
            'jobLinks' => [],
            'technologies' => [],
            'avatarUrl' => $resume->user->avatar_url
        ]);

        Storage::put($resume->file_path, $pdf->output());
    }
}
