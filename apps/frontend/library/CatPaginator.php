<?php
namespace Chen\Frontend\Library;
use \Phalcon\Mvc\User\Component;

class CatPaginator extends Component
{
	protected $_config;

	protected $_page;

	protected $_limitRows;

	protected $_dataFrom;

	protected $_dataFromId;

	protected $_isCache;

    public function __construct($config)
	{
		if (is_array($config) === false) {
            exit;
        }

        $this->_config = $config;

        if (isset($this->_config['dataFrom']) === true) {
        	$this->_dataFrom = $this->_config['dataFrom'];
        }

        if (isset($this->_config['dataFromId']) === true) {
        	$this->_dataFromId = $this->_config['dataFromId'];
        }

        if (isset($this->_config['limit']) === true) {
        	$this->_limitRows = $this->_config['limit'];
        }

        if (isset($this->_config['page']) === true) {
        	$this->_page = $this->_config['page'];
        }

	}

	public function getPaginate()
	{
		$dataFrom = $this->_dataFrom;
		$dataFromId = $this->_dataFromId;
		$limit = $this->_limitRows;
		$currentPage = $this->_page;
		$isCache = $this->_isCache;

		$itemCountPhql = 'SELECT COUNT(Chen\Models\\'.$dataFrom.'.posts_id) AS post_count FROM Chen\Models\\'.$dataFrom.' WHERE '.$dataFromId;
        $itemCountQuery = $this->modelsManager->executeQuery($itemCountPhql);
        
        foreach ($itemCountQuery as $row) {
            $itemCount = $row->post_count;
        }

		$total_pages = ceil($itemCount / $limit);

		if (empty($currentPage)) {
            $currentPage = 1;
        }

        if ($currentPage > $total_pages) {
            $currentPage = $total_pages;
        }

        if ($currentPage == 1) {
            $before = $currentPage;
        } else {
            $before = $currentPage - 1;
        }

        if ($currentPage == $total_pages) {
            $next = $currentPage;
        } else {
            $next = $currentPage + 1;
        }

        $start = ($currentPage - 1) * $limit;
        if ($start < 0) {
        	$start = 0;
        }

        $itemsFindPhql = 'SELECT Chen\Models\Posts.* FROM Chen\Models\\'.$dataFrom.' INNER JOIN Chen\Models\Posts WHERE '.$dataFromId.' ORDER BY Chen\Models\Posts.id DESC LIMIT '.$limit.' OFFSET '.$start;
        
    	$itemsFind = $this->modelsManager->executeQuery($itemsFindPhql);

		$pageItem = new \stdClass();
        $pageItem->items = $itemsFind;
        $pageItem->current = $currentPage;
        $pageItem->before = $before;
        $pageItem->next = $next;
        $pageItem->last = $total_pages;
        $pageItem->total_pages = $total_pages;
        $pageItem->total_items = $itemCount;

        return $pageItem;
	}

}