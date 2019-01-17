<?php
/*namespace App\DataFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
class UserFixture extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstname('admin');
        $user->setLastname('admin');
        $user->setEmail('admin@gmail.com');
        $user->setPassword('$argon2i$v=19$m=1024,t=2,p=2$cHRvZGRhN3BXSE5OSDg1WQ$24pRyN4OMkyaU6TJBZmByuuFjiF4Rkh6IWmWcdSvrbQ');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
        $user = new User();
        $user->setFirstname('Killian');
        $user->setLastname('Vermersch');
        $user->setEmail('puck@gmail.com');
        $user->setPassword('$argon2i$v=19$m=1024,t=2,p=2$cHRvZGRhN3BXSE5OSDg1WQ$24pRyN4OMkyaU6TJBZmByuuFjiF4Rkh6IWmWcdSvrbQ');
        $user->setRoles(['ROLE_TEACHER']);
        $manager->persist($user);
        $manager->flush();
    }
}*/


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setEmail(sprintf('userdemo%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'userdemo'
            ));
            $manager->persist($user);
        }
        $user = new User();
        $user->setFirstname('admin');
        $user->setLastname('admin');
        $user->setEmail('admin@gmail.com');
        $user->setPassword('$argon2i$v=19$m=1024,t=2,p=2$cHRvZGRhN3BXSE5OSDg1WQ$24pRyN4OMkyaU6TJBZmByuuFjiF4Rkh6IWmWcdSvrbQ');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
