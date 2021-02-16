<?php

$I = new AcceptanceTester($scenario ?? null);
$I->wantTo('see Starting page');

$I->amOnPage('/');

$I->seeInTitle('Discussion Platform');

$I->see("DISCUSSION >PL@TFORM");
$I->seeLink("login", "/login");
$I->seeLink("register", "/register");
$I->seeLink("POSTS", "/posts");
