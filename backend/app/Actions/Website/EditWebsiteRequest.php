<?php
declare(strict_types=1);

namespace App\Actions\Website;

final class EditWebsiteRequest
{
    private $name;
    private $singlePage;
    private $id;

    public function __construct(
        int $id,
        string $name,
        bool $singlePage
    ) {
        $this->name = $name;
        $this->singlePage = $singlePage;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSinglePage(): bool
    {
        return $this->singlePage;
    }
}
