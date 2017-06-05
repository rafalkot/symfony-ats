<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Project\ValueObject\ProjectDuration;

class ProjectDurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_has_a_start_date()
    {
        $date = new \DateTimeImmutable();
        $duration = new ProjectDuration($date, null);

        $this->assertInstanceOf(\DateTimeImmutable::class, $duration->getStart());
        $this->assertEquals($date->format('Y-m-d'), $duration->getStart()->format('Y-m-d'));
    }

    /**
     * @test
     */
    public function it_has_an_end_date()
    {
        $date = new \DateTimeImmutable('today');
        $date2 = new \DateTimeImmutable('tomorrow');

        $duration = new ProjectDuration($date, $date2);

        $this->assertInstanceOf(\DateTimeImmutable::class, $duration->getEnd());
        $this->assertEquals($date2->format('Y-m-d'), $duration->getEnd()->format('Y-m-d'));
        $this->assertTrue($duration->hasEnd());
    }

    /**
     * @test
     */
    public function it_accepts_null_as_end_date()
    {
        $date = new \DateTimeImmutable();
        $duration = new ProjectDuration($date, null);

        $this->assertNull($duration->getEnd());
        $this->assertFalse($duration->hasEnd());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_on_end_date_smaller_than_start_date()
    {
        $duration = new ProjectDuration(new \DateTimeImmutable(),
            \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_on_equal_dates()
    {
        $duration = new ProjectDuration(new \DateTimeImmutable(), new \DateTimeImmutable());
    }

    /**
     * @test
     */
    public function it_is_same_as_duration_with_same_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');

        $duration1 = new ProjectDuration($date1, $date2);
        $duration2 = new ProjectDuration($date1, $date2);
        $this->assertTrue($duration1->equals($duration2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_duration_with_different_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $duration1 = new ProjectDuration($date1, $date2);

        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');
        $date4 = \DateTimeImmutable::createFromFormat('Y-m-d', '1993-10-10');
        $duration2 = new ProjectDuration($date3, $date4);

        $this->assertFalse($duration1->equals($duration2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_duration_with_same_start_and_different_end_properties()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');

        $duration1 = new ProjectDuration($date1, $date2);
        $duration2 = new ProjectDuration($date1, $date3);
        $this->assertFalse($duration1->equals($duration2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as_duration_with_same_end_and_different_start()
    {
        $date1 = \DateTimeImmutable::createFromFormat('Y-m-d', '1990-10-10');
        $date2 = \DateTimeImmutable::createFromFormat('Y-m-d', '1991-10-10');
        $date3 = \DateTimeImmutable::createFromFormat('Y-m-d', '1992-10-10');

        $duration1 = new ProjectDuration($date1, $date3);
        $duration2 = new ProjectDuration($date2, $date3);
        $this->assertFalse($duration1->equals($duration2));
    }

}