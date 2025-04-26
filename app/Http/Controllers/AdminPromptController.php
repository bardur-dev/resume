<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use Illuminate\Http\Request;

class AdminPromptController extends Controller
{
    public function edit()
    {
        $prompt = Prompt::where('name', 'resume_generation')->firstOrFail();
        return view('admin.prompts.edit', compact('prompt'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:100',
        ]);

        $prompt = Prompt::where('name', 'resume_generation')->firstOrFail();
        $prompt->content = $request->input('content');
        $prompt->save();

        return redirect()->route('admin.prompts.edit')
            ->with('success', 'Промпт успешно обновлен');
    }
}
