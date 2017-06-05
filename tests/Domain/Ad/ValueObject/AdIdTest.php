<?php

namespace Tests\Domain\Ad\ValueObject;


use Ats\Domain\Ad\ValueObject\AdId;

class AdIdTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_generates_self_object()
    {
        $this->assertInstanceOf(AdId::class, AdId::generate());
    }

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $adId = new AdId('1234');
        $this->assertEquals('1234', $adId->id());
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $adId = new AdId('1234');
        $adId2 = new AdId('1234');

        $this->assertTrue($adId->equals($adId2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $adId = new AdId('1234');
        $adId2 = new AdId('12345');

        $this->assertFalse($adId->equals($adId2));
    }

    /**
     * @test
     */
    public function it_casts_to_string()
    {
        $adId = new AdId('1234');
        $this->assertEquals('1234', (string)$adId);
    }
}