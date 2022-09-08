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
        protected $formatFunction = null,
    ) {
    }

    public static function make(QueryBuilder $query, int $perPage, int $page): static
    {
        $total = $query->count();

        $totalPaginate = ceil($total / $perPage);

        if ($page > $totalPaginate) {
            $page = $totalPaginate;
        }

        if ($page < 1) {
            $page = 1;
        }

        $offset = ($page - 1) * $perPage;
        $data   = $query->limit($offset, $perPage)->get();

        // dd($data);
        return new static(data: $data, perPage: $perPage, page: $page, total: $total);
    }

    public static function getUrlParam(): string
    {
        return "page";
    }

    public function setFormater($value)
    {
        $this->formatFunction = $value;
    }

    public function getData(): array
    {
        return array_map($this->formatFunction, $this->data);
    }

    public function showPagination()
    {
        $getUrl      = $this->getUrlParam();
        $currentPage = $this->page;
        $total       = ceil($this->total / $this->perPage);

        $start       = $currentPage - 2;
        $end         = $currentPage + 2;

        if ($end > $total) {
            $start -= ($end - $total);
            $end = $total;
        }

        if ($start <= 0) {
            $end += (($start - 1) * (-1)); // 5
            $start = 1;
        }

        $end = $end > $total ? $total : $end;

        return view('pagination', compact('total', 'currentPage', 'getUrl', 'start', 'end'));
    }
}
