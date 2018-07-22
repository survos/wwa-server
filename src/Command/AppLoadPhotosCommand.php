<?php

namespace App\Command;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class AppLoadPhotosCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:load-photos';

    private $em;

    public function __construct($name = null, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $repo = $this->em->getRepository(Photo::class);


        $finder = new Finder();
        $c = 0;
        /** @var SplFileInfo $file */
        foreach ($finder->files()->in($this->getContainer()->get('kernel')->getProjectDir() . '/public/images') as $file) {
            $c++;
            $filename = $file->getBasename();
            if (!$photo = $repo->findOneBy(['filename' => $filename])) {
                $photo = (new Photo())
                    ->setFilename($filename);
                $this->em->persist($photo);
            }

            $exifData = exif_read_data( $file->getPathname() );

            $photo
                ->setTitle("Photo " . $file->getBasename('jpg'))
                ->setDescription("Description of photo ");


        }

        $this->em->flush();


        $io->success(sprintf('%s photos loaded', $c));
    }
}
