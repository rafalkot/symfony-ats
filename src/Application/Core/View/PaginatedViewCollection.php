<?php

declare(strict_types=1);

namespace Ats\Application\Core\View;

class PaginatedViewCollection extends ViewCollection
{
    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var int
     */
    protected $totalPages;

    public function __construct(array $array = array(), int $total, int $currentPage, int $perPage = null)
    {
        parent::__construct($array);

        $this->total = $total;
        $this->currentPage = $currentPage;
        $this->perPage = $perPage ? $perPage : 20;
        $this->totalPages = (int)ceil($this->total / $this->perPage);
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
