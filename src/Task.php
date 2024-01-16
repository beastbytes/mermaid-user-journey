<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\UserJourney;

use BeastBytes\Mermaid\CommentTrait;
use InvalidArgumentException;

final class Task
{
    use CommentTrait;

    /** @var Actor[] $actors */
    private array $actors = [];

    public function __construct(
        private readonly string $name,
        private readonly int $score,
        private readonly bool $sort = false
    )
    {
        if ($this->score < 0 || $this->score > 5) {
            throw  new InvalidArgumentException('`$score` must be between 0 and 5 inclusive');
        }
    }

    public function addActor(Actor ...$actor): self
    {
        $new = clone $this;
        $new->actors = array_merge($new->actors, $actor);
        return $new;
    }

    public function withActor(Actor ...$actor): self
    {
        $new = clone $this;
        $new->actors = $actor;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $actors = [];
        foreach ($this->actors as $actor) {
            $actors[] = $actor->getName();

            if ($this->sort) {
                sort($actors);
            }
        }

        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation . $this->name . ': ' . $this->score . ': ' . implode(',', $actors);

        return implode("\n", $output);
    }
}
