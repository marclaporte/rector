<?php

declare (strict_types=1);
namespace Rector\Core\NonPhpFile;

use Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\Contract\Rector\NonPhpRectorInterface;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Configuration;
use Rector\Core\ValueObject\Error\SystemError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use Rector\Parallel\ValueObject\Bridge;
use RectorPrefix202304\Symfony\Component\Filesystem\Filesystem;
final class NonPhpFileProcessor implements FileProcessorInterface
{
    /**
     * @var string[]
     */
    private const SUFFIXES = ['neon', 'yaml', 'xml', 'yml', 'twig', 'latte', 'blade.php', 'tpl'];
    /**
     * @var NonPhpRectorInterface[]
     * @readonly
     */
    private $nonPhpRectors;
    /**
     * @readonly
     * @var \Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory
     */
    private $fileDiffFactory;
    /**
     * @readonly
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @param NonPhpRectorInterface[] $nonPhpRectors
     */
    public function __construct(array $nonPhpRectors, FileDiffFactory $fileDiffFactory, Filesystem $filesystem, RemovedAndAddedFilesCollector $removedAndAddedFilesCollector)
    {
        $this->nonPhpRectors = $nonPhpRectors;
        $this->fileDiffFactory = $fileDiffFactory;
        $this->filesystem = $filesystem;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
    }
    /**
     * @return array{system_errors: SystemError[], file_diffs: FileDiff[]}
     */
    public function process(File $file, Configuration $configuration) : array
    {
        $systemErrorsAndFileDiffs = [Bridge::SYSTEM_ERRORS => [], Bridge::FILE_DIFFS => []];
        if ($this->nonPhpRectors === []) {
            return $systemErrorsAndFileDiffs;
        }
        $oldFileContent = $file->getFileContent();
        $newFileContent = $file->getFileContent();
        foreach ($this->nonPhpRectors as $nonPhpRector) {
            $newFileContent = $nonPhpRector->refactorFileContent($file->getFileContent());
            if ($oldFileContent === $newFileContent) {
                continue;
            }
            $file->changeFileContent($newFileContent);
        }
        if ($oldFileContent !== $newFileContent) {
            $fileDiff = $this->fileDiffFactory->createFileDiff($file, $oldFileContent, $newFileContent);
            $systemErrorsAndFileDiffs[Bridge::FILE_DIFFS][] = $fileDiff;
            $this->printFile($file, $configuration);
        }
        return $systemErrorsAndFileDiffs;
    }
    public function supports(File $file, Configuration $configuration) : bool
    {
        // early assign to variable for increase performance
        // @see https://3v4l.org/FM3vY#focus=8.0.7 vs https://3v4l.org/JZW7b#focus=8.0.7
        $filePath = $file->getFilePath();
        // bug in path extension
        foreach ($this->getSupportedFileExtensions() as $fileExtension) {
            if (\substr_compare($filePath, '.' . $fileExtension, -\strlen('.' . $fileExtension)) === 0) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return self::SUFFIXES;
    }
    private function printFile(File $file, Configuration $configuration) : void
    {
        $filePath = $file->getFilePath();
        if ($this->removedAndAddedFilesCollector->isFileRemoved($filePath)) {
            // skip, because this file exists no more
            return;
        }
        if ($configuration->isDryRun()) {
            return;
        }
        $this->filesystem->dumpFile($filePath, $file->getFileContent());
    }
}
