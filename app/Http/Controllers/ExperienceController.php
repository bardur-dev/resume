<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Resume;
use App\Services\AIService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class ExperienceController extends Controller
{
    public function create()
    {
        $experiences = auth()->user()->experiences()->latest()->get();
        return view('experience.create', compact('experiences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'projects' => 'nullable|string', // Добавляем валидацию
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'avatar_url' => 'nullable|url'
        ]);

        auth()->user()->experiences()->create($validated);

        return redirect()->route('experience.create')
            ->with('success', 'Опыт успешно добавлены!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar_url' => 'required|url', // проверяем, что это корректный URL
        ]);

        auth()->user()->updateAvatarUrl($request->input('avatar_url'));

        return back()->with('success', 'Ссылка на фото успешно сохранена');
    }

    /**
     * Генерирует умные ссылки на вакансии
     */
    private function generateJobLinks(array $technologies, string $city = 'moskva'): array
    {
        if (empty($technologies)) {
            // Если технологии не указаны, извлекаем их из описания опыта
            $technologies = $this->extractTechnologiesFromExperience();
        }
        $query = implode('+', $technologies);
        $encodedQuery = urlencode(implode(' ', $technologies));

        return [
            [
                'title' => "Вакансии по запросу: " . implode(', ', $technologies),
                'url' => "https://hh.ru/search/vacancy?text={$query}&area=1",
                'source' => 'hh.ru',
                'icon' => 'hh' // для отображения логотипа
            ],
            [
                'title' => "Поиск работы для " . implode('/', $technologies) . " разработчиков",
                'url' => "https://career.habr.com/vacancies?q={$encodedQuery}",
                'source' => 'habr',
                'icon' => 'habr'
            ]
        ];
    }
    private function extractTechnologiesFromExperience(): array
    {
        $commonTech = ['PHP', 'Laravel', 'JavaScript', 'Vue', 'React', 'Python', 'Java', 'MySQL'];
        $userText = auth()->user()->experiences()->pluck('description')->implode(' ');

        $foundTech = [];
        foreach ($commonTech as $tech) {
            if (stripos($userText, $tech) !== false) {
                $foundTech[] = $tech;
            }
        }

        return !empty($foundTech) ? $foundTech : ['IT']; // Дефолтное значение
    }


    public function generateResume(AIService $aiService, Request $request)
    {
        $experienceIds = $request->input('experience_ids', []);
        $template = $request->input('template', 'classic');

        if (empty($experienceIds)) {
            return redirect()->route('experience.create')
                ->with('error', 'Выберите хотя бы один опыт работы для генерации резюме.');

        }

        $experiences = auth()->user()->experiences()
            ->whereIn('id', $experienceIds)
            ->get();

        try {
            $resume = $aiService->generateResume($experiences);

            // Конвертируем Markdown в HTML (если нужно)
            $parsedown = new Parsedown();
            $resumeHtml = $parsedown->text($resume);

            $avatarUrl = $experiences->first()->avatar_url;
            // Генерируем ссылки на вакансии
            // Получаем технологии из формы или из опыта
            $technologies = $request->input('technologies', []);
            $city = $request->input('city', 'moskva');
            if (empty($technologies)) {
                $technologies = $this->extractTechnologiesFromExperience();
            }

            $jobLinks = $this->generateJobLinks($technologies, $city);
            // Выбираем шаблон в зависимости от выбора пользователя
            $templateView = $template === 'dark' ? 'layouts.resume.dark' : 'layouts.resume.classic';

            $pdf = Pdf::loadView($templateView, [
                'resume' => $resumeHtml,
                'jobLinks' => $jobLinks,
                'technologies' => $technologies,
                'avatarUrl' => $avatarUrl
            ]);

            $fileName = 'resume_'.date('Ymd_His').'.pdf';
            $filePath = "resumes/{$fileName}";
            $pdfContent = $pdf->output();
            Storage::put($filePath, $pdfContent);

            Resume::create([
                'user_id' => auth()->id(),
                'file_path' => $filePath,
                'file_name' => $fileName
            ]);

            return response()->make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('experience.create')
                ->with('error', 'Ошибка генерации резюме: ' . $e->getMessage());
        }
    }


    public function clear()
    {
        auth()->user()->experiences()->delete();
        return redirect()->route('experience.create')->with('success', 'Весь опыт работы удален');
    }
}
