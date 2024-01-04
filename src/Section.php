<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\UserJourney;

use BeastBytes\Mermaid\RenderItemsTrait;

final class Section
{
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
        $output[] = $indentation . 'section ' . $this->name;
        $output[] = $this->renderItems($this->tasks, $indentation);

        return implode("\n", $output);
    }
}
