<?php
namespace SwaggerFromRoute;
use \Symfony\Component\Filesystem\Filesystem;

class CopyFiles
{
	static public function recursive($source, $target) {
		$fileSystem = new Filesystem;

		if (!file_exists($target))
		{
			// $fileSystem->remove($target);
			$fileSystem->mkdir($target);
		}

		$directoryIterator = new \RecursiveDirectoryIterator(
			$source,
			\RecursiveDirectoryIterator::SKIP_DOTS
		);
		
		$iterator = new \RecursiveIteratorIterator(
			$directoryIterator,
			\RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $item)
		{
			if ($item->isDir()) {
				$fileSystem->mkdir($target . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
				continue;
			}
			
			$fileSystem->copy($item, $target . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
		}
	}
}