<?php
namespace Chen\Library;

use \Phalcon\Mvc\User\Component;

class Paginator extends Component
{
	protected $_config;

	protected $_page;

	protected $_limitRows;

	protected $_dataFrom;

	protected $_isCache;

    protected $_condition;


	public function __construct($config)
	{
		if (is_array($config) === false) {
            exit;
        }

        $this->_config = $config;

        if (isset($this->_config['dataFrom']) === true) {
        	$this->_dataFrom = $this->_config['dataFrom'];
        }

        if (isset($this->_config['limit']) === true) {
        	$this->_limitRows = $this->_config['limit'];
        }

        if (isset($this->_config['page']) === true) {
        	$this->_page = $this->_config['page'];
        }

        if (isset($this->_config['cache']) === true) {
        	$this->_isCache = $this->_config['cache'];
        }

        if (isset($this->_config['condition']) === true) {
            $this->_condition = $this->_config['condition'];
        }

	}

	public function getPaginate()
	{
		$dataFrom = $this->_dataFrom;
		$limit = $this->_limitRows;
		$currentPage = $this->_page;
		$isCache = $this->_isCache;

		$itemCount = call_user_func(array($dataFrom, 'count'));

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
        $findConfig = array('order' => 'id DESC', 'limit' => array('number' => $limit, 'offset' => $start), $this->_condition);

        if ($isCache === true) {
        	$cacheKey = 'items-paginator-'.md5($dataFrom.$currentPage);
        	
        	$itemCountKey = 'itemCount-'.md5($dataFrom.$limit.$itemCount);
        	$itemsCacheCount = $this->modelsCache->get($itemCountKey);

        	if ((int)$itemsCacheCount != (int)$itemCount) {
        		$keys = $this->modelsCache->queryKeys('itemCount-');
				foreach ($keys as $key) {
    				$this->modelsCache->delete($key);
				}
				$this->modelsCache->delete($cacheKey);
        	}

        	if($itemsCacheCount === null) {
        		$this->modelsCache->save($itemCountKey, $itemCount);
        	}

        	$itemsFind = $this->modelsCache->get($cacheKey, 120);
	        if ($itemsFind === null) {

	            $itemsFind = call_user_func_array(array($dataFrom, 'find'), array($findConfig));
	            $this->modelsCache->save($cacheKey, $itemsFind);
	        }

    	} else {
    		$itemsFind = call_user_func_array(array($dataFrom, 'find'), array($findConfig));
    	}

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