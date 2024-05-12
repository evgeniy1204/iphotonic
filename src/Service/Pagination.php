<?php
namespace App\Service;

use LogicException;

class Pagination
{
    public const FIELD_NAME_TOTAL = 'total';
    public const FIELD_NAME_ITEMS = 'items';
    public const FIELD_NAME_CURRENT_PAGE = 'currentPage';
    public const FIELD_NAME_TOTAL_PAGES = 'totalPages';

    private const DEFAULT_LIMIT = 25;

    private const MAX_PROCESSED_ITEMS = 3000;
    private const MAX_PER_PAGE = 50;

    private ?int $perPage;

    private ?int $currentPage;

    private ?int $offset;

    private int $totalItems;

    private ?int $fixedPageCount;

    public function __construct(?int $perPage = null, ?int $page = null, ?int $offset = null)
    {
        if (is_null($page) && is_null($offset)) {
            $page = 1;
        }
        if (!is_null($page)) {
            $offset = null;
        }
        $this->perPage = $this->normalizeLimit($perPage);
        $this->currentPage = $this->normalizePage($page);
        $this->offset = $this->normalizeOffset($offset);
        $this->validate();
        $this->totalItems = 0;
        $this->fixedPageCount = null;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function setTotalItems(int $totalItems): void
    {
        $this->totalItems = $totalItems;
    }

	public function getPerPage(): int
	{
		return $this->perPage;
	}

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        if ($this->perPage === 0) {
            return 0;
        }

        return (int) ceil($this->totalItems / $this->perPage);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): ?int
    {
        if ($this->isPagePagination()) {
            return $this->currentPage;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getNextPage(): ?int
    {
        if ($this->isPagePagination()) {
            return $this->currentPage + 1;
        }

        return null;
    }

    /**
     * @return int
     */
    public function calculateOffset(): int
    {
        if ($this->isPagePagination()) {
            return ($this->currentPage - 1) * $this->perPage;
        }

        return $this->offset;
    }

    /**
     * @return array
     */
    public function buildEmptyPaginationResponse(): array
    {
        return $this->buildPaginationResponse([]);
    }

    /**
     * @param array    $items
     * @param int|null $totalItems
     * @return array
     */
    public function buildPaginationResponse(array $items, ?int $totalItems = null): array
    {
        if (!is_null($totalItems)) {
            $this->setTotalItems($totalItems);
        }
        $items = array_values($items);
        $result = [
            self::FIELD_NAME_TOTAL => $this->getTotalItems(),
            self::FIELD_NAME_ITEMS => $items,
        ];
        if ($this->isPagePagination()) {
            $result[self::FIELD_NAME_CURRENT_PAGE] = $this->getCurrentPage();
            $total = $this->getTotalPages();
            if ($this->fixedPageCount) {
                $total = $this->fixedPageCount;
            }
            $result[self::FIELD_NAME_TOTAL_PAGES] = $total;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isPagePagination(): bool
    {
        return !is_null($this->currentPage);
    }

    /**
     * @param mixed $page
     * @return int|null
     */
    private function normalizePage($page): ?int
    {
        if (is_null($page)) {
            return null;
        }
        $page = (int) $page;
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

    /**
     * @param int $perPage
     * @return int
     */
    private function normalizeLimit($perPage): int
    {
        if (is_null($perPage)) {
            return self::DEFAULT_LIMIT;
        }
        $perPage = (int) $perPage;
        if ($perPage < 0) {
            return self::DEFAULT_LIMIT;
        }

        return (int) $perPage;
    }

    /**
     * @param int|null $offset
     * @return int|null
     */
    private function normalizeOffset($offset): ?int
    {
        if (is_null($offset)) {
            return null;
        }
        $offset = (int) $offset;
        if ($offset < 0) {
            return 0;
        }

        return (int) $offset;
    }

    private function validate(): void
    {
        if ($this->perPage > self::MAX_PER_PAGE) {
            throw new LogicException('Per page limit is reached');
        }
        $processedItems = $this->calculateOffset() + $this->perPage;
        if ($processedItems > self::MAX_PROCESSED_ITEMS) {
            throw new LogicException('Processed items limit is reached');
        }
    }
}
