<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\UserJourney;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\RenderItemsTrait;

final class Section
{
    use CommentTrait;
    use RenderItemsTrait;

    /** @var Task[] $tasks */
    private array $tasks = [];

    public function __construct(private readonly string $name)
    {
    }

    public function addTask(Task ...$task): self
    {
        $new = clone $this;
        $new->tasks = array_merge($new->tasks, $task);
        return $new;
    }

    public function withTask(Task ...$task): self
    {
        $new = clone $this;
        $new->tasks = $task;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation . 'section ' . $this->name;
        $this->renderItems($this->tasks, $indentation, $output);

        return implode("\n", $output);
    }
}
