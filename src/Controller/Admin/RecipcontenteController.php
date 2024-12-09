<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/admin/recettes", name: 'admin.recipe.')]


class RecipcontenteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index( Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    {
      $recipes = $repository -> findAll();
      return $this -> render('recipcontente/index.html.twig', [
        'recipes' => $recipes
      ]);
    }



    #[Route('/{id}', name: 'edit')]
    public function edit(Recipe $recipe, Request $request)
    {
     $form = $this -> createForm(RecipeType:: class, $recipe);
     $form ->handleRequest($request);
     return $this -> render('recipcontente/edit.html.twig', [
      'recipe'=>$recipe,
      'form' => $form
     ]);
      
    }
}

