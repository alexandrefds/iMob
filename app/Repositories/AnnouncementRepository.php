<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\Repositories\BaseRepositoryInterface;
use App\Interfaces\Repositories\AnnouncementRepositoryInterface as RepositoriesAnnouncementRepositoryInterface;
use App\Models\Announcement;

class AnnouncementRepository extends BaseRepositoryInterface implements RepositoriesAnnouncementRepositoryInterface
{
    public function __construct(readonly Announcement $announcement)
    {
    }
}
