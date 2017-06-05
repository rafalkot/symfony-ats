<?php

declare(strict_types=1);

namespace Ats\Application\Ad\Command;

class PostAdCommand
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $projectId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $publicationDate;

    /**
     * @var string|null
     */
    protected $expirationDate;

    /**
     * PostAdCommand constructor.
     * @param string $id
     * @param string $projectId
     * @param string $title
     * @param string $content
     * @param string $publicationDate
     * @param null|string $expirationDate
     */
    public function __construct($id, $projectId, $title, $content, $publicationDate, $expirationDate = null)
    {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->title = $title;
        $this->content = $content;
        $this->publicationDate = $publicationDate;
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function projectId(): string
    {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function publicationDate(): string
    {
        return $this->publicationDate;
    }

    /**
     * @return null|string
     */
    public function expirationDate()
    {
        return $this->expirationDate;
    }
}
