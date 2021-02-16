<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo('Create and edit post');

$I->amOnPage('/posts');
$I->seeCurrentUrlEquals('/posts');

$I->see('No posts in database.');

$I->click('Create new...');

$I->seeCurrentUrlEquals('/login');

$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');

$I->click('Login');

$I->seeCurrentUrlEquals('/posts/create');

$I->click('Create');

//$I->see('All fields is required!', 'script');

//$I->see('The title field is required.', 'li');
//$I->see('The content field is required.', 'li');

$postTitle = "test post";
$postContent = "testtest";

$I->fillField('title', $postTitle);
$I->fillField('content', $postContent);

$I->dontSeeInDatabase('posts', [
    'title' => $postTitle,
    'content' => $postContent,
]);

$I->click('Create');

$I->seeInDatabase('posts', [
    'title' => $postTitle,
    'content' => $postContent,
]);

$id = $I->grabFromDatabase('posts', 'id', ['title' => $postTitle,]);
$time = $I->grabFromDatabase('posts', 'created_at', ['title' => $postTitle]);

$I->seeCurrentUrlEquals('/posts/' . $id);


$I->see($postTitle);
$I->see($postContent);
$I->see('Created '.$time.' by John Doe');
$I->seeElement('#post_'.$id.'_edit');
$I->seeElement('#post_'.$id.'_delete');

$I->amOnPage("/posts");
$I->seeCurrentUrlEquals('/posts');
$I->see("$postTitle");
$I->dontSee("$postContent");

$I->click('#post_'.$id.'_details');
$I->seeCurrentUrlEquals('/posts/' . $id);

$I->click('#post_'.$id.'_edit');

$I->seeCurrentUrlEquals('/posts/' . $id . '/edit');

$I->seeLink("", '/posts/' . $id );
$I->seeInField('title', $postTitle);

$I->see($postContent);

$I->fillField('content', "");

$I->click('Update');

$I->seeCurrentUrlEquals('/posts/' . $id . '/edit');

//$I->see('All fields are required!');

$postNewContent = "new test";

$I->fillField('content', $postNewContent);
$I->click('Update');

$I->seeCurrentUrlEquals('/posts/' . $id);

$I->see($postNewContent);

$I->dontSeeInDatabase('posts', [
    'title' => $postTitle,
    'content' => $postContent
]);

$I->seeInDatabase('posts', [
    'title' => $postTitle,
    'content' => $postNewContent
]);

$I->click('#post_'.$id.'_delete');

$I->seeCurrentUrlEquals('/posts');

$I->dontSeeInDatabase('posts', [
    'title' => $postTitle,
    'content' => $postNewContent
]);
$I->dontSee("$postTitle");
