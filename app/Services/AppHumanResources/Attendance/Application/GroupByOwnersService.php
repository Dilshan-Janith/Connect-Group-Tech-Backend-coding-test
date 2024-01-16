<?php

namespace App\Services\AppHumanResources\Attendance\Application;

class GroupByOwnersService {

    public function groupByOwners() {

        $original_array = ['insurance.txt' => 'Company A', 'letter.docx' => 'Company A', 'Contract.docx' => 'Company B'];

        $grouped_array = [];

        foreach ($original_array as $key => $element) {

            if (!count($grouped_array)) {

                $grouped_array[$element] = [$key];

            } else {

                if (isset($grouped_array[$element])) {

                    array_push($grouped_array[$element], $key);

                } else {

                    $grouped_array[$element] = [$key];
                }
            }
        }

        return $grouped_array;
    }
}
