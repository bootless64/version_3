<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // تعیین تصادفی اینکه کامنت برای مقاله باشد یا خبر
        $isForNews = (bool) random_int(0, 1);

        if ($isForNews) {
            $news = News::inRandomOrder()->first() ?? News::factory()->create();
            $articleId = null;
            $newsId = $news->id;
        } else {
            $article = Article::inRandomOrder()->first() ?? Article::factory()->create();
            $newsId = null;
            $articleId = $article->id;
        }

        return [
            'user_id' => $user->id,
            'news_id' => $newsId,
            'article_id' => $articleId,
            'content' => fake('fa_IR')->realText(200),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
