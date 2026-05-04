<?php

use App\Concerns\GeneratesUniqueSelector;

test('generates unique selector', function () {
    $class = new class
    {
        use GeneratesUniqueSelector;
    };

    $selector = $class::generateUniqueSelector('myproject', 'myresource');

    expect($selector)->toStartWith('myproject-myresource-');
    expect(strlen($selector))->toBeGreaterThan(20); // slug + random
});
