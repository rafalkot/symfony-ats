<?php

namespace Ats\Infrastructure\Query\Sql\Project;

use Ats\Application\Core\View\PaginatedViewCollection;
use Ats\Application\Core\View\ViewCollection;
use Ats\Application\Project\Query\GetAllProjectsQuery;
use Ats\Application\Project\View\ProjectView;
use Doctrine\DBAL\Connection;

class GetAllProjectsQueryHandler
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * GetAllProjectsQueryHandler constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle(GetAllProjectsQuery $query)
    {
        $sqlQuery = $this->connection->createQueryBuilder()
            ->select('COUNT(id)')
            ->from('project');
        $total = (int)$this->connection->fetchColumn($sqlQuery);

        $sqlQuery = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('project');

        if (!$query->page()) {
            return new ViewCollection(
                array_map([$this, 'createView'], $this->connection->fetchAll($sqlQuery))
            );
        }

        $offset = $query->perPage() * ($query->page() - 1);
        $sqlQuery->setFirstResult($offset)
            ->setMaxResults($query->perPage());

        return new PaginatedViewCollection(
            array_map([$this, 'createView'], $this->connection->fetchAll($sqlQuery)),
            $total, $query->page(),
            $query->perPage()
        );
    }

    protected function createView($project)
    {
        return new ProjectView(
            $project['id'],
            $project['name'],
            $project['start_date'],
            $project['end_date'],
            $project['vacancies']
        );
    }
}