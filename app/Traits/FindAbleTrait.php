<?php

namespace App\Traits;

use App\Repositories\BaseRepositories;

trait FindAbleTrait
{
    protected $model;

    /**
     * @var int|mixed
     */
    private $per_page;

     /**
     * @var string|mixed
     */
    private $page_name;

    /**
     * @var array
     */
    private $relations = [];

    /**
     * @var array
     */
    private $columns = ['*'];

    /**
     * @var array
     */
    private $scopes = [];

    /**
     * @var array
     */
    private $counts = [];

    /**
     * @var array
     */
    private $filters;

    /**
     * @var array
     */
    private $orders;

    public function findOneById($id)
    {
        return $this->model::with($this->getRelations())
            ->select($this->getColumns())
            ->withCount($this->getCounts())
            ->scopes($this->getScopes())
            ->findOrFail($id);
    }

    public function findOneBy(array $params)
    {
        return $this->model::with($this->getRelations())
            ->select($this->getColumns())
            ->where($params)
            ->withCount($this->getCounts())
            ->scopes($this->getScopes())
            ->firstOrFail();
    }

    public function findBy(array $params)
    {
        $query = $this->model::with($this->getRelations())
            ->select($this->getColumns())
            ->where($params)
            ->withCount($this->getCounts())
            ->scopes($this->getScopes())
            ->newQuery();

        return $this->applyFilter($query);
    }

    public function findByFilter()
    {
        $query = $this->model::with($this->getRelations())
            ->select($this->getColumns())
            ->withCount($this->getCounts())
            ->scopes($this->getScopes())
            ->newQuery();

        return $this->applyFilter($query);
    }

    public function setPerPage($per_page): BaseRepositories
    {
        $this->per_page = is_numeric($per_page) ? $per_page : 10;
        return $this;
    }

    public function setPageName($page_name): BaseRepositories
    {
        $this->page_name = !empty($page_name) ? $page_name : 'page';
        return $this;
    }

    public function setFilters(array $filters = []): BaseRepositories
    {
        //        $this->relations = array_merge($filters, $this->filters);
        $this->filters = $filters;
        return $this;
    }

    public function setRelations(array $relations = []): BaseRepositories
    {
        $this->relations = $relations;
        return $this;
    }

    public function setCounts(array $counts = []): BaseRepositories
    {
        $this->counts = $counts;
        return $this;
    }
 
    public function setColumns(array $columns = ['*']): BaseRepositories
    {
        $this->columns = $columns;
        return $this;
    }

    public function setScopes(array $scopes = []): BaseRepositories
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getPerPage()
    {
        return $this->per_page ?? 10;
    }

    /**
     * @return string|mixed
     */
    public function getPageName()
    {
        return $this->page_name ?? 'page';
    }

    /**
     * @return array
     */
    public function getRelations(): array
    {
        return $this->relations ?? [];
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns ?? ['*'];
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes ?? [];
    }

    /**
     * @return array
     */
    public function getCounts(): array
    {
        return $this->counts ?? [];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters ?? [];
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        if ($this->orders === null) {
            $this->orders = ['created_at' => 'desc'];
        }
        return $this->orders;
    }

    /**
     * @param array $orders
     * @return BaseRepositories
     */
    public function setOrders(array $orders = ['created_at' => 'desc']): BaseRepositories
    {
        $this->orders = $orders;
        return $this;
    }
}
