<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        try {
            $avatarUrl = $this->aiService->generateAvatar($request->description);

            // Сохраняем URL аватара для пользователя
            if (auth()->check()) {
                auth()->user()->update(['avatar_url' => $avatarUrl]);
            }

            return response()->json([
                'success' => true,
                'avatar_url' => $avatarUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
