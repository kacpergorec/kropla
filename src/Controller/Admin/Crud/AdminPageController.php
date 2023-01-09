<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Page;
use App\Form\PageType;
use App\Form\NewPageType;
use App\Repository\PageRepository;
use App\Table\Option\TableOption;
use App\Table\TableGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class AdminPageController extends AbstractController implements CrudControllerInterface
{

    public static function getPluralName(): string
    {
        return 'Strony';
    }

    #[Route('/', name: 'admin_page_index', methods: ['GET'])]
    public function index(Request $request, PageRepository $pageRepository, TableGenerator $tableGenerator): Response
    {
        $newPage = new Page();
        $form = $this->createForm(NewPageType::class, $newPage, ['action' => $this->generateUrl('admin_page_new')]);

        return $this->render('admin/page/index.html.twig', [
            'newPage' => $form,
            'table' => $tableGenerator
                ->addEntities($pageRepository->findAll(), ['id', 'title', 'category', 'author', 'createdAt', 'published', 'promoted'])
                ->addOptionsColumn([TableOption::DETAILS, TableOption::EDIT, TableOption::DELETE])
                ->sortBy('createdAt','DESC')
//                ->addIncrementalColumn()
                ->build(),
        ]);
    }

    #[Route('/new', name: 'admin_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PageRepository $pageRepository): Response
    {
        $page = new Page();
        $form = $this->createForm(NewPageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pageRepository->save($page, true);

            return $this->redirectToRoute('admin_page_edit', ['id' => $page->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/details', name: 'admin_page_details', methods: ['GET'])]
    public function details(Page $page, TableGenerator $tableGenerator): Response
    {
        return $this->render('admin/page/details.html.twig', [
            'table' => $tableGenerator
                ->addEntities([$page])
                ->setVertical()
                ->build(),
            'page' => $page
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRepository->save($page, true);

            return $this->redirectToRoute('admin_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_page_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $page->getId(), $request->request->get('_token'))) {
            $pageRepository->remove($page, true);
        }

        return $this->redirectToRoute('admin_page_index', [], Response::HTTP_SEE_OTHER);
    }

}
