<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Faker\Factory as Example;
use OurSociety\View\AppView;

/**
 * PoliticianArticle Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $electoral_district_id
 * @property string $slug
 * @property string $name
 * @property string $body
 * @property int $version
 * @property \Cake\I18n\FrozenTime $approved
 * @property \Cake\I18n\FrozenTime $published
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $politician
 * @property \OurSociety\Model\Entity\Category $aspect
 * @property \OurSociety\Model\Entity\ArticleType $article_type
 * @property int $read_time Estimated read time (in minutes)
 * @property bool $is_example
 */
class PoliticianArticle extends AppEntity
{
    public static function example(array $data = null): self
    {
        $example = Example::create();
        $data = $data ?? [];
        $data += [
            'name' => 'Example Article',
            'body' => '<p>' . implode($example->paragraphs(random_int(10, 50)), '</p><p>') . '</p>',
            'aspect' => Category::random(),
            'article_type' => new Entity(['name' => ['Policy', 'Plan', 'Vision'][random_int(0, 2)]]),
            'politician' => User::example(),
            'is_example' => true,
        ];

        return new self($data);
    }

    public function renderMunicipalViewLink(AppView $view, array $options = null): string
    {
        $text = $options['text'] ?? $this->name;

        if ($this->is_example) {
            return $text;
        }

        return $view->Html->link($text, [
            '_name' => 'politician:article',
            'politician' => $this->politician->slug,
            'article' => $this->slug,
        ], $options ?? []);
    }

    public function renderPoliticianEditButton(AppView $view): string
    {
        return $view->Html->link(__('Edit article'), [
            'prefix' => 'politician/profile',
            'controller' => 'Articles',
            'action' => 'edit',
            $this->slug
        ], ['class' => 'btn btn-default']);
    }

    /**
     * Read time.
     *
     * @link https://blog.medium.com/read-time-and-you-bc2048ab620c Medium Read Time (Reference Implementation)
     * @return int Estimated read time (in minutes).
     */
    protected function _getReadTime(): int
    {
        $adultReadingSpeed = 275; // WPM
        $wordCount = str_word_count($this->body);
        $readTimeMinutes = $wordCount / $adultReadingSpeed;

        $imageCount = substr_count($this->body, '<img');
        switch ($imageCount) {
            case 1: $imageTimeSeconds = 12; break;
            case 2: $imageTimeSeconds = 11; break;
            case 3: $imageTimeSeconds = 10; break;
            case 4: $imageTimeSeconds = 9; break;
            case 5: $imageTimeSeconds = 8; break;
            case 6: $imageTimeSeconds = 7; break;
            case 7: $imageTimeSeconds = 6; break;
            case 8: $imageTimeSeconds = 5; break;
            case 9: $imageTimeSeconds = 4; break;
            default: $imageTimeSeconds = $imageCount * 3;
        }
        $imageTimeMinutes = $imageTimeSeconds / MINUTE;

        return max((int)round($readTimeMinutes + $imageTimeMinutes), 1);
    }

    // TODO: Delete when this class name is `Articles`, not `PoliticianArticles`.
    protected function renderElement(AppView $view, string $type, array $viewVariables = null): string
    {
        return $view->element(
            sprintf('%s/article', Inflector::camelize($type)),
            ($viewVariables ?? []) + ['article' => $this]
        );
    }
}
