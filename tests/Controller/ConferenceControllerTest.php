<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class ConferenceControllerTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient(['external_base_uri' => $_SERVER['SYMFONY_PROJECT_DEFAULT_ROUTE_URL']]);
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback!');
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/conference/spain-2010');
        $client->submitForm('Submit', [
            'comment_form[author]' => 'davide',
            'comment_form[text]' => 'text text',
            'comment_form[email]' => 'test@gmail.com',
            'comment_form[photo]' => dirname(__DIR__, 2).'/publicimages/under-construction.gif',

        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('h2:contains("Conference")');
    }
    
    public function testConferencePage()
    {
        $string = 'There are 1 comments.';
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('View');

        $this->assertPageTitleContains('spain');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'spain 2010');
        $this->assertSelectorExists('div:contains("comments")');
    }
}
