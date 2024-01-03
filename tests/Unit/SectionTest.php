<?php

use BeastBytes\Mermaid\UserJourney\Actor;
use BeastBytes\Mermaid\UserJourney\Section;
use BeastBytes\Mermaid\UserJourney\Task;

test('section', function () {
    $alice = new Actor('Alice');
    $bob = new Actor('Bob');
    $charlie = new Actor('Charlie');

    $task1 = (new Task('Task 1', 2))->withActor($alice);
    $task2 = (new Task('Task 2', 3))->withActor($alice, $bob);
    $task3 = (new Task('Task 3', 1))->withActor($bob);

    $section = (new Section('Section 1'))->withTask($task1, $task2, $task3);

    expect($section->render(''))
        ->toBe("section Section 1\n"
            . "  Task 1: 2: Alice\n"
            . "  Task 2: 3: Alice,Bob\n"
            . "  Task 3: 1: Bob"
        )
    ;
});
