<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'parola-nicu'));
        $user->setEmail('niculae@zeelandnet.nl');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);


        $user2 = new User();
        $user2->setPassword($this->passwordEncoder->encodePassword($user, 'pisoi'));
        $user2->setEmail('pisi@zeelandnet.nl');
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        $manager->flush();


    }
}
