<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:50
 */

namespace App\Security;

use App\Entity\Account;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountVoter extends Voter
{
    const HAS_ACCOUNT = 'hasAccount';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::HAS_ACCOUNT])) {

            return false;
        }

        if (!$subject instanceof Account) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        /** @var Account */


        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::HAS_ACCOUNT:
                foreach ($user->getAccounts() as $account){
                    if($account === $subject){
                        $user->setCurrentAccount($account);
                        return true;
                    }
                }
                break;
        }

        return false;
    }
}