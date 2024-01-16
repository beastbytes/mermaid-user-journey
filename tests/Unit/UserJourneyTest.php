<?php

use BeastBytes\Mermaid\UserJourney\Actor;
use BeastBytes\Mermaid\UserJourney\Section;
use BeastBytes\Mermaid\UserJourney\Task;
use BeastBytes\Mermaid\UserJourney\UserJourney;

defined('COMMENT') or define('COMMENT', 'comment');

test('user journey', function () {
    $alice = new Actor('Alice');
    $bob = new Actor('Bob');
    $charlie = new Actor('Charlie');

    $task1 = (new Task('Task 1', 2))->withActor($alice);
    $task2 = (new Task('Task 2', 3))->withActor($alice, $bob);
    $task3 = (new Task('Task 3', 1))->withActor($bob);
    $task4 = (new Task('Task 4', 5))->withActor($alice, $bob, $charlie);
    $task5 = (new Task('Task 5', 4))->withActor($alice, $bob);

    $section1 = (new Section('Section 1'))->withTask($task1, $task2, $task3);
    $section2 = (new Section('Section 2'))->withTask($task4, $task5);
    $section3 = (new Section('Section 3'))->withTask($task1, $task4, $task5);
    $section4 = (new Section('Section 4'))->withTask($task2, $task3);

    $journey = (new UserJourney('User Journey'))
        ->withSection($section1, $section2)
        ->withComment(COMMENT)
    ;

    expect($journey->render(''))
        ->toBe("<pre class=\"mermaid\">\n"
            . '%% ' . COMMENT . "\n"
            . "journey\n"
            . "  title User Journey\n"
            . "  section Section 1\n"
            . "    Task 1: 2: Alice\n"
            . "    Task 2: 3: Alice,Bob\n"
            . "    Task 3: 1: Bob\n"
            . "  section Section 2\n"
            . "    Task 4: 5: Alice,Bob,Charlie\n"
            . "    Task 5: 4: Alice,Bob\n"
            . '</pre>'
        )
    ;

    expect($journey->addSection($section3, $section4)->render(''))
        ->toBe("<pre class=\"mermaid\">\n"
               . '%% ' . COMMENT . "\n"
               . "journey\n"
               . "  title User Journey\n"
               . "  section Section 1\n"
               . "    Task 1: 2: Alice\n"
               . "    Task 2: 3: Alice,Bob\n"
               . "    Task 3: 1: Bob\n"
               . "  section Section 2\n"
               . "    Task 4: 5: Alice,Bob,Charlie\n"
               . "    Task 5: 4: Alice,Bob\n"
               . "  section Section 3\n"
               . "    Task 1: 2: Alice\n"
               . "    Task 4: 5: Alice,Bob,Charlie\n"
               . "    Task 5: 4: Alice,Bob\n"
               . "  section Section 4\n"
               . "    Task 2: 3: Alice,Bob\n"
               . "    Task 3: 1: Bob\n"
               . '</pre>'
        )
    ;
});
