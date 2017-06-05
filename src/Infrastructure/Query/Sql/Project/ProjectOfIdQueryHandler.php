<?php

namespace Ats\Infrastructure\Query\Sql\Project;

use Ats\Application\Project\Query\ProjectOfIdQuery;
use Doctrine\DBAL\Connection;

class ProjectOfIdQueryHandler
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle(ProjectOfIdQuery $query)
    {
        $sqlQuery = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('project')
            ->where('id = ?');
        $project = $this->connection->fetchAssoc($sqlQuery, [$query->id()]);

        if (!$project) {
            return null;
        }

        return new ProjectViewModel(
            $project['id'],
            $project['name'],
            $project['start_date'],
            $project['end_date'],
            $project['vacancies']
        );
    }
}

class ProjectViewModel extends AbstractViewModel
{
    public $id;

    public $name;

    public $startDate;

    public $endDate;

    public $vacancies;

    /**
     * ProjectViewModel constructor.
     * @param $id
     * @param $name
     * @param $startDate
     * @param $endDate
     * @param $vacancies
     */
    public function __construct($id, $name, $startDate, $endDate, $vacancies)
    {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vacancies = $vacancies;
        parent::__construct([]);
    }
}

abstract class AbstractViewModel
{
    public function __construct($data)
    {
        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }
    }
}

class ViewModelCollection extends \ArrayIterator
{
    public function models()
    {
        return $this->getArrayCopy();
    }
}

class PaginatedViewModelCollection extends ViewModelCollection
{
    protected $total;

    protected $currentPage;

    protected $perPage;

    protected $totalPages;

    public function __construct(array $array = array(), int $total, int $currentPage, int $perPage = null)
    {
        parent::__construct($array);

        $this->total = $total;
        $this->currentPage = $currentPage;
        $this->perPage = $perPage ? $perPage : 20;
        $this->totalPages = ceil($this->total / $this->perPage);
    }

    public function total(): int
    {
        return $this->total;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }

    public function nextPage()
    {
        return $this->currentPage < $this->totalPages ? ($this->currentPage + 1) : null;
    }

    public function prevPage()
    {
        return $this->currentPage > 1 ? ($this->currentPage - 1) : null;
    }

    public function lastPage(): int
    {
        return $this->totalPages;
    }

}