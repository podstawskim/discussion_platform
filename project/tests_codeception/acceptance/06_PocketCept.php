<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo('Charge wallet and reward posts');

$I->amOnPage('/login');

$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');

$I->click('Login');

$I->see('0 $$');

$userID = '2';
$PostTitle1 = "test 1 post";
$PostContent1 = "test post 1";
$PostTitle2 = "test 2 post";
$PostContent2 = "test post 2";
$PostTitle3 = "test 3 post";
$PostContent3 = "test post 3";

$PostID1 = $I->haveInDatabase('posts', ['user_id'=> $userID, 'title' => $PostTitle1, 'content' => $PostContent1]);
$PostID2 = $I->haveInDatabase('posts', ['user_id'=> $userID, 'title' => $PostTitle2, 'content' => $PostContent2]);
$PostID3 = $I->haveInDatabase('posts', ['user_id'=> $userID, 'title' => $PostTitle3, 'content' => $PostContent3]);

$I->amOnPage('/posts/'.$PostID2);
$I->see('This post has 0 points.');
$I->see('You do not have enough points to award this post! Boost your pocket ');
$I->seeLink('here', '/pocket');
$I->click('here');

$I->seeCurrentUrlEquals('/pocket');
$I->see('Oops, you have no points in your pocket!');

$boostValue = 15;
$I->fillField('#boost', $boostValue);
$I->click('Boost');

$I->seeCurrentUrlEquals('/pocket');
$I->see($boostValue.' $$');
$I->see('You have '.$boostValue.' points in your pocket!');

$I->amOnPage('/posts/'.$PostID2);
$I->click('#post_'.$PostID2.'_reward');
$I->seeCurrentUrlEquals('/posts/'.$PostID2);
$I->see('This post has 5 points.');

$I->amOnPage('/posts/');
//patrzenie po tabeli tr[1]-spis, tr[2]-najwyższy post td[3]-punkty
$I->see('5','//table//tr[2]//td[3]//text()');
//sprawdzanie czy posty są w dobrej kolejności
$I->see($PostTitle2,'//table//tr[2]//td[1]//text()');
$I->see($PostTitle1,'//table//tr[3]//td[1]//text()');
$I->see($PostTitle3,'//table//tr[4]//td[1]//text()');

//doładowanie innego postu na 10; sprawadzenie poprawności kolejności
$I->amOnPage('/posts/'.$PostID3);
$I->click('#post_'.$PostID3.'_reward');
$I->seeCurrentUrlEquals('/posts/'.$PostID3);
$I->see('This post has 5 points.');
$I->click('#post_'.$PostID3.'_reward');
$I->seeCurrentUrlEquals('/posts/'.$PostID3);
$I->see('This post has 10 points.');

$I->amOnPage('/posts/');

$I->see('10','//table//tr[2]//td[3]//text()');
$I->see('5','//table//tr[3]//td[3]//text()');
//sprawdzanie czy posty są w dobrej kolejności
$I->see($PostTitle3,'//table//tr[2]//td[1]//text()');
$I->see($PostTitle2,'//table//tr[3]//td[1]//text()');
$I->see($PostTitle1,'//table//tr[4]//td[1]//text()');
