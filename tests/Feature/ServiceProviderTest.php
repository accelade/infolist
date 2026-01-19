<?php

declare(strict_types=1);

use Accelade\Infolists\Components\TextEntry;
use Accelade\Infolists\Infolist;

describe('Service Provider Registration', function () {
    it('registers the infolists singleton', function () {
        expect(app()->bound('infolists'))->toBeTrue();
        expect(app('infolists'))->toBeInstanceOf(Infolist::class);
    });

    it('returns same instance for infolists singleton', function () {
        $instance1 = app('infolists');
        $instance2 = app('infolists');

        expect($instance1)->toBe($instance2);
    });

    it('loads config from infolists.php', function () {
        expect(config('infolists'))->toBeArray();
        expect(config('infolists.placeholder'))->toBe('—');
    });
});

describe('View Loading', function () {
    it('loads views from infolists namespace', function () {
        $hints = app('view')->getFinder()->getHints();

        expect($hints)->toHaveKey('infolists');
    });

    it('adds component views to accelade namespace', function () {
        $hints = app('view')->getFinder()->getHints();

        expect($hints)->toHaveKey('accelade');
    });

    it('can resolve infolists component views', function () {
        $factory = app('view');

        expect($factory->exists('infolists::components.infolist'))->toBeTrue();
    });

    it('can resolve accelade component views for entries', function () {
        $factory = app('view');

        // Laravel looks for components in components/ subdirectory
        expect($factory->exists('accelade::components.text-entry'))->toBeTrue();
    });
});

describe('Infolist Rendering', function () {
    it('can render infolist view', function () {
        $infolist = Infolist::make()
            ->record(['name' => 'John'])
            ->schema([
                TextEntry::make('name'),
            ]);

        $view = $infolist->render();

        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
    });
});
