<?php
namespace Codexproject\Core\Repositories;

use App;
use DateTime;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Codexproject\Core\Markdown;

abstract class AbstractCodexRepository implements CodexRepositoryInterface
{
	/**
	 * The config implementation.
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * The filesystem implementation.
	 *
	 * @var Filesystem
	 */
	protected $files;

	/**
	 * Storage path.
	 *
	 * @var string
	 */
	protected $storagePath;

	/**
	 * Create a new AbstractCodexRepository instance.
	 *
	 * @param  Config     $config
	 * @param  Filesystem $files
	 * @return void
	 */
	public function __construct(Config $config, Filesystem $files)
	{
		$this->config = $config;
		$this->files  = $files;

		$this->storagePath = $this->config->get('codex::storage_path');
	}

	/**
	 * Get the default manual.
	 *
	 * @return mixed
	 */
	public function getDefaultManual()
	{
		$manuals = $this->getManuals();

		if (count($manuals) > 1) {
			if ($this->config->get('codex::default_manual') != '') {
				return $this->config->get('codex::default_manual');
			} else {
				return strval($manuals[0]);
			}
		} elseif (count($manuals) === 1) {
			return strval($manuals[0]);
		}

		return null;
	}

	/**
	 * Get the default version for the given manual.
	 *
	 * @param  string $manual
	 * @return string
	 */
	public function getDefaultVersion($manual)
	{
		$versions = $this->getVersions($manual);

		return $versions[0];
	}

	/**
	 * Get all manuals from documentation directory.
	 *
	 * @return array
	 */
	public function getManuals()
	{
		$manuals = $this->getDirectories($this->storagePath);
		
		sort($manuals);

		return $manuals;
	}

	/**
	 * Get all versions for the given manual.
	 *
	 * @param  string $manual
	 * @return array
	 */
	public function getVersions($manual)
	{
		$alpha     = array();
		$numeric   = array();
		$manualDir = $this->storagePath.'/'.$manual;
		$versions  = $this->getDirectories($manualDir);

		foreach ($versions as $version) {
			if (ctype_alpha(substr($version, 0, 2))) {
				$alpha[] = $version;
			} else {
				$numeric[] = $version;
			}
		}

		sort($alpha);
		rsort($numeric);

		switch ($this->config->get('codex::version_ordering')) {
			case 'numeric-first':
				$versions = array_merge($numeric, $alpha);
			break;
			case 'alpha-first':
				$versions = array_merge($alpha, $numeric);
			break;
		}

		return $versions;
	}

	/**
	 * Return an array of folders within the supplied path.
	 *
	 * @param  string $path
	 * @return array
	 */
	public function getDirectories($path)
	{
		if ($this->files->exists($path) === false) {
			App::abort(404);
		}

		$directories = $this->files->directories($path);
		$folders     = [];

		if (count($directories) > 0) {
			foreach ($directories as $dir) {
				$dir       = str_replace('\\', '/', $dir);
				$folder    = explode('/', $dir);
				$folders[] = end($folder);
			}
		}

		return $folders;
	}

	/**
	 * Return the first line of the supplied page. This will (or rather should)
	 * always be an <h1> tag.
	 *
	 * @param  string $page
	 * @return string
	 */
	protected function getPageTitle($page)
	{
		$meta = Markdown::parseMeta($this->files->get($page));

		if (isset($meta) and isset($meta['title'])) {
			return "# {$meta['title']}";
		} else {
			$file  = fopen($page, 'r');
			$title = fgets($file);

			fclose($file);

			return $title;
		}			
	}

	/**
	 * Gets the given documentation page modification time.
	 *
	 * @param  string $manual
	 * @param  string $version
	 * @param  string $page
	 * @return mixed
	 */
	public function getUpdatedTimestamp($manual, $version, $page)
	{
		$page = $this->storagePath.'/'.$manual.'/'.$version.'/'.$page.'.md';

		if ($this->files->exists($page)) {
			$timestamp = DateTime::createFromFormat('U', filemtime($page));

			return $timestamp->format($this->config->get('codex::modified_timestamp'));
		}

		return false;
	}
}
