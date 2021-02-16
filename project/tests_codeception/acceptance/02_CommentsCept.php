<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo('Create and edit comments');

$I->amOnPage('/login');
$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');
$I->click('Login');

$PostTitle = "test public post";
$PostContent = "test public";
$userID = '1';
$PostID = $I->haveInDatabase('posts', ['user_id' => $userID, 'title' => $PostTitle, 'content' => $PostContent]);

$I->click('Posts');

$I->amOnPage('/posts/' . $PostID);

$Comment_No1 = "1";                                                         //tworzenie komentarza pod postem
$I->fillField('text', $Comment_No1);
$I->click('Create comment');

$idComment_1 = $I->grabFromDatabase('comments', 'id', ['text' => $Comment_No1,]);

$I->seeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => null,
    'id' => $idComment_1,
    'text' => $Comment_No1,
]);

$I->seeCurrentUrlEquals('/posts/' . $PostID . '#comment_' . $idComment_1);
$I->seeInField('#comment_' . $idComment_1 . '_content', $Comment_No1);
$I->seeElement('#comment_' . $idComment_1 . '_delete');
$I->seeElement('#comment_' . $idComment_1 . '_edit');
$I->seeElement('#comment_' . $idComment_1 . '_reply_button');

$I->amOnPage('/dashboard');
$I->submitForm("#Logout", array());
$I->amOnPage('/posts/' . $PostID);                       //guest może wyświetlać dyskusje
$I->seeInField('#comment_' . $idComment_1 . '_content', $Comment_No1);
$I->dontSeeElement('#comment_' . $idComment_1 . '_delete');
$I->dontSeeElement('#comment_' . $idComment_1 . '_edit');
$I->dontSeeElement('#comment_' . $idComment_1 . '_reply_button');
$I->dontSeeElement('#text');
$I->dontSeeLink('Create comment');
$I->see('Login to comment!');

$I->amOnPage('/login');
$I->fillField('email', 'jane.doe@gmail.com');
$I->fillField('password', 'passwd');
$I->click('Login');

$I->amOnPage('/posts/' . $PostID);
$I->seeInField('#comment_' . $idComment_1 . '_content', $Comment_No1);
$I->dontSeeElement('#comment_' . $idComment_1 . '_delete');
$I->dontSeeElement('#comment_' . $idComment_1 . '_edit');
$I->seeElement('#comment_' . $idComment_1 . '_reply_button');
$I->dontSee('Login to comment!');

$Comment_No2 = "2";                                                         //tworzenie komentarza pod komentarzem
$I->fillField('#comment_' . $idComment_1 . '_reply', $Comment_No2);
$I->submitForm('#comment_' . $idComment_1 . '_reply_form', array());

$idComment_2 = $I->grabFromDatabase('comments', 'id', ['text' => $Comment_No2,]);

$I->seeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_1,
    'id' => $idComment_2,
    'text' => $Comment_No2
]);
$I->seeCurrentUrlEquals('/posts/' . $PostID . '#comment_' . $idComment_2);

$Comment_No3 = "3";                                                         //tworzenie komentarza pod komentarzem 3lvl
$I->fillField('#comment_' . $idComment_2 . '_reply', $Comment_No3);
$I->submitForm('#comment_' . $idComment_2 . '_reply_form', array());

$idComment_3 = $I->grabFromDatabase('comments', 'id', ['text' => $Comment_No3,]);

$I->seeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_2,
    'id' => $idComment_3,
    'text' => $Comment_No3,
]);
// $I->seeCurrentUrlEquals('/posts/' . $PostID);
$I->seeCurrentUrlEquals('/posts/' . $PostID . '#comment_' . $idComment_3);
$I->click('#comment_' . $idComment_2 . '_delete');                          //usuwanie komentarza i jego dzieci

$I->dontSeeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_2,
    'id' => $idComment_3,
    'text' => $Comment_No3,
]);
$I->dontSeeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_1,
    'id' => $idComment_2,
    'text' => $Comment_No2,
]);

$Comment_No4 = "4";
$I->fillField('#comment_' . $idComment_1 . '_reply', $Comment_No4);
$I->submitForm('#comment_' . $idComment_1 . '_reply_form', array());

$idComment_4 = $I->grabFromDatabase('comments', 'id', ['text' => $Comment_No4,]);

$I->seeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_1,
    'id' => $idComment_4,
    'text' => $Comment_No4,
]);

$I->amOnPage('/dashboard');     //przelogoanie na John Doe w celu sprawdzenia edycji komentarza i usuwania posta
$I->submitForm("#Logout", array());
$I->amOnPage('/login');
$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');
$I->click('Login');

$I->amOnPage('/posts/' . $PostID);

$Comment_No1_New = "new 1";                                                 //edytowanie komentarza, dzieci pozostają

$I->click('#comment_' . $idComment_1 . '_edit');
$I->fillField('#comment_' . $idComment_1 . '_update', $Comment_No1_New);
$I->click('#comment_' . $idComment_1 . '_update_button');

$I->dontSeeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => null,
    'id' => $idComment_1,
    'text' => $Comment_No1,
]);

$I->seeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => null,
    'id' => $idComment_1,
    'text' => $Comment_No1_New,
]);

$PostNewContent = "1111111";                                                //edytowanie posta, dzieci pozostają
$I->click('#post_' . $PostID . '_edit');
$I->fillField('#content', $PostNewContent);
$I->click('Update');

$I->seeInField('#comment_' . $idComment_1 . '_content', $Comment_No1_New);
$I->seeInField('#comment_' . $idComment_4 . '_content', $Comment_No4);

$I->click('#post_' . $PostID . '_delete');                                //usuwanie posta, dzieci usunięte

$I->dontSeeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => null,
    'id' => $idComment_1,
    'text' => $Comment_No1_New,
]);
$I->dontSeeInDatabase('comments', [
    'commentable_id' => $PostID,
    'parent_id' => $idComment_1,
    'id' => $idComment_4,
    'text' => $Comment_No4,
]);
