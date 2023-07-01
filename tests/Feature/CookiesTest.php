<?php

use GuzzleHttp\Cookie\CookieJar;

dataset('COOKIES', [
    'set two' => [['set' => [
        'foo'   => 'bar',
        'hello' => 'Adapterman', 
    ]]],
    'delete one' => [['delete' => ['foo']]],
    'delete both' => [['delete' => ['foo', 'hello']]],
    //'case insensitive'     => [['Foo' => 'bar', 'foo' => 'hello Adapterman']],
]);


it('set COOKIES', function () {
    $cookie = new CookieJar();
    $responseSet = HttpClient()->get('/cookies', [
        'cookies' => $cookie,
        'query' => ['set' => [
            'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]],
    ]);

    expect($responseSet->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([]);
    
    $response = HttpClient()->get('/cookies', [
        'cookies' => $cookie
    ]);

    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]);

    //$response = HttpClient()->get('/cookies', [
    //    'cookies' => $cookie
    //]);

    expect($cookie->getCookieByName('foo')->toArray())
        //->toBeObject()
        //->toBe(['Name' => 'foo', 'Value' => 'bar']);
        ->toMatchArray([
            'Name' => 'foo',
            'Value' => 'bar',
        ])
        ->and($cookie->getCookieByName('hello')->toArray())
        ->toMatchArray([
            'Name' => 'hello',
            'Value' => 'Adapterman',
        ]);
        //->toHaveProperty('Name', 'foo');
        //->toHaveProperties(['Name' => 'foo', 'Value' => 'bar']);
        //->toMatchObject([
            //     'Name' => 'foo',
            //     'Value' => 'bar',
            // ]
        //   [
        //         'Name' => 'hello',
        //         'Value' => 'Adapterman',
        //     ], 
        // ]
    //);
    //$cookie->clear();
    //expect($response->getBody()->getContents())
    //    ->toBe('');
});//->with('COOKIES');


it('delete COOKIES', function () {
    $cookie = new CookieJar();
    $responseSet = HttpClient()->get('/cookies', [
        'cookies' => $cookie,
        'query' => ['set' => [
            'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]],
    ]);

    expect($responseSet->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([]);

    $response = HttpClient()->get('/cookies', [
        'cookies' => $cookie
    ]);

    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]);

    $responseDelete = HttpClient()->get('/cookies', [
        'cookies' => $cookie,
        'query' => ['delete' => [
            'foo',
            //'hello', 
        ]],
    ]);

    expect($responseDelete->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            //'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]);

    $response = HttpClient()->get('/cookies', [
        'cookies' => $cookie
    ]);

    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            //'foo'   => 'bar',
            'hello' => 'Adapterman', 
        ]);

    expect($cookie->getCookieByName('foo')->toArray())
        //->toBeObject()
        //->toBe(['Name' => 'foo', 'Value' => 'bar']);
        ->not->toMatchArray([
            'Name' => 'foo',
            'Value' => 'bar',
        ])
        //->toBe('') // to debug 
        ->and($cookie->getCookieByName('hello')->toArray())
        ->toMatchArray([
            'Name' => 'hello',
            'Value' => 'Adapterman',
        ]);
});
