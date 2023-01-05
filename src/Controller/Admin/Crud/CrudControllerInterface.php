<?php
declare (strict_types=1);

namespace App\Controller\Admin\Crud;

use Symfony\Component\HttpFoundation\Response;

/**
 * Use this interface on the CRUD Controller when u want to add it to the admin menu.
 */
interface CrudControllerInterface
{
    /**
     * @return string The plural name of the CRUD controller used in Admin to display menu.
     */
    public static function getPluralName() : string;
}