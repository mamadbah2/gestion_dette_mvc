<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Debt;
use App\Entity\DebtRequest;
use App\Entity\DetailDebt;
use App\Entity\DetailDebtRequest;
use App\Entity\Payment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use FakerRestaurant\Provider\fr_FR\Restaurant;
use Proxies\__CG__\App\Entity\Client;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $faker->addProvider(new Restaurant($faker));

        $articleArray = [];
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setLibelle($faker->fruitName());
            $article->setPrix(random_int(500, 10000));
            $article->setQteStock(random_int(10, 100));
            $articleArray[] = $article;
            $manager->persist($article);
        }

        $debtArray = [];
        $clientArray = [];
        $debtRequestArray = [];
        $roleArray = ['ROLE_ADMIN', 'ROLE_BOUTIQUIER', 'ROLE_CLIENT'];
        for ($i = 0; $i < 10; $i++) {
            $client = (new Client())
                ->setSurname($faker->lastName())
                ->setAdresse($faker->address())
                ->setTelephone($faker->phoneNumber())
            ;
            if ($i < 4) {
                $user = (new User())
                    ->setEmail($faker->email())
                    ->setLogin($faker->userName())
                    ->setActive($faker->boolean())
                    ->setClient($client)
                    ->setRoles([$roleArray[random_int(0, 2)]])
                ;
                $user->setPassword($this->encoder->hashPassword($user, $faker->password()));
                $client->setUserAccount($user);

                $debt = new Debt();
                $debt->setDate($faker->dateTimeBetween('-1 year', 'now'));
                $debt->setMount(random_int(1000, 10000));
                $debt->setPaidMount(random_int(0, 1000));
                $debt->setRemainingMount($debt->getMount() - $debt->getPaidMount());
                $debt->setAchieved($debt->getRemainingMount() === 0);
                $debt->setClient($client);
                $debtArray[] = $debt;

                $debtRequest = new DebtRequest();
                $debtRequest->setDate($faker->dateTimeBetween('-1 year', 'now'));
                $debtRequest->setClient($client);
                $debtRequest->setTotalAmount(random_int(1000, 10000));
                $debtRequestArray[] = $debtRequest;


                $manager->persist($debtRequest);
                $manager->persist($user);
                $manager->persist($debt);
            }


            $detailDebt = new DetailDebt();
            $detailDebt->setArticle($articleArray[random_int(0, 9)]);
            $detailDebt->setQuantity(random_int(1, 10));
            $detailDebt->setDebt($debtArray[random_int(0, $i >= 4 ? 3 : $i)]);
            $detailDebt->setPrix($detailDebt->getArticle()->getPrix() * $detailDebt->getQuantity());

            $detailDebtRequest = new DetailDebtRequest();
            $detailDebtRequest->setArticle($articleArray[random_int(0, 9)]);
            $detailDebtRequest->setQuantity(random_int(1, 10));
            $detailDebtRequest->setDebtRequest($debtRequestArray[random_int(0, $i >= 4 ? 3 : $i)]);
            $detailDebtRequest->setPrix($detailDebtRequest->getArticle()->getPrix() * $detailDebtRequest->getQuantity());

            $payment = new Payment();
            $payment->setAmount(random_int(100, 1000));
            $payment->setDate($faker->dateTimeBetween('-1 year', 'now'));
            $payment->setDebt($debtArray[random_int(0, $i >= 4 ? 3 : $i)]);
            
            $clientArray[] = $client;

            $manager->persist($payment);
            $manager->persist($detailDebtRequest);
            $manager->persist($detailDebt);
            $manager->persist($client);
        }




        $myUser = (new User())
            ->setEmail('admin@localhost')
            ->setLogin('admin')
            ->setActive(true);
        $myUser->setRoles(['ROLE_CLIENT']);
        $myUser->setClient($clientArray[random_int(5, 9)]);

        $myUser->setPassword($this->encoder->hashPassword($user, 'admin'));
        $manager->persist($myUser);
        $manager->flush();
    }
}
