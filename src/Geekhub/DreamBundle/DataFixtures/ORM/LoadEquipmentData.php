<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Equipment;

class LoadEquipmentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $equipmentItem = $this->getEquipmentList();

        for ($i = 0; $i < 100; $i++) {
            $equipment = new Equipment();
            $equipment->setName($equipmentItem[rand(1, 30)]);
            $equipment->setQuantity(rand(1, 25));

            $manager->persist($equipment);
            $manager->flush();

            $this->setReference('equipment'.$i, $equipment);
        }
    }

    function getEquipmentList()
    {
        $i = 1;
        $equipmentFile = fopen(__DIR__ . "/equipment", "r");
        while (!feof($equipmentFile)) {
            $equipment = fgets($equipmentFile);
            $list[$i] = $equipment;
            $i++;
        }
        fclose($equipmentFile);

        return $list;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 24;
    }


}