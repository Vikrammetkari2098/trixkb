<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DispatchMail;

class GeneralHelper
{
    public static function getWikiCategories()
    {
        return [
            ['id' => 1, 'name' => 'Pengumuman'],
            ['id' => 2, 'name' => 'Infoblast'],
            ['id' => 3, 'name' => 'SME'],
            ['id' => 4, 'name' => 'Gaji & Pencen'],
            ['id' => 5, 'name' => 'Cuti Umum'],
            ['id' => 6, 'name' => 'Kedutaan/Perwakilan'],
            ['id' => 7, 'name' => 'UTC'],
            ['id' => 8, 'name' => 'MyGCC'],
            ['id' => 9, 'name' => 'Takwim Sekolah'],
            ['id' => 10, 'name' => 'Produk & Perkhidmatan'],
            ['id' => 11, 'name' => 'Aplikasi Online'],
            ['id' => 12, 'name' => 'Chatbot'],
        ];
    }
    public static function userContentCreator()
    {
        return 2;
    }

    public static function userPkpRoleId()
    {
        return 3;
    }

    public static function userSPARKOfficer()
    {
        return 5;
    }

    public static function userSuperAdmin()
    {
        return 1;
    }

    public static function userAdmin()
    {
        return 2;
    }

    public static function userKetuaBahagian()
    {
        return 3;
    }

    public static function userSPARK()
    {
        return 4;
    }

    public static function userInternalContentCreator()
    {
        return 5;
    }

    public static function userExternalContentCreator()
    {
        return 6;
    }

    public static function userInternalPKPAgent()
    {
        return 7;
    }

    public static function userExternalPKPAgent()
    {
        return 8;
    }

    public static function wikiTypeArticle()
    {
        return 'article';
    }

    public static function wikiTypeDirectory()
    {
        return 'directory';
    }

    public static function wikiTypeGeneral()
    {
        return 'general';
    }

    public static function wikiTypeTicket()
    {
        return 'ticket';
    }

    public static function articleDraftStatus($type)
    {
        if ($type == 'id') {
            return 1;
        }
        return 'Draft';
    }

    public static function articlePublishStatus($type)
    {
        if ($type == 'id') {
            return 2;
        }
        return 'Published';
    }

    public static function articleExpiredStatus($type)
    {
        if ($type == 'id') {
            return 3;
        }
        return 'Expired';
    }

    public static function draftStatus()
    {
        return 1;
    }

    public static function publishStatus()
    {
        return 2;
    }

    public static function expiredStatus()
    {
        return 3;
    }

    public static function getArticleStatuses()
    {
        return [
            ['id' => 1, 'name' => 'Draft'],
            ['id' => 2, 'name' => 'Published'],
            ['id' => 3, 'name' => 'Expired'],
        ];
    }

    public static function getWikiStatusById($id)
    {
        switch ($id) {
            case 1:
                return self::articleDraftStatus('name');
            case 2:
                return self::articlePublishStatus('name');
            case 3:
                return self::articleExpiredStatus('name');
            default:
                return self::articlePublishStatus('name');
        }
    }

    public static function organisationEnable()
    {
        return 'enable';
    }

    public static function organisationDisable()
    {
        return 'disable';
    }

    public static function getWikiStatusById2($id)
    {
        $status = Status::where('id', $id)->first();
        return $status->name ?? null;
    }

    public static function commentToDoStatus()
    {
        return 'Baru';
    }

    public static function commentDoingStatus()
    {
        return 'Dalam Tindakan';
    }

    public static function commentDoneStatus()
    {
        return 'Selesai';
    }

    public static function loginAction()
    {
        return 'login';
    }

    public static function logoutAction()
    {
        return 'logout';
    }

    public static function createAction()
    {
        return 'create';
    }

    public static function updateAction()
    {
        return 'update';
    }

    public static function statusUpdateAction()
    {
        return 'status update';
    }

    public static function deleteAction()
    {
        return 'delete';
    }

    public static function bulkUploadsAction()
    {
        return 'bulk uploads';
    }

    public static function viewAction()
    {
        return 'view';
    }

    public static function viewArticleAction()
    {
        return 'view article';
    }

    public static function viewDirectoryAction()
    {
        return 'view directory';
    }

    public static function viewChatbot()
    {
        return 'view chatbot';
    }

    public static function auditTrailActions()
    {
        return [
            'login',
            'create',
            'update',
            'delete',
            'bulk uploads',
            'view'
        ];
    }

    public static function favouriteAction()
    {
        return 'favourite';
    }

    public static function unfavouriteAction()
    {
        return 'remove favourite';
    }

    public static function readlistAction()
    {
        return 'read list';
    }

    public static function unreadlistAction()
    {
        return 'remove read list';
    }

    public static function bulkEnabledAction()
    {
        return 'bulk enabled';
    }

    public static function bulkDisabledAction()
    {
        return 'bulk disabled';
    }

    public static function migrateAction()
    {
        return 'migration';
    }

    public static function changePasswordAction()
    {
        return 'change password';
    }

    public static function sendResetLinkAction()
    {
        return 'send reset link';
    }

    public static function resetPasswordAction()
    {
        return 'reset password';
    }

    public static function uploadAction()
    {
        return 'upload';
    }

    public static function transferAction()
    {
        return 'transfer';
    }

    public static function auditTrailSubjects()
    {
        return [
            'User',
            'Wiki',
            'Nota PKP',
            self::ministrySubject(),
            self::departmentSubject(),
            self::segmentSubject(),
            self::unitSubject(),
            self::subUnitSubject(),
            self::chatbotSubject(),
            self::organisationSubject(),
            self::roleSubject(),
            self::caseCategorySubject(),
            self::subCaseCategory1Subject(),
            self::subCaseCategory2Subject(),
            self::categoryOrganisationSubject()
        ];
    }

    public static function userSubject()
    {
        return 'User';
    }

    public static function wikiSubject()
    {
        return 'Wiki';
    }

    public static function commentSubject()
    {
        return 'Nota PKP';
    }

    public static function commentDataSubject()
    {
        return 'Comment';
    }

    public static function ministrySubject()
    {
        return 'Ministry';
    }

    public static function departmentSubject()
    {
        return 'Department';
    }

    public static function segmentSubject()
    {
        return 'Segment';
    }

    public static function unitSubject()
    {
        return 'Unit';
    }

    public static function subUnitSubject()
    {
        return 'Sub Unit';
    }

    public static function chatbotSubject()
    {
        return 'Chatbot';
    }

    public static function organisationSubject()
    {
        return 'Organisation';
    }

    public static function categoryOrganisationSubject()
    {
        return 'Category Organisation';
    }

    public static function roleSubject()
    {
        return 'Role';
    }

    public static function caseCategorySubject()
    {
        return 'Case Category';
    }

    public static function subCaseCategory1Subject()
    {
        return 'Sub Case Category 1';
    }

    public static function subCaseCategory2Subject()
    {
        return 'Sub Case Category 2';
    }

    public static function getAllMonths()
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }

    public static function getOrganisationCategory($categoryName)
    {
        $categories = [
            'Ministry' => 1,
            'Department' => 2,
            'Segment' => 3,
            'Unit' => 4,
            'Sub Unit' => 5,
        ];

        return $categories[$categoryName] ?? null;
    }

    public static function getActiveStatus()
    {
        return 1;
    }

    public static function getInactiveStatus()
    {
        return 0;
    }

    public static function allWikis()
    {
        return 'allWikis';
    }

    public static function getCommentStatusColor($status)
    {
        if ($status == self::commentToDoStatus()) {
            return 'yellow';
        } elseif ($status == self::commentDoingStatus()) {
            return 'orange';
        } else {
            return 'lightgreen';
        }
    }

    public static function shortCut()
    {
        return [
            ['id' => 1, 'name' => 'Tarikh gaji penjawat awam dan Tarikh pencen pesara'],
            ['id' => 2, 'name' => 'SME'],
            ['id' => 3, 'name' => 'UTC'],
            ['id' => 4, 'name' => 'Cuti Umum'],
            ['id' => 5, 'name' => 'Takwim Persekolahan'],
            ['id' => 6, 'name' => 'Kedutaan dan Perwakilan'],
            ['id' => 7, 'name' => 'Talian Kecemasan'],
        ];
    }

    public static function getNotaPKPStatuses()
    {
        return [
            self::commentToDoStatus(),
            self::commentDoingStatus(),
            self::commentDoneStatus(),
        ];
    }

    public static function internalWiki()
    {
        return 'internal';
    }

    public static function externalWiki()
    {
        return 'external';
    }

    public static function internalUser()
    {
        return 'internal';
    }

    public static function externalUser()
    {
        return 'external';
    }

    public static function internalRole()
    {
        return 'internal';
    }

    public static function externalRole()
    {
        return 'external';
    }

    public static function determineUserType($roleId)
    {
        if (in_array($roleId, [self::userKetuaBahagian(), self::userInternalContentCreator(), self::userInternalPKPAgent()])) {
            return self::internalUser();
        } elseif (in_array($roleId, [self::userSPARK(), self::userExternalContentCreator(), self::userExternalPKPAgent()])) {
            return self::externalUser();
        } else {
            return null;
        }
    }

    public static function determineRoleType($roleId)
    {
        if (in_array($roleId, [self::userKetuaBahagian(), self::userInternalContentCreator(), self::userInternalPKPAgent()])) {
            return self::internalRole();
        } elseif (in_array($roleId, [self::userSPARK(), self::userExternalContentCreator(), self::userExternalPKPAgent()])) {
            return self::externalRole();
        } else {
            return null;
        }
    }

    public static function invalidContactNumbersChars()
    {
        return ['-', ' '];
    }

    public static function wikiTypes()
    {
        return [
            self::wikiTypeDirectory(),
            self::wikiTypeArticle(),
        ];
    }

    public static function allPKPUsers()
    {
        return [
            self::userInternalPKPAgent(),
            self::userExternalPKPAgent(),
        ];
    }

    public static function noOfDaysList()
    {
        return range(1, 31);
    }

    public static function generateColorCodeBasedOnId($id)
    {
        $hash = md5($id);
        return '#' . substr($hash, 0, 6);
    }

    public static function getNewNotaPKPEmailSubject()
    {
        return 'New Nota PKP reported.';
    }

    public static function newStatus()
    {
        return 'NEW';
    }

    public static function kbModule()
    {
        return 'kb';
    }

    public static function outgoingEmailType()
    {
        return "OUTGOING";
    }

    public static function noJabatanOrAgensi()
    {
        return 'Tiada Jabatan/Agensi';
    }

    public static function filterOutNonNumerical($string)
    {
        return preg_replace("/[^0-9]/", "", $string);
    }

    public static function getRegionName($id)
    {
        $regions = [
            1 => 'Semenanjung',
            2 => 'Sabah',
            3 => 'Sarawak',
        ];

        return $regions[$id] ?? null;
    }

    public static function getLanguageName($id)
    {
        $languages = [
            1 => 'BM',
            2 => 'EN',
        ];

        return $languages[$id] ?? null;
    }

    public static function getStatusName($id)
    {
        $statuses = [
            1 => 'Status 1',
            2 => 'Status 2',
        ];

        return $statuses[$id] ?? null;
    }

    public static function currentTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }

    public static function infoBlastArticle()
    {
        return 2;
    }

    public static function getRegionIdBasedName($name)
    {
        switch ($name) {
            case 'Semenanjung':
                return 1;
            case 'Sabah':
                return 2;
            case 'Sarawak':
                return 3;
            case '':
                return 1;
            default:
                return null;
        }
    }

    public static function getLangIdBasedName($name)
    {
        switch ($name) {
            case 'Bahasa Melayu':
                return 1;
            case 'English':
                return 2;
            default:
                return null;
        }
    }

    public static function commentToDoStatusInEn()
    {
        return 'To Do';
    }

    public static function commentDoingStatusInEn()
    {
        return 'Doing';
    }

    public static function commentDoneStatusInEn()
    {
        return 'Done';
    }

    public static function dispatchEmailNotifications($recipients, $subject, $templatePath, $others = [])
    {
        foreach ($recipients as $recipient) {
            $wiki = $others['wiki'] ?? null;
            $comment = $others['comment'] ?? null;
            $team = $others['team'] ?? null;
            $user = $others['user'] ?? null;

            $emailTemplate = new DispatchMail($subject, $wiki, $comment, $team, $recipient->name, $templatePath, $user);
            Mail::to($recipient->email, $recipient->name)
                ->queue($emailTemplate);
        }
    }

    public static function getMyGCCStaffEmail()
    {
        $myGCCStaff = User::MYGCC_STAFF;
        $myGCCStaffDetail = new User();
        $myGCCStaffDetail->email = $myGCCStaff['email'];
        $myGCCStaffDetail->name = $myGCCStaff['name'];

        return [$myGCCStaffDetail];
    }

    public static function getUnitKBaseEmail()
    {
        $unitKBase = User::UNIT_KBASE;
        $unitKBaseDetail = new User();
        $unitKBaseDetail->email = $unitKBase['email'];
        $unitKBaseDetail->name = $unitKBase['name'];

        return [$unitKBaseDetail];
    }

    public static function formatContactNumber($number)
    {
        return substr($number, 0, 2) . ' - ' . substr($number, 2, 4) . ' ' . substr($number, 6);
    }

    public static function formatMobileNumber($number)
    {
        return substr($number, 0, 3) . ' - ' . substr($number, 3, 4) . ' ' . substr($number, 7);
    }

    public static function DirectoryUploadAction()
    {
        return 'Bulk Upload';
    }

    public static function DirectoryUpdateAction()
    {
        return 'Bulk Update';
    }

    public static function auditTrailActionsList()
    {
        return [
            'login',
            self::logoutAction(),
            'create',
            'update',
            self::statusUpdateAction(),
            'delete',
            'view',
            'view article',
            'view directory',
            self::viewChatbot(),
            self::uploadAction(),
            'bulk upload',
            'bulk update',
            self::bulkEnabledAction(),
            self::bulkDisabledAction(),
            self::favouriteAction(),
            self::unfavouriteAction(),
            self::readlistAction(),
            self::unreadlistAction(),
            self::migrateAction(),
            self::changePasswordAction(),
            self::sendResetLinkAction(),
            self::resetPasswordAction()
        ];
    }

    public static function transfer()
    {
        return 'transfer';
    }

    public static function duplicate()
    {
        return 'duplicate';
    }

    public static function transferType()
    {
        return [
            self::duplicate(),
            self::transfer(),
        ];
    }

    public static function approve()
    {
        return 'Approve';
    }

    public static function reject()
    {
        return 'Reject';
    }

    public static function getArticleApprovalOptions()
    {
        return [
            self::approve(),
            self::reject()
        ];
    }

    public static function tableWikiChatbotViews()
    {
        return 'wiki_chabot_views';
    }

    public static function renameArrayKeys(array $data, array $keyMap): array
    {
        $renamedData = [];
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $keyMap)) {
                $renamedData[$keyMap[$key]] = $value;
            } else {
                $renamedData[$key] = $value;
            }
        }
        return $renamedData;
    }

    public static function getArrayChanges($oldData, $newData, $keyMap)
    {
        $formattedNewData = self::renameArrayKeys($newData, $keyMap);
        $changes = [];

        foreach ($formattedNewData as $key => $value) {
            if (array_key_exists($key, $oldData)) {
                if ($value != $oldData[$key]) {
                    $changes[$key] = [
                        'old_data' => $oldData[$key],
                        'new_data' => $value,
                    ];
                }
            }
        }

        return $changes;
    }
}
