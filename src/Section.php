<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\UserJourney;

use BeastBytes\Mermaid\Mermaid;

final class Section
{
    private const SECTION = 'section';

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

    public function render(string $indentation): string
    {
        $output = [];
        $output[] = self::SECTION . ' ' . $this->name;

        foreach ($this->tasks as $task) {
            $output[] = $task->render($indentation . Mermaid::INDENTATION);
        }

        return $indentation . implode("\n", $output);
    }
}
