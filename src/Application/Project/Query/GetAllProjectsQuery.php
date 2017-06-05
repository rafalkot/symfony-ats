<?php

namespace Ats\Application\Project\Query;


class GetAllProjectsQuery
{
    protected $page;

    protected $perPage;

    /**
     * GetAllProjectsQuery constructor.
     * @param $page
     * @param $perPage
     */
    public function __construct(int $page = null, int $perPage = null)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * @return mixed
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function perPage()
    {
        return $this->perPage;
    }
}