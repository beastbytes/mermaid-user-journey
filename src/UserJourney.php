<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\UserJourney;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;

final class UserJourney
{
    use RenderItemsTrait;

    private const TYPE = 'journey';

    /** @var Section[] $sections */
    private array $sections = [];

    public function __construct(private readonly string $title)
    {
    }

    public function addSection(Section ...$section): self
    {
        $new = clone $this;
        $new->sections = array_merge($new->sections, $section);
        return $new;
    }

    public function withSection(Section ...$section): self
    {
        $new = clone $this;
        $new->sections = $section;
        return $new;
    }

    public function render(): string
    {
        $output = [];

        $output[] = self::TYPE;
        $output[] = Mermaid::INDENTATION . 'title ' . $this->title;
        $output[] = $this->renderItems($this->sections, '');

        return Mermaid::render($output);
    }
}
