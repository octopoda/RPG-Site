<?php
require_once (CLASS_PATH.DS.'display.php');

class SiteDisplay extends display {

	protected $handler = array('content'=>'content', 'news'=>'news', 'store'=>'ProductCategories');

	public function __construct($urlTitle="", $contentTitle="") {
		$this->setupUser();
		$this->navigationHandler($urlTitle, $contentTitle);
	}

/* ==========================================================
	Display Applications
========================================================= */

	public function displayNews() {
		$site = new Site();

		if ($site->configuration['News'] != 1) {
			return;
		}

		$news = new News();
		$news->listNews(3);
		$html = '<h3 class="newsHeader">Recent News</h3>';
		$html .= '<ul class="news">';
		foreach ($news->newsList as $item) {
			$item->summary = strip_tags($item->summary);

			if ($item->published == 0 || $item->access > $this->user->access) continue;
			$html .= '<li>';
			$html .= '<h4><a href="'. $item->directLink .'">'.$item->title.'</a></h4>';
			$html .= '<p>'.$item->summary.'</p>';
			$html .= '</li>';
		}

		$html .= "</ul>";
		$html .= '<div class="newsTriangle"></div>';
		return $html;
	}

	public function displayAds($placement) {
		$site = new Site();

		if ($site->configuration['Ads'] != 1) {
			return;
		}


		$ads = Ads::AdsFromPlacement($placement);

		if ($placement == 0  && empty($ads)) {
			$html = '<div class="fake-ad"><a href="/sponsors">Advertise Here</a><p>Click Here to Learn More</p></div>';
			echo  $html;
			return;
		} else if ($placement > 0 && empty($ads)) {
			return;
		}

		$html = '<section class="front-page-ad">';

		if (!is_array($ads)) {
			$html .= $ads;
		} else {
			foreach ($ads as $ad) {
				$html .= $ad->printImage;
			}
		}

		$html .= '</section>';

		echo $html;
	}


	public function displayFrontPage() {
		$items = FrontPage::listFrontPage();


		$html = '';
		$nTimes = 1;
		foreach ($items as $tab) {
			$class = ($nTimes == 1)? 'active' : '';
			$html .= 	'<article class="image hero-unit '.$class.'" style="background:url('.$tab->image_url.')">
					        <div class="number">'.$nTimes.'</div>
					        <div class="hero-wrapper">
					          <h1>'.$tab->title.'</h1>'.
					          $tab->content
					          .'
					          <a href="'.$tab->link.'" class="btn btn-primary btn-large">Learn More</a>
					        </div>
					    </article>';

			$nTimes++;
		}

		echo $html;
	}


	public function displayMiniCart() {
		$cart = new ShoppingCart();
		$html .= '<ul class="nav storeNav2 pull-right">';
		$html .= '<li><a href="/store/my_account.html" class="myAccount">My Account</a></li>';
		$html .= '<li><a class="icon-shopping-cart pull-right openCart"><span class="hide">Shopping Cart</span></a></li>';
		$html .= '<li><a href="#" class="mini-cart openC">'.$cart->miniCart().'</a></li>';
		$html .= '</ul>';
		echo $html;
	}


	public function displayStoreCategories() {

		$cats = ProductCategories::listCategories();



		$html = '<ul class="nav storeNav">';
		foreach ($cats as $id=>$item) {
			$c = new ProductCategories($id);

			if ($c->published == 1 && $this->user->access >= $c->access)
			 	$html .= '<li><a href="/store/'.$c->directLink.'">'.$item.'</a></li>';
			else
				continue;

		}

		$html .= '</ul>';
		echo $html;
	}
/* ==========================================================
	Paginations
========================================================= */


	public function  paginateClass($classname, $pageNumber, $orderby, $rate) {
		$class = new $classname();
		$html = "";

		$totalSize = count($class->fetchAll());

		$page = 1;
		$size = 10;

		if (isset($pageNumber)) $page = $pageNumber;

		$pagination = new Pagination($classname);
		$pagination->setupPagination($page, $size, $totalSize);
		$result = $class->fetchPublished($orderby, $rate, $pagination->getLimitSQL());

		foreach ($result as $content) {
			$c = new $classname($content[$class->idfield]);
			if ($classname == 'post' && $c->isPublished()) {
				$html .= $this->buildPaginationHTML($c);
			}
		}

		echo $html;
		echo $pagination->create_links();
	}


	public function buildPaginationHTML($object) {

		if ($object->table == 'post') {
			$user = new Users($object->user_id);
			$html  = '<div class="pagination"><hgroup>';
			$html .= '<h3><a href="'.$object->directLink.'">'.$object->title.'</a></h3>';
			$html .= '<h5>Author: '.$user->printName(). ' // Date: '.date("M d, Y", strtotime($object->publish_date)).'</h5>';
			$html .= '</hgroup>';
			$html .= '<p>'.  truncate($object->searchable, 400," ", "...").'</p>';
			$html .= '</div>';
		}

		return $html;
	}


	//End Comments

/* ==========================================================
	FORUM ARCHIVES
========================================================= */

/*  ===========================================
	Navigation Methods
	========================================= */


		public function archiveMenu () {
			$archive = new Archive();

			$years = $archive->returnYearList();
			$html = "<ul>";
			foreach ($years as $year) {
				$html .= '<li  class="arrow"><a class="year">'.$year.'</a>';
				$html .= $this->getMonths($year);
				$html .= '</li>';

			}
			$html .= "</ul>";

			echo $html;
		}

		private function getMonths($year) {
			$archive = new Archive();

			$months = $archive->getArchivesForYear($year);
			$months = array_reverse($months, true);
			if ($months != false) {
				$html = '<ul class="monthList">';
				foreach ($months as $k=>$month) {
					$html .= '<li sel="'.$k.'"><a class="month">'.$month.'</a></li>';
				}
				$html .= "</ul>";
			}
			return $html;
		}

		public function categoriesMenu() {
			$cat = new Categories();
			$list = $cat->listCategories();

			$html = '<ul class="categoryMenu">';
			foreach ($list as $k=>$sub) {
				$html .= '<li sel="'.$k.'" class="arrow"><a class="category">'.$sub.'</a>';
				$html .= $this->getSubCats($k);
				$html .= '</li>';
			}

			$html .= "</ul>";
			echo $html;
		}

		private function getSubCats($cat_id) {
			$cat = new Categories($cat_id);
			$subCats = $cat->subCatsForCategory($cat_id);
			$html = "";

			if ($subCats != false) {
				$html .= '<ul class="subList">';
				foreach ($subCats as $sub_id) {
					$sub = new SubCats($sub_id);
					$html .= '<li sel="'.$sub->sub_id.'"><a class="subCategory">'.$sub->sub_name.'</a></li>';
				}
				$html .= "</ul>";
			}

			return $html;

		}

/*  ===========================================
	Display Articles
	========================================= */

		public function displayArchive($pageNumber, $archive_id="") {
			if (empty($archive_id)) $archive_id = Archive::lastestArchive();

			$archive = new Archive($archive_id);
			if ($archive->published == 0) return;

			$html = $this->archiveInformation($archive_id);
			$archive->buildArticleList();

			$html .= '<div class="archive-article">';
			if ($archive->articleList != false) {
				foreach ($archive->articleList as $article) {
					$html .= $this->buildArticles($article);
				}
			} else {
				$html .= "<p>There are no articles for this archive.</p>";
			}

			$html .= '</div>';

			echo $html;

		}

		private function archiveInformation($archive_id) {
			$archive = new Archive($archive_id);

			$html = '<div class="archive-header">';
			$html .= '<p class="brand">'.$archive->archive_title.'<small> - Volume: '.$archive->volume.' Issue: '.$archive->issue.'</small></p>';
			if (!empty($archive->archive_link)) {
				$html .= '<ul class="archive-icons">
							<li><a target="_blank" href="'.$archive->archive_link.'" id="archive-download" class="icon-download" data-toggle="tooltip" title data-original-title="Download Full Issue" datat-placement="bottom" ></a></li>
						   <ul>';
			}
			$html .= '</div>';

			echo  $html;

		}

		private function buildArticles($article) {
			if ($article->published == 0) return;
			$html = '<article>';
			$html .= '<h4><a target="_blank" href="'.$article->article_link.'">'.$article->article_title.'</a></h4>';
			$html .= '<p class="author">'.$article->author.'</p>';
			$html .=  '<p class="description">'.$article->description.'</p>';
			$html .=  '<p class="categories"><span>Topics: </span>'.$article->listCategories().'</p>';
			$html .= '</article>';
			return $html;
		}



/*  ===========================================
	Display Categories
	========================================= */
		public function displayCategories($pageNumber, $sub_id="") {
			if (empty($sub_id)) $sub_id= Categories::topCategory();

			$sub = new SubCats($sub_id);
			if ($sub->published == 0) return;

			$sub->buildArticleList();

			$html = '<div class="archive-header"><p class="brand">'.$sub->sub_name.'</p></div>';
			$html .= '<div class="archive-article">';

			if ($sub->articleList != false) {
				foreach ($sub->articleList as $article) {
					$html .= $this->buildArticles($article);
				}

			} else {
				$html .= "<p>There are no articles for this category.</p>";
			}
			$html .= '</div>';

			echo $html;

		}


/*  ===========================================
	Search Methods
	========================================== */

		public function archiveSearch($string, $pageNumber) {
			global $db;

			$article = new Article();
			$totalSize = count($article->searchArticles($string));

			//Pagination
			$page = 1;
			$size = 5;

			if (isset($pageNumber)) $page = $pageNumber;


			$page = new Pagination();
			$page->setupPagination($pageNumber, $size, $totalSize);
			$page->setSearch($string);

			$articleList = $article->searchArticles($string, $page->getLimitSql());

			$html = '<div class="archive-header"><p class="brand">Searching For '.$string.'</p></div>';
			$html .= '<div class="archive-article">';

			if ($articleList != false) {
				foreach ($articleList as $art) {
					$article = new Article($art['article_id']);
					$html .= $this->buildArticles($article);
				}
			} else {
				$html .= "<h4>There are no articles for this search term.</h4>";
			}

			echo $html;
			echo $page->create_links();




		}


		private function buildSearch($result_set) {
			global $db;
			$html = '';

			foreach ($result_set as $row) {
				$content = new Content(Content::contentFromTitle($db->escapeString($row['title'])));

				$text = $row['content'];
				if (strlen($text) > 200) {
					$text = strip_tags($text);
 				   	$text = wordwrap($text, 200, "<br />");
					$text = substr($text, 0, strpos($text, "<br />"));
				}
				$html .="<div>";
				$html .= '<h3><a href="'.$content->directLink.'">'.$row['title'].'</a></h3>';
				$html .= '<p>'. $text.'</p>';
				$html .= '</div>';
			}

			return $html;
		}

/* ==========================================================
	Product Displays
========================================================= */
	public function displayFrontPageProduct() {

		$p = Products::FrontPage();

		$html = '<article class="image hero-unit">
			        <div class="hero-wrapper">
			          <h1>'.$p->product_name.' </h1>'.
			          '<a href="'.$p->directLink.'" class="btn btn-info btn-large">Learn More</a>
			        </div>
			    </article>';

		echo $html;
	}
	public function displayFeaturedProducts() {
		$pArray  = Products::Featured();

	

		$html = '';
		foreach ($pArray as $p) {
			if ($p->access <= $this->user->access)

			$html .= '<article class="featured-products">
						<h4>'.$p->product_name.'</h4>'
						.'<a href="'.$p->directLink.'" class="btn btn-primary">Learn More</a>
					</article>';
		}

		echo $html;
	}


}

?>