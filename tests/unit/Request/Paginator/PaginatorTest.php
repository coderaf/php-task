<?php

declare(strict_types=1);

namespace App\Tests\Request\Paginator;

use App\Request\Paginator\Pagination;
use App\Request\Paginator\Paginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testGetOffsetForPaginationForPage1()
    {
        $result = Paginator::getOffsetForPagination(new Pagination(1, 10));

        $this->assertEquals(0, $result);
    }

    public function testGetOffsetForPaginationForPage10With10Limit()
    {
        $result = Paginator::getOffsetForPagination(new Pagination(10, 10));

        $this->assertEquals(90, $result);
    }
}