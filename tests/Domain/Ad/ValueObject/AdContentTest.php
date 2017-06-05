<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Ad\ValueObject\AdContent;

class AdContentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $adContent = new AdContent('Ad content');
        $this->assertEquals('Ad content', $adContent->content());
    }

    /**
     * @test
     */
    public function it_casts_to_string()
    {
        $adContent = new AdContent('Ad content');
        $this->assertEquals('Ad content', (string)$adContent);
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $adContent = new AdContent('Ad content');
        $adContent2 = new AdContent('Ad content');

        $this->assertTrue($adContent->equals($adContent2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $adContent = new AdContent('Ad content');
        $adContent2 = new AdContent('Ad content 2');

        $this->assertFalse($adContent->equals($adContent2));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdContentIsEmptyException
     */
    public function is_throws_exception_on_empty_content()
    {
        $adContent = new AdContent('');
    }
}