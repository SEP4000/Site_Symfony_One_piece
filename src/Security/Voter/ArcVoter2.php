<?php

namespace App\Security\Voter;

use App\Entity\Personnage;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface as TokenTokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ArcVoter2 extends Voter
{
    const EDIT = 'PERSONNAGE_EDIT';
    const DELETE = 'PERSONNAGE_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $personnage): bool
    {
        if(!in_array($attribute, [self::EDIT, self::DELETE])) 
        {
            return false;
        }
        if(!$personnage instanceof Personnage) 
        {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute($attribute, $personnage, TokenTokenInterface $token): bool
    {
        $user = $token->getUser();

        if(!$user instanceof UserInterface)
        {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN'))
        {
            return true;
        }

        switch($attribute)
        {
            case self::EDIT:
                return $this->canEdit();
                break;
            case self::DELETE:
                return $this->canDelete();
                break;
        }
        return false;
    }

    private function canEdit()
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    private function canDelete()
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }
}
   