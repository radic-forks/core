<?php
namespace Codexproject\Core;

use Parsedown;

class Markdown
{
	/**
	 * Convert text from Markdown to HTML.
	 *
	 * @param  string $text
	 * @param string  $pathPrefix
	 * @return string
	 */
	public static function parse($text, $pathPrefix = '')
	{
		$parsed   = self::removeMeta($text);
		$basePath = url('/' . ltrim($pathPrefix, '/'));
		$rendered = (new Parsedown)->text($parsed);

		// Replace absolute relative paths (paths that start with / but not //)
		$rendered = preg_replace('/href=\"(\/[^\/].+?).md(#?.*?)\"/', "href=\"$basePath$1$2\"", $rendered);

		// Replace relative paths (paths that don't start with / or http://, https://, //, etc)
		$rendered = preg_replace('/href=\"(?!.*?\/\/)(.+?).md(#?.*?)\"/', "href=\"$basePath/$1$2\"", $rendered);

		return $rendered;
	}

	public static function removeMeta($content)
	{
		$regexDocblockWhole = "/(?s)(\/\*(?:(?!\*\/).)+\*\/)/";

		return preg_replace($regexDocblockWhole, '', $content);
	}

	/**
	 * Extracts and parses metadata from the document.
	 *
	 */
	public static function parseMeta($content, $extract = false)
	{
		$regexDocblockWhole = "/(?s)(\/\*(?:(?!\*\/).)+\*\/)/";
		$regexDocblockMeta  = "/(\w+):\s+(.*)\r?\n/m";

		preg_match_all($regexDocblockWhole, $content, $metadata);

		$metadata = implode(' ', $metadata[1]);

		if (preg_match_all($regexDocblockMeta, $metadata, $matches)) {
			$meta = array_combine($matches[1], $matches[2]);
		}

		if (isset($meta)) {
			return array_change_key_case($meta, CASE_LOWER);
		}

		return null;		
	}
}
