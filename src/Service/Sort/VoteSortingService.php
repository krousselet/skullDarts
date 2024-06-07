<?php

namespace App\Service\Sort;
class VoteSortingService
{
    public function sortVotes(array $votes): array
    {
        usort($votes, function($a, $b) {
            if ($a->getVote() == 'oui' && $b->getVote() != 'oui') {
                return -1;
            } elseif ($a->getVote() != 'oui' && $b->getVote() == 'oui') {
                return 1;
            }
            return 0;
        });

        return $votes;
    }
}