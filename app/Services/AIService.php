<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $client;
    protected $apiKey;
    protected $authToken;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Отключаем проверку SSL для разработки
            'timeout' => 30, // Увеличиваем таймаут
        ]);
        $this->apiKey = 'ZDdmZjlkYTAtNDUwZS00MTNjLWI5NTQtYjQxNGNlMzZiNTA4OjE0MjMyY2NkLTY3YjItNDg0My04NzBlLTJhMjI3OTZjNDFkYg==';
    }

    protected function getAuthToken()
    {
        try {
            $response = $this->client->post('https://ngw.devices.sberbank.ru:9443/api/v2/oauth', [
                'headers' => [
                    'Authorization' => 'Basic ' . $this->apiKey,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json',
                    'RqUID' => $this->generateUuid(), // Добавляем обязательный RqUID
                ],
                'form_params' => [
                    'scope' => 'GIGACHAT_API_PERS',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['access_token'])) {
                throw new \Exception('Не получен access_token в ответе');
            }

            return $data['access_token'];
        } catch (\Exception $e) {
            Log::error('Ошибка при получении токена GigaChat: ' . $e->getMessage());
            throw new \Exception("Не удалось получить токен авторизации: " . $e->getMessage());
        }
    }

    protected function generateUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function generateResume($experiences)
    {
        if (!$this->authToken) {
            $this->authToken = $this->getAuthToken();
        }

        $prompt = "Сгенерируй строгое формальное резюме на основе предоставленных данных. Добавляй примеры только для обязанности работы в компании. Не добавляй примеры, не приукрашивай, не делай предположений. Используй только предоставленную информацию. Формат:\n\n"
            . "**ФИО:** [Фактическое имя]\n\n"
            . "**Контакты:**\n"
            . "- Телефон: [Фактический номер]\n"
            . "- Email: [Фактический адрес]\n\n"
            . "### Профессиональный опыт\n\n"
            . "#### [Должность]\n"
            . "*Компания:* [Название]\n"
            . "*Период работы:* [дата начала] - [дата окончания]\n"
            . "*Обязанности:*\n"
            . "- [Пункт 1] ПИШИ ЗАВУАЛИРОВАНО, ПИШИ ТОЛЬКО ОБЩИМИ СЛОВАМИ\n"
            . "- [Пункт 2] ПИШИ ЗАВУАЛИРОВАНО, ПИШИ ТОЛЬКО ОБЩИМИ СЛОВАМИ\n\n"
            . "### Навыки\n\n"
            . "- [Навык 1]\n"
            . "- [Навык 2]\n\n"
            . "### Образование\n\n"
            . "[Учебное заведение], [Год окончания]\n\n"
            . "### Проекты\n\n"
            . "[Только если указаны в данных. Формат для каждого проекта:\n"
            . "#### Название проекта\n"
            . "*Роль:* [конкретная роль]\n"
            . "*Технологии:* [список технологий]\n"
            . "*Особенности:* [ключевые особенности проекта]]\n\n"
            . "Используй только фактические данные из этого описания:\n";
        foreach ($experiences as $experience) {
            $period = $experience->end_date
                ? "{$experience->start_date} - {$experience->end_date}"
                : "{$experience->start_date} - настоящее время";
            $prompt .= "- Должность: {$experience->title}\n";
            $prompt .= "  Описание: {$experience->description}\n";
            $prompt .= "  Период: $period\n";
            if (!empty($experience->projects)) {
                $prompt .= "  Проекты: {$experience->projects}\n";
            }
        }

        try {
            $response = $this->client->post('https://gigachat.devices.sberbank.ru/api/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->authToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'model' => 'GigaChat:latest', // Используем последнюю версию
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 2000,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['choices'][0]['message']['content'];
        } catch (\Exception $e) {
            Log::error('Ошибка при генерации резюме: ' . $e->getMessage());
            throw new \Exception("Ошибка при генерации резюме: " . $e->getMessage());
        }
    }
}
