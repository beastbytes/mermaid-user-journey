<?php

use BeastBytes\Mermaid\UserJourney\Actor;

test('actor', function () {
    expect((new Actor('Alice'))->render())->toBe('Alice');
});
