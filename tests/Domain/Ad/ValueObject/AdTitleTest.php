<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Ad\ValueObject\AdTitle;

class AdTitleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $adTitle = new AdTitle('Ad title');
        $this->assertEquals('Ad title', $adTitle->title());
    }

    /**
     * @test
     */
    public function it_casts_to_string()
    {
        $adContent = new AdTitle('Ad title');
        $this->assertEquals('Ad title', (string)$adContent);
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $adTitle = new AdTitle('Ad title');
        $adTitle2 = new AdTitle('Ad title');

        $this->assertTrue($adTitle->equals($adTitle2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $adTitle = new AdTitle('Ad title');
        $adTitle2 = new AdTitle('Ad title 2');

        $this->assertFalse($adTitle->equals($adTitle2));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdTitleIsEmptyException
     */
    public function is_throws_exception_on_empty_titlee()
    {
        $adTitle = new AdTitle('');
    }
}