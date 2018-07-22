<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function __construct()
    {
        // load the kernel here?
    }

    public function load(ObjectManager $manager)
    {

        for ($i=0; $i<10; $i++) {
            $photo = new Photo();
            $photo->setFilename("file" . $i . '.jpg')
                ->setTitle("Photo $i")
                ->setDescription("Description of photo $i");
            $manager->persist($photo);
        }

        for ($i=0; $i<4; $i++) {
            $location = new Location();
            $location->setAddress("$i Main Street")
                ->setCity("Sperryville")
                ->setPhoto($photo); // hack, last photo on list!
            $manager->persist($location);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
