<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo('test private posts');

$I->amOnPage('/posts');
$I->seeCurrentUrlEquals('/posts');

$I->see('No posts in database.');

$I->click('Create new...');

$I->seeCurrentUrlEquals('/login');

$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');

$I->click('Login');

$I->seeCurrentUrlEquals('/posts/create');

$privatePostTitle_1 = "private post for 1";
$privatePostContent_1 = "test private 1";
$privatePostMembersId_1 = "1";
$privatePostMembers_1 = "john.doe@gmail.com";

$I->fillField('title', $privatePostTitle_1);
$I->fillField('content', $privatePostContent_1);
$I->uncheckOption('isPublic');
$I->fillField('users', $privatePostMembers_1);

$I->dontSeeInDatabase('posts', [
    'title' => $privatePostTitle_1,
    'content' => $privatePostContent_1,
]);

$I->click('Create');

$I->seeInDatabase('posts', [
    'title' => $privatePostTitle_1,
    'content' => $privatePostContent_1,
    'isPublic' => FALSE,
]);

$idPrivate1 = $I->grabFromDatabase('posts', 'id', ['title' => $privatePostTitle_1,]);
$time = $I->grabFromDatabase('posts', 'created_at', ['title' => $privatePostTitle_1]);

$I->seeInDatabase('members', [
    'post_id' => $idPrivate1,
    'user_id' => $privatePostMembersId_1
]);
$I->seeCurrentUrlEquals('/posts/' . $idPrivate1);

$I->see($privatePostContent_1);
$I->see('Created '.$time.' by John Doe');
$I->see('Public: No');

$I->click('take_me_back');
$I->click('CREATE NEW...');

$publicPostTitle = "test public post";
$publicPostContent = "test public";

$I->fillField('title', $publicPostTitle);
$I->fillField('content', $publicPostContent);

$I->dontSeeInDatabase('posts', [
    'title' => $publicPostTitle,
    'content' => $publicPostContent,
]);

$I->click('Create');

$I->seeInDatabase('posts', [
    'title' => $publicPostTitle,
    'content' => $publicPostContent,
    'isPublic' => TRUE,
]);
$idPublic = $I->grabFromDatabase('posts', 'id', ['title' => $publicPostTitle,]);
$time = $I->grabFromDatabase('posts', 'created_at', ['title' => $publicPostTitle]);

$I->dontSeeInDatabase('members', [
    'post_id' => $idPublic
]);
$I->seeCurrentUrlEquals('/posts/' . $idPublic);

$I->see($publicPostContent);
$I->see('Created '.$time.' by John Doe');
$I->see('Public: Yes');

$I->amOnPage('/posts');
$I->See($privatePostTitle_1);
$I->See($publicPostTitle);

$I->amOnPage('/dashboard');
$I->submitForm("#Logout", array()); //Working logout
$I->amOnPage('/posts');
$I->dontSee($privatePostTitle_1);
$I->See($publicPostTitle);                  //guests see public posts
$I->amOnPage('/posts/'.$idPrivate1);
$I->seeCurrentUrlEquals('/posts');      //guests cant access private posts
$I->amOnPage('/posts/'.$idPublic);
$I->seeCurrentUrlEquals('/posts/'.$idPublic);      //guests can access public posts
$I->see($publicPostContent);
$I->see('Created '.$time.' by John Doe');
$I->see('Public: Yes');

$I->amOnPage('/posts');
$I->click('Create new...');

$I->seeCurrentUrlEquals('/login');

$I->fillField('email', 'jane.doe@gmail.com');
$I->fillField('password', 'passwd');

$I->click('Login');

$I->seeCurrentUrlEquals('/posts/create');

$privatePostTitle_2 = "private post for user 2";
$privatePostContent_2 = "test private 2";
$privatePostMembersId_2 = "2";
$privatePostMembers_2 = "jane.doe@gmail.com";

$I->fillField('title', $privatePostTitle_2);
$I->fillField('content', $privatePostContent_2);
//works even if field 'users' is empty
$I->uncheckOption('isPublic');

$I->dontSeeInDatabase('posts', [
    'title' => $privatePostTitle_2,
    'content' => $privatePostContent_2,
]);

$I->click('Create');

$I->seeInDatabase('posts', [
    'title' => $privatePostTitle_2,
    'content' => $privatePostContent_2,
    'isPublic' => FALSE,
]);

$idPrivate2 = $I->grabFromDatabase('posts', 'id', ['title' => $privatePostTitle_2,]);
$time = $I->grabFromDatabase('posts', 'created_at', ['title' => $privatePostTitle_2]);

$I->seeInDatabase('members', [
    'post_id' => $idPrivate2,
    'user_id' => $privatePostMembersId_2
]);

$I->dontSeeInDatabase('members', [
    'post_id' => $idPrivate2,
    'user_id' => $privatePostMembersId_1
]);

$I->seeCurrentUrlEquals('/posts/' . $idPrivate2);

$I->see($privatePostContent_2);
$I->see('Created '.$time.' by Jane Doe');
$I->see('Public: No');

$I->click('take_me_back');
$I->click('CREATE NEW...');

$privatePostTitle_1_2 = "private post for user 1 and 2";
$privatePostContent_1_2 = "test private 1 and 2";
$privatePostMembers_1_2 ="john.doe@gmail.com, jane.doe@gmail.com";
//$privatePostMembers_1_2 = "1, 2";

$I->fillField('title', $privatePostTitle_1_2);
$I->fillField('content', $privatePostContent_1_2);
$I->uncheckOption('isPublic');
$I->fillField('users', $privatePostMembers_1_2);

$I->dontSeeInDatabase('posts', [
    'title' => $privatePostTitle_1_2,
    'content' => $privatePostContent_1_2,
]);

$I->click('Create');

$I->seeInDatabase('posts', [
    'title' => $privatePostTitle_1_2,
    'content' => $privatePostContent_1_2,
    'isPublic' => FALSE,
]);

$idPrivate1_2 = $I->grabFromDatabase('posts', 'id', ['title' => $privatePostTitle_1_2,]);

$I->seeInDatabase('members', [
    'post_id' => $idPrivate1_2,
    'user_id' => $privatePostMembersId_1
]);

$I->seeInDatabase('members', [
    'post_id' => $idPrivate1_2,
    'user_id' => $privatePostMembersId_2
]);

$I->seeCurrentUrlEquals('/posts/' . $idPrivate1_2);

$I->see($privatePostContent_1_2);
$I->see('Public: No');

$I->click('take_me_back');
$I->dontSee($privatePostTitle_1);
$I->See($publicPostTitle);
$I->See($privatePostTitle_2);
$I->See($privatePostTitle_1_2);
$I->amOnPage('/posts/'.$idPrivate1);
$I->seeCurrentUrlEquals('/posts/');     //non-member users cannot access private posts

$I->amOnPage('/posts/'.$idPrivate1_2);

$I->click('delete_post');
$I->seeCurrentUrlEquals('/posts');

$I->dontSee($privatePostTitle_1_2);

$I->dontSeeInDatabase('posts', [
    'title' => $privatePostTitle_1_2,
    'content' => $privatePostContent_1_2,
    'isPublic' => FALSE,
]);

$I->dontSeeInDatabase('members', [
    'post_id' => $idPrivate1_2,
    'user_id' => $privatePostMembersId_1
]);

$I->dontSeeInDatabase('members', [
    'post_id' => $idPrivate1_2,
    'user_id' => $privatePostMembersId_2
]);
$I->amOnPage('/dashboard');
$I->submitForm("#Logout", array());

$I->amOnPage('/login');
$I->fillField('email', 'baby.doe@gmail.com');
$I->fillField('password', 'gugugaga');

$I->click('Login');
$I->amOnPage('/posts');

$I->See($publicPostTitle);
$I->dontSee($privatePostTitle_1);
$I->dontSee($privatePostTitle_2);
