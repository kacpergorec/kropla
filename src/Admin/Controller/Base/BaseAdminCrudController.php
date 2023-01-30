<?php
declare (strict_types=1);

namespace App\Admin\Controller\Base;

use App\Helper\RouteHelper;
use App\Table\Table;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class BaseAdminCrudController extends AbstractController
{
    private Request $request;
    private EntityManagerInterface $em;
    public RouterInterface $router;
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em, RouterInterface $router,  JWTTokenManagerInterface $JWTManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
        $this->router = $router;
        $this->JWTManager = $JWTManager;
    }

    public function renderCrudIndex(string $className, string $formType, Table $table): Response
    {
        $routes = RouteHelper::extractCrudRoutesFromPreviousController();

        $newEntity = new $className();

        $form = $this->createForm($formType, $newEntity);

        return $this->render('admin/crud/index.html.twig', [
            'form' => $form,
            'table' => $table,
            'routes' => $routes
        ]);
    }

    public function processCrudNew(string $className, string $formType): Response
    {
        $routes = RouteHelper::extractCrudRoutesFromPreviousController();

        $newEntity = new $className();

        $form = $this->createForm($formType, $newEntity);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (method_exists($newEntity, 'setAuthor')) {
                $newEntity->setAuthor($this->getUser());
            }

            $this->em->getRepository($className)->save($newEntity, true);

            return $this->redirectToRoute(
                $routes['index'],
                ['id' => $newEntity->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->redirect($this->request->headers->get('referer'));
    }

    public function renderCrudDetails($entity, Table $table): Response
    {
        $routes = RouteHelper::extractCrudRoutesFromPreviousController();

        return $this->render('admin/crud/details.html.twig', [
            'table' => $table,
            'entity' => $entity,
            'routes' => $routes
        ]);
    }


    public function renderCrudEdit($entity, string $formType): Response
    {
        $routes = RouteHelper::extractCrudRoutesFromPreviousController();

        $form = $this->createForm($formType, $entity);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->getRepository($entity::class)->save($entity, true);

            return $this->redirectToRoute($routes['edit'], ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }

        $token = $this->JWTManager->create($this->getUser());

        return $this->render('admin/crud/edit.html.twig', [
            'entity' => $entity,
            'form' => $form,
            'routes' => $routes,
            'token' => $token,
        ]);
    }

    public function processCrudDelete($entity): Response
    {
        $routes = RouteHelper::extractCrudRoutesFromPreviousController();

        if ($this->isCsrfTokenValid('delete' . $entity->getId(), $this->request->request->get('_token'))) {
            $this->em->getRepository($entity::class)->remove($entity, true);
        }

        return $this->redirectToRoute($routes['index'], [], Response::HTTP_SEE_OTHER);
    }

}
