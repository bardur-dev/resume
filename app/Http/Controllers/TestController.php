<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use App\Models\Experience;

class TestController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Тестовый метод для проверки генерации резюме без авторизации.
     */
    public function testGenerateResume()
    {
        // Загружаем фиктивные данные опыта (например, для первого пользователя в базе)
        $experiences = Experience::where('user_id', 1)->get(); // Используем user_id = 1 как пример

        if ($experiences->isEmpty()) {
            return response()->json([
                'error' => 'Нет опыта для генерации резюме. Добавьте опыт для пользователя с ID 1.',
            ], 400);
        }

        try {
            // Вызываем метод generateResume из сервиса AIService
            $resume = $this->aiService->generateResume($experiences);

            // Возвращаем результат в формате JSON
            return response()->json([
                'success' => true,
                'resume' => $resume,
            ]);
        } catch (\Exception $e) {
            // Возвращаем ошибку в формате JSON
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
