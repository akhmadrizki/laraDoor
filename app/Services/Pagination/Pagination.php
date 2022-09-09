<?php

namespace App\Services\Pagination;

use App\Services\Database\QueryBuilder;

class Pagination
{
    public function __construct(
        protected array $data,
        protected int $perPage,
        protected int $page,
        protected int $total,
        protected int $onEachSide,
        protected $formatFunction = null,
    ) {
    }

    public static function make(QueryBuilder $query, int $perPage, int $page, int $onEachSide): static
    {
        $page    = max(1, $page);
        $perPage = max(1, $perPage);
        $total   = $query->count();

        $offset  = ($page - 1) * $perPage;
        $data    = $query->limit($offset, $perPage)->get();

        // dd($data);
        return new static(data: $data, perPage: $perPage, page: $page, total: $total, onEachSide: $onEachSide);
    }

    public function currentPage()
    {
        return $this->page;
    }

    public function getTotalPage(): int
    {
        return ceil($this->total / $this->perPage);
    }

    public function isEmpty(): bool
    {
        return $this->getTotalPage() <= 1;
    }

    public function hasPrevious(): bool
    {
        return $this->page != 1;
    }

    public function hasNext(): bool
    {
        return $this->page != $this->getTotalPage();
    }

    public static function getUrlParam(): string
    {
        return "page";
    }

    public function nextPage(): string
    {
        return "?" . (static::getUrlParam()) . "=" . $this->page + 1;
    }

    public function previousPage(): string
    {
        return "?" . (static::getUrlParam()) . "=" . $this->page - 1;
    }

    public function setFormater($value)
    {
        $this->formatFunction = $value;
    }

    public function getData(): array
    {
        return array_map($this->formatFunction, $this->data);
    }

    public function buildPaginations(): array
    {
        $total = $this->getTotalPage();

        $start = $this->currentPage() - $this->onEachSide;
        $start = max(1, $start);

        $end   = ($this->onEachSide * 2) + $start;
        $end   = min($end, $total);

        $toPage = $end;

        if ($toPage === $total) {
            $start = $toPage - ($this->onEachSide * 2);
            $start = max(1, $start);
        }

        $pages = [];

        for ($page = $start; $page <= $toPage; $page++) {
            $pages[] = $page;
        }

        return $pages;
    }

    public function pageLink(int $paginate): string
    {
        return "?" . (static::getUrlParam()) . "=" . $paginate;
    }

    public function returnPagination()
    {
        return view('pagination', ['pagination' => $this]);
    }
}
