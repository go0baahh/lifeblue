<?php

class Webpage {

	/*
	 * String
	 * Absolute path.
	 */
	private $myUrl;


	/*
	 * Returns boolean.
	 * $requestedUrl: String. Absolute path.
	 *
	 * $myUrl value                         $requestedUrl value                 return value
	 * "/section/index.html"                "/section/page.html"                true
	 * "/section/page.html"                 "/section/other-page.html"          false
	 * "/section/index.html"                "/section/subsection/index.html"    true
	 * "/section/index.html"                "/section/subsection/page.html"     true
	 * "/section/subsection/index.html"     "/section/other/index.html"         false
	 *
	 * Assume landing pages are index files.
	 *
	 * Discovery questions:
	 *  Do all conditions need to be true at the same time or mutually exclusive?
	 *  Does the code need to specifically determine the cause of a true statement? In other words,
	 *  do we care to know which of the 3 triggered the true statement?
	 *
	 */
	public function showHighlight ($requestedUrl): bool {

		// 1. Return true if $requestedUrl === $myUrl
		if ($requestedUrl === $this->myUrl)
			return true;

		// 2. Return true if $requestedUrl is located in the same section as $myUrl only if $myUrl is a landing page.
		// 3. Return true if $myUrl is the landing page of a parent section to $requestedUrl.
		return ((strpos(dirname($requestedUrl), $this->myUrl) !== false) && (basename($this->myUrl) === "index.html"));

	}

}
