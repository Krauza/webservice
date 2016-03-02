<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\IncorrectPrivileges;
use Fiche\Application\Infrastructure\Pdo\Repository\Fiches;
use Fiche\Application\Infrastructure\Pdo\Repository\UserGroups;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Application\Infrastructure\Pdo\Repository\Group as GroupRepository;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\Exceptions\DataNotValid;
use Fiche\Domain\ValueObject\GroupName;

/**
 * Class GroupsController
 * @package Fiche\Application\Controllers
 */
class GroupsController extends Controller
{
    public function index()
    {
        $userGroups = $this->currentUser->getUserGroups();

        return ['userGroups' => $userGroups];
    }

    public function show($id)
    {
        $userGroupsRepository = new UserGroups($this->storage);
        $groupRepository = new GroupRepository($this->storage);

        $userGroup = $userGroupsRepository->getByGroupForUser(
            $groupRepository->getById($id),
            $this->currentUser
        );

        return ['userGroup' => $userGroup];
    }

    public function create()
    {
        $result = [];

        if ($this->request->isMethod('POST')) {
            $result = $this->save();
        }

        return $result;
    }

    public function edit($id)
    {
        $groupRepository = new GroupRepository($this->storage);
        $group = $groupRepository->getById($id);

        if(!$group->isOwner($this->currentUser)) {
            throw new IncorrectPrivileges;
        }

        $result = [
            'group' => $group
        ];

        if ($this->request->isMethod('PUT')) {
            $result = $this->save($group);
        }

        return $result;
    }

    public function fiches($id)
    {
        $group = $this->storage->getById(Group::class, $this->convertIdToInt($id));
        return ['group' => $group];
    }

    private function save(Group $group = null)
    {
        $groupRepository = new GroupRepository($this->storage);

        try {
            if (empty($group)) {
                $groupName = new GroupName($this->request->get('name'));
                $group = new Group(new UniqueId(), $this->getCurrentUser(), $groupName, new Fiches($this->storage));
                $groupRepository->insert($group);
            } else {
                $group->setName(new GroupName($this->request->get('name')));
                $groupRepository->update($group);
            }
        } catch(DataNotValid $e) {
            return [
                'messages' => [
                    'field' => $e->getFieldName(),
                    'message' => $e->getMessage()
                ],
                'data' => [
                    'name' => $this->request->get('name')
                ]
            ];
        }

        return $this->app->redirect('/groups');
    }
}
