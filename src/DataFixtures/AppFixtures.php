<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Section;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Cocur\Slugify\Slugify;
use App\Entity\Article;
use App\Entity\Comment;



class AppFixtures extends Fixture
{
    // Attribut privé contenant le hacheur de mot de passe
    private UserPasswordHasherInterface $hasher;

    // création d'un constructeur pour récupérer le hacher
    // de mots de passe
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->hasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        ###
        #
        # INSERTION de l'admin avec mot de passe admin
        #
        ###
        // création d'une instance de User
        $user = new User();

        // création de l'administrateur via les setters
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@admin.com');
        $user->setFullname("Administrateur");
        $user->setActivate(true);
        $user->setUniqid(uniqid('user_', true));
        // on va hacher le mot de passe
        $pwdHash = $this->hasher->hashPassword($user, 'admin');
        // passage du mot de passe crypté
        $user->setPassword($pwdHash);

        // on va mettre dans une variable de type tableau
        // tous nos utilisateurs pour pouvoir leurs attribués
        // des Post ou des Comment
        $users[] = $user;

        // on prépare notre requête pour la transaction
        $manager->persist($user);

        ###
        #
        # INSERTION de 10 utilisateurs en ROLE_USER
        # avec nom et mots de passe "re-tenables"
        #
        ###
        for($i=1;$i<=24;$i++){
            $user = new User();
            // username de : user0 à user10
            $user->setUsername('user'.$i);
            $user->setRoles(['ROLE_USER']);
            $user->setEmail($faker->email());
            $user->setFullname($faker->name());
            $user->setActivate(true);
            $user->setUniqid(uniqid('user_', true));
            // hashage du mot de passe
            $pwdHash = $this->hasher->hashPassword($user, 'user'.$i);
            $user->setPassword($pwdHash);
            // on récupère les utilisateurs pour
            // les post et les comments
            $users[]=$user;
            $manager->persist($user);
        }
        ###
        #
        # INSERTION de 6 redacteurs 
        #
        ###

        for($i=1;$i<=6;$i++){
            $redac = new User();
            $redac->setUsername('redac'.$i)
                ->setRoles(['ROLE_REDAC'])
                ->setUniqid($faker->unique()->uuid())
                ->setEmail("redac{$i}@example.com")
                ->setFullname($faker->name())
                ->setActivate(true);
                $redac->setUniqid(uniqid('redac_', true));

                $pwdHash = $this->hasher->hashPassword($redac, 'redac'.$i);
            $redac->setPassword($pwdHash);
            $manager->persist($redac);
            $redacteurs[] = $redac;
        }
        ###
        #   
        # INSERTION d'Articles avec leurs users
        #
        ###

        
        $articles = [];  // Inicializar el array antes de usarlo

for($i=1;$i<=160;$i++){
    $article = new Article();
    $keyUser = array_rand($users);
    $article->setAuthor($users[$keyUser]);
    $title = $faker->sentence(mt_rand(3, 8));
    $article->setTitle($title);
    $article->setTitleSlug($slugify->slugify($title));
    $article->setText($faker->paragraphs(mt_rand(3, 7), true));
    $article->setArticleDateCreate(new \DateTime());
    
    // Hacer que aproximadamente el 80% de los artículos estén publicados
    $article->setPublished($faker->boolean(80)); // 80% de probabilidad de true
    
    $articles[]=$article;
    $manager->persist($article);        
}
        ###
        #   SECTION
        # INSERTION de Section en les liants
        # avec des postes au hasard
        #
        ###

        for($i=1;$i<=6;$i++){
            $section = new Section();
            // création d'un titre entre 2 et 5 mots
            $title = $faker->words(mt_rand(2,5),true);
            // titre
            $section->setSectionTitle(ucfirst($title));
            // on slugifie le titre
            $section->setSectionSlug($slugify->slugify($title));
            // création d'une description de maximum 500 caractères
            // en pseudo français du fr_FR
            $description = $faker->realText(mt_rand(150,500));
            $section->setSectionDetail($description);

            // On va mettre dans une variable le nombre total d'articles
            $nbArticles = count($articles);
            // on récupère un tableau d'id au hasard
            $articleID = array_rand($articles, mt_rand(1,$nbArticles));

            
            // Si solo hay un artículo, array_rand devuelve un integer en lugar de un array
            if (!is_array($articleID)) {
                $articleID = [$articleID];
            }


            // Attribution des articles
            // à la section en cours
            foreach($articleID as $id){
                // entre 1 et 100 articles
                $section->addArticle($articles[$id]);
                $manager->persist($section);
            }    
        }
        
        // validation de la transaction
        $manager->flush();
    
    }


}
