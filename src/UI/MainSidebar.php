<?php

declare(strict_types=1);

namespace App\UI;

use App\Twig\Sidebar\AbstractSidebar;
use App\Twig\Sidebar\SidebarBuilderInterface;
use App\Twig\Sidebar\SidebarCollection;
use App\Twig\Sidebar\Type\SidebarHeader;
use App\Twig\Sidebar\Type\SidebarLink;

/**
 * class MainSidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MainSidebar extends AbstractSidebar
{
    public function build(SidebarBuilderInterface $builder): SidebarCollection
    {
        return $builder
            ->add(new SidebarHeader('Gestion'))
            ->add(new SidebarLink('admin_post_index', 'Blog', 'file-docs'))
            ->add(new SidebarLink('admin_speaker_index', 'Speakers', 'users'))
            ->add(new SidebarLink('admin_speaker_index', 'Talks', 'msg-circle'))
            ->add(new SidebarLink('admin_speaker_index', 'Événement', 'calendar'))

            ->add(new SidebarHeader('Paramètres'))
            ->add(new SidebarLink('admin_speaker_index', 'Prix', 'sign-dollar'))
            ->add(new SidebarLink('admin_speaker_index', 'Administrateur', 'users'))
            ->add(new SidebarLink('admin_speaker_index', 'Comité', 'users'))

            ->setTranslationDomain('messages')
            ->create();
    }
}
