<?php

class gCalendar {

	//vars
	public $calendarFeed = 'https://www.google.com/calendar/feeds/renalnutritionorg%40gmail.com/public/basic';
	private $calendarXML;
	private $xml;

	private $dateFormat = "F j Y";
	private $timeFormat = 'g.ia';
	private $timeZone;

	private $groupByDate = true;
	private $items_to_show;
	private $items_shown;
	private $old_date;
	private $use_cache = true;
	private $cacheFile;


	private $debugMode = false;

	public $display;
	public $dateHeader;

	public $events = array();


	public function __construct($items) {
		$this->items_to_show = $items;

		$this->cacheFile = CACHE_PATH.'gCal.xml';

		$this->formatXML();
		$this->grabFeed();
	}

	//Format the XML to get future events
	private function formatXML() {
		$this->calendarXML = str_replace("/basic","/full?singleevents=true&futureevents=true&max-results".$this->items_to_show."&orderby=starttime&sortorder=a",$this->calendarFeed);
	}

	private function grabFeed() {
		if ($this->use_cache) {
			//Get Cached File
			$cache_time = 3600*12; //12 Hours
			$timedif = @(time() - filemtime($cache_file));

			$this->xml  = '';
			if (file_exists($this->cacheFile) && $timedif < $cache_time) {
				if ($debugMode) echo '<p class="alert">Using Cache</p>';
				$str = file_get_contents($this->cacheFile);
				$xml = simplexml_load_string($str);
			} else {
				if ($this->debugMode) echo '<p class="alert">No valid Cache Copies Found.</p>';
				$this->loadXMLFromGoogle();
				$this->cacheXML();
			}

		} else {
			$this->loadXMLFromGoogle();
		}

		if ($this->debugMode) {
			if (!empty($this->xml)) {
				echo '<p class="alert">XML Feed was retrieved</p>';
			} else {
				echo '<p class="alert">XML Feed Not Found</p>';
			}
		}
	}

	public function displayEvents() {
		$this->parseXML();
	}

	private function loadXMLFromGoogle() {
		$this->xml = simplexml_load_file($this->calendarXML);
	}

	private function cacheXML() {
		if ($f = fopen($this->cacheFile, 'w')) {
			$str = $this->xml->asXML();
			fwrite ($f, $str, strlen($str));
			fclose($f);
			if ($this->debugMode) echo '<p class="alert">Cache Saved</p>';
		} else {
			if ($this->debugMode) echo '<p class="alert">Could not write to cache.</p>';
		}
	}

	private function parseXML() {
		foreach ($this->xml->entry as $entry){
			$gEvent = new gEvent();

		    $ns_gd = $entry->children('http://schemas.google.com/g/2005');

		    //Do some niceness to the description
		    //Make any URLs used in the description clickable
		    $description = preg_replace('"\b(http://\S+)"', '<a href="$1">$1</a>', $entry->content);

		    // Make email addresses in the description clickable
		    $description = preg_replace("`([-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]{2,6})`i","<a href=\"mailto:\\1\" title=\"mailto:\\1\">\\1</a>", $description);

		    if ($this->debugMode) { echo "<P>Here's the next item's start time... GCal says ".$ns_gd->when->attributes()->startTime." PHP says ".date("g.ia  -Z",strtotime($ns_gd->when->attributes()->startTime))."</p>"; }

		    // These are the dates we'll display
		    $gEvent->date = date($this->dateFormat, strtotime($ns_gd->when->attributes()->startTime));
		    $gEvent->startDate = date($this->dateFormat, strtotime($ns_gd->when->attributes()->startTime));
		    $gEvent->endDate = date($this->dateFormat, strtotime($ns_gd->when->attributes()->endTime));
		    $gEvent->startTime = date($this->timeFormat, strtotime($ns_gd->when->attributes()->startTime));
		    $gEvent->endTime = date($this->timeFormat, strtotime($ns_gd->when->attributes()->endTime));

		    // Now, let's run it through some str_replaces, and store it with the date for easy sorting later
		    $gEvent->title = $entry->title;
		    $gEvent->description = $description;

		    $gEvent->location = $ns_gd->where->attributes()->valueString;
		    $gEvent->link  = $entry->link->attributes()->href;
		    $gEvent->mapLink = "http://maps.google.com/?q=".urlencode($ns_gd->where->attributes()->valueString);

		    if ($gEvent->startDate != $gEvent->endDate) {
		    	$gEvent->dateRange  = date('F j', strtotime($gEvent->startDate)) . ' - '. date('j Y', strtotime($gEvent->endDate));
		   	}

			if (($this->items_to_show > 0 AND $this->items_shown < $this->items_to_show)) {
		         if ($this->groupByDate) {
		         	if ($gEvent->date != $this->old_date) $this->old_date = $gEvent->date;
		         }
		        $this->events[] = $gEvent;
		        $this->items_shown++;
		    } else {
		    	return;
		    }
		}
	}


	/* Debug Methods */

	public function debugFeed() {
		if ($this->debugMode) {
			echo '<p class="alert alert-error">We\'re going to go and grab <a href='.$this->calendarXML.'>this feed</a>.<P>';
		}
	}

	public function cacheFile() {
		if ($this->debugMode) {
			echo '<p class="alert">Your Cache file is saved '.$this->cacheFile .'</p>';
		}
	}

}


?>