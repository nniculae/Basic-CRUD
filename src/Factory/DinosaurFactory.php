<?php
/**
 * Created by PhpStorm.
 * User: nicu
 * Date: 18-12-2018
 * Time: 13:07
 */

namespace App\Factory;


use App\Util\Dinosaur;

class DinosaurFactory
{


    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification):Dinosaur
    {
        // defaults
        $codeName = 'InG-' . random_int(1, 99999);
        $length = random_int(1, Dinosaur::LARGE -1);
        $isCarnivorous = false;

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;

        }
        if (stripos($specification, 'large') !== false) {

            $length = random_int(Dinosaur::LARGE, 100);
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

        return $dinosaur;

    }
    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }


}