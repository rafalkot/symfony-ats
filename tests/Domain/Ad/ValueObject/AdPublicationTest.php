<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Ad\ValueObject\AdPublication;

class AdPublicationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_has_a_start_date()
    {
        $date = new \DateTimeImmutable();
        $publication = new AdPublication($date, null);

        $this->assertInstanceOf(\DateTimeImmutable::class, $publication->start());
        $this->assertEquals($date->format('Y-m-d'), $publication->start()->format('Y-m-d'));
    }

    /**
     * @test
     */
    public function it_has_an_end_date()
    {
        $date = new \DateTimeImmutable('today');
        $date2 = new \DateTimeImmutable('tomorrow');

        $publication = new AdPublication($date, $date2);

        $this->assertInstanceOf(\DateTimeImmutable::class, $publication->end());
        $this->assertEquals($date2->format('Y-m-d'), $publication->end()->format('Y-m-d'));
        $this->assertTrue($publication->hasEnd());
    }

    /**
     * @test
     */
    public function it_accepts_null_as_end_date()
    {
        $date = new \DateTimeImmutable();
        $publication = new AdPublication($date, null);

        $this->assertNull($publication->end());
        $this->assertFalse($publication->hasEnd());
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdPublicationEndDateIsEarlierThanStartDate
     */
    public function it_throws_exception_on_end_date_smaller_than_start_date()
    {
        $publication = new AdPublication(new \DateTimeImmutable(),
            \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10'));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdPublicationEndDateIsEarlierThanStartDate
     */
    public function it_throws_exception_on_equal_dates()
    {
        $publication = new AdPublication(new \DateTimeImmutable(), new \DateTimeImmutable());
    }

    /**
     * @test
     */
    public function it_is_same_as_publication_with_same_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');

        $publication1 = new AdPublication($date1, $date2);
        $publication2 = new AdPublication($date1, $date2);
        $this->assertTrue($publication1->equals($publication2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_publication_with_different_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $publication1 = new AdPublication($date1, $date2);

        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');
        $date4 = \DateTimeImmutable::createFromFormat('Y-m-d', '1993-10-10');
        $publication2 = new AdPublication($date3, $date4);

        $this->assertFalse($publication1->equals($publication2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_publication_with_same_start_and_different_end_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');

        $publication1 = new AdPublication($date1, $date2);
        $publication2 = new AdPublication($date1, $date3);
        $this->assertFalse($publication1->equals($publication2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_publication_with_same_end_and_different_start()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');

        $publication1 = new AdPublication($date1, $date3);
        $publication2 = new AdPublication($date2, $date3);
        $this->assertFalse($publication1->equals($publication2));
    }

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $publication = AdPublication::fromString(date('Y-m-d'), date('Y-m-d', strtotime('+30 days')));
        $this->assertInstanceOf(AdPublication::class, $publication);
    }

}