<?php
declare (strict_types=1);

namespace App\Admin\Interface;

use App\Admin\Metadata\AdminMetadata;
use Symfony\Component\HttpFoundation\Response;

/**
 * Use this interface on the CRUD Controller when u want to add it to the admin menu.
 */
interface AdminControllerInterface
{
    /**
     * @return AdminMetadata The admin metadata, plural name in menu, icons, admin menu ordering etc.
     */
    public static function getAdminMetadata() : AdminMetadata;
}