<?php

namespace App\Traits;

use App\Models\Organisation;

/**
 * Helper trait for Organisation-related utilities
 */
trait OrganisationHelpers
{
    /**
     * Get organisation category ID by name
     *
     * @param string $categoryName
     * @return int|null
     */
    public function getOrganisationCategory(string $categoryName): ?int
    {
        $categories = [
            'Ministry'   => 1,
            'Department' => 2,
            'Segment'    => 3,
            'Unit'       => 4,
            'Sub Unit'   => 5,
        ];

        return $categories[$categoryName] ?? null;
    }

    /**
     * Get all organisations of certain categories without spaces
     *
     * @param array $categories
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrganisationsWithoutSpace(array $categories)
    {
        $categoryIds = array_map(fn($name) => $this->getOrganisationCategory($name), $categories);

        return Organisation::whereIn('category', $categoryIds)
                           ->where('status', 1)
                           ->whereNotIn('id', function ($query) {
                               $query->select('organisation_id')
                                     ->from('spaces');
                           })
                           ->get();
    }

    /**
     * Shortcut to get only Ministry and Department without spaces
     */
    public function getMinistryAndDepartmentWithoutSpace()
    {
        return $this->getOrganisationsWithoutSpace(['Ministry', 'Department']);
    }
    // Role Helper Methods
    // ---------------------------

    public function userContentCreator(): int
    {
        return 2;
    }

    public function userPkpRoleId(): int
    {
        return 3;
    }

    public function userSPARKOfficer(): int
    {
        return 5;
    }

    public function userSuperAdmin(): int
    {
        return 1;
    }

    public function userAdmin(): int
    {
        return 2;
    }

    public function userKetuaBahagian(): int
    {
        return 3;
    }

    public function userSPARK(): int
    {
        return 4;
    }

    public function userInternalContentCreator(): int
    {
        return 5;
    }

    public function userExternalContentCreator(): int
    {
        return 6;
    }

    public function userInternalPKPAgent(): int
    {
        return 7;
    }

    public function userExternalPKPAgent(): int
    {
        return 8;
    }
}
