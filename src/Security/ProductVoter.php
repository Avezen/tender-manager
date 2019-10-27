<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:50
 */

namespace App\Security;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    const CREATE = 'create';
    const EDIT   = 'edit';
    const VIEW   = 'view';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::CREATE, self::EDIT, self::VIEW])) {

            return false;
        }

        if (!$subject instanceof Product) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        /** @var Product */


        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::CREATE:
                if ($this->decisionManager->decide($token, ['ROLE_SUBSTANTIVE'])) {
                    return true;
                }

                break;
            case self::EDIT:
                if (
                    $user->getCurrentAccount() === $subject->getAccount()
                    &&
                    $this->decisionManager->decide($token, ['ROLE_SUBSTANTIVE'])
                ) {
                    return true;
                }

                break;
            case self::VIEW:
                if ($user->getCurrentAccount() === $subject->getAccount()) {
                    return true;
                }

                break;
        }

        return false;
    }
}