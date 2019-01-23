<?php
namespace App\Service;
use App\Entity\Note;

/**
 * GradeManager class
 */
class NoteManager
{
    public function getAverage(array $grades)
    {
        $sum = 0.0;
        $divisor = 0;

        foreach ($grades as $grade)
        {
            $sum += $grade->getNote();
            $divisor += 1;
        }

        if ($divisor == 0)
            return 0;

        return $sum / $divisor;
    }
}