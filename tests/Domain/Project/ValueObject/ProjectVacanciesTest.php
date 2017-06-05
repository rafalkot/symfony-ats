<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Project\ValueObject\ProjectVacancies;

class ProjectVacanciesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_constructs_from_int()
    {
        $projectVacancies = new ProjectVacancies(3);
        $this->assertEquals(3, $projectVacancies->vacancies());
    }

    /**
     * @test
     */
    public function it_constructs_from_null()
    {
        $projectVacancies = new ProjectVacancies(null);
        $this->assertNull($projectVacancies->vacancies());

        $projectVacancies = new ProjectVacancies();
        $this->assertNull($projectVacancies->vacancies());
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $projectVacancies = new ProjectVacancies(3);
        $projectVacancies2 = new ProjectVacancies(3);

        $this->assertTrue($projectVacancies->equals($projectVacancies2));

        $projectVacancies = new ProjectVacancies(null);
        $projectVacancies2 = new ProjectVacancies(null);

        $this->assertTrue($projectVacancies->equals($projectVacancies2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $projectVacancies = new ProjectVacancies(3);
        $projectVacancies2 = new ProjectVacancies(4);

        $this->assertFalse($projectVacancies->equals($projectVacancies2));

        $projectVacancies = new ProjectVacancies(3);
        $projectVacancies2 = new ProjectVacancies();

        $this->assertFalse($projectVacancies->equals($projectVacancies2));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectVacanciesInvalidValue
     */
    public function is_throws_exception_on_value_smaller_than_min_value()
    {
        $projectVacancies = new ProjectVacancies(ProjectVacancies::MIN_VACANCIES - 1);
    }

    /**
     * @test
     */
    public function is_doesnt_throw_exception_on_value_equal_to_min_value()
    {
        $projectVacancies = new ProjectVacancies(ProjectVacancies::MIN_VACANCIES);
        $this->assertEquals(ProjectVacancies::MIN_VACANCIES, $projectVacancies->vacancies());
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectVacanciesInvalidValue
     */
    public function is_throws_exception_on_value_greater_than_max_value()
    {
        $projectVacancies = new ProjectVacancies(ProjectVacancies::MAX_VACANCIES + 1);
    }

    /**
     * @test
     */
    public function is_throws_exception_on_value_equal_to_max_value()
    {
        $projectVacancies = new ProjectVacancies(ProjectVacancies::MAX_VACANCIES);
        $this->assertEquals(ProjectVacancies::MAX_VACANCIES, $projectVacancies->vacancies());
    }
}