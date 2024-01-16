<?php

use BeastBytes\Mermaid\UserJourney\Actor;
use BeastBytes\Mermaid\UserJourney\Task;

defined('COMMENT') or define('COMMENT', 'comment');

test('task', function () {
    $alice = new Actor('Alice');
    $bob = new Actor('Bob');
    $charlie = new Actor('Charlie');

    $task = new Task('Task', 2);

    expect($task->withActor($alice)->withComment(COMMENT)->render(''))
        ->toBe('%% ' . COMMENT  . "\nTask: 2: Alice")
    ;

    $task = $task->withActor($bob, $charlie);

    expect($task->render(''))
        ->toBe('Task: 2: Bob,Charlie')
    ;

    expect($task->addActor($alice)->render(''))
        ->toBe('Task: 2: Bob,Charlie,Alice')
    ;
});

test('task with sort', function () {
    $alice = new Actor('Alice');
    $bob = new Actor('Bob');
    $charlie = new Actor('Charlie');

    $task = new Task('Task', 2, true);

    expect($task->withActor($bob, $charlie, $alice)->render(''))
        ->toBe('Task: 2: Alice,Bob,Charlie')
    ;
});

it('throws exception', function (int $score) {
    new Task('Task', $score);
})
    ->throws(InvalidArgumentException::class, '`$score` must be between 0 and 5 inclusive')
    ->with([-1, 6])
;
