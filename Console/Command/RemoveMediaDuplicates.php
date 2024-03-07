<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Console\Command;

use Elevinskii\MediaStorage\Model\Gallery\ImageBuilder;
use Elevinskii\MediaStorage\Model\Gallery\OriginFinder;
use Elevinskii\MediaStorage\Model\GalleryImage as Image;
use Elevinskii\MediaStorage\Model\ResourceModel\GalleryImage as ImageResource;
use Elevinskii\MediaStorage\Model\ResourceModel\GalleryImage\CollectionFactory as ImageCollectionFactory;
use Magento\Framework\Console\Cli;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveMediaDuplicates extends Command
{
    /**
     * List of available options
     */
    private const OPTION_DRY_RUN = 'dry-run';

    /**
     * @param OriginFinder $originFinder
     * @param ImageBuilder $imageBuilder
     * @param ImageResource $imageResource
     * @param LoggerInterface $logger
     * @param ImageCollectionFactory $imageCollectionFactory
     */
    public function __construct(
        private readonly OriginFinder $originFinder,
        private readonly ImageBuilder $imageBuilder,
        private readonly ImageResource $imageResource,
        private readonly LoggerInterface $logger,
        private readonly ImageCollectionFactory $imageCollectionFactory
    ) {
        parent::__construct();
    }

    /**
     * Configuration of the command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('catalog:images:remove-duplicates')
            ->setDescription('Searches for media duplicates in database and removes them');

        $this->addOption(
            self::OPTION_DRY_RUN,
            null,
            InputOption::VALUE_NONE,
            'Performs dry running without any operations with database'
        );

        parent::configure();
    }

    /**
     * Remove duplicates action
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $imageCollection = $this->imageCollectionFactory->create()
            ->addFilterByDuplicates();

        $removedImages = [];
        $totalSize = 0;

        /** @var Image $image */
        foreach ($imageCollection as $image) {
            try {
                $duplicateImage = $this->imageBuilder->create($image->getValue());
                $originImage = $this->originFinder->getOriginImage($duplicateImage);

                if ($originImage) {
                    if (!$this->isDryRun($input)) {
                        $this->imageResource->save(
                            $image->setValue($originImage->getCatalogPath())
                        );
                    }

                    $removedImages[] = $duplicateImage;
                    $totalSize += $duplicateImage->getFileSize();
                }
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }

        if ($this->isDryRun($input)) {
            $output->writeln(
                '<comment>Dry mode enabled, no database operations performed</comment>'
            );
        }

        $output->writeln(
            sprintf(
                'Number of images successfully removed: %d with size of %.2f MB',
                count($removedImages),
                $totalSize / 1024 / 1024
            )
        );

        return Cli::RETURN_SUCCESS;
    }

    /**
     * If the command executes in dry run mode
     *
     * @param InputInterface $input
     * @return bool
     */
    private function isDryRun(InputInterface $input): bool
    {
        return $input->getOption(self::OPTION_DRY_RUN);
    }
}
